<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Chamada extends CI_Controller {
	//====================================================================================================
	function __construct(){		
		parent::__construct();		
		$this->load->model('participante_model', 'participante');
		$this->load->model('evento_model', 'evento');
		$this->load->model('atividade_model', 'atividade');
		$this->load->model('agenda_model', 'agenda');
		$this->load->model('inscricao_model', 'inscricao');
		$this->load->model('chamada_model', 'chamada');
	}
	//====================================================================================================
	public function index(){		
		redirect('chamada/listar', 'refresh');
	}
	//====================================================================================================
	public function listar(){		
		verifica_login();		
		verifica_permissao($this->session->dados_participante['acesso'], CHAMADAS);

		if($id_evento = $this->uri->segment(3)):
			if($evento = $this->evento->recupera_evento($id_evento)):
				$dados['evento'] = $evento;
				if($id_atividade = $this->uri->segment(4)):
					if($atividade = $this->atividade->recupera_atividade($id_atividade)):
						$dados['atividade'] = $atividade;
						$dados['agenda'] = 	$this->agenda->recupera_agenda_atividade($id_atividade);
						foreach ($dados['agenda'] as $data):
							$data->presencas = $this->chamada->verifica_presenca_total($data->id_agenda);	
						endforeach;
						if($inscritos = $this->inscricao->recupera_participantes_inscritos($id_atividade)):
							foreach ($inscritos as $inscrito):
								$inscrito->chamada = $this->chamada->recupera_chamadas_inscricao($inscrito->id_inscricao);
							endforeach;
							$dados['inscritos'] = $inscritos;							
						else:
							configura_mensagem('ATIVIDADE ainda sem PARTICIPANTES inscritos.', 'alerta');
							//redirect('atividade/listar/' . $evento->id_evento, 'refresh');
						endif;
					else:
						configura_mensagem('ATIVIDADE desconhecida.</br>Escolha uma ATIVIDADE para ver a CHAMADA.', 'falha');
						redirect('atividade/listar/' . $evento->id_evento, 'refresh');
					endif;						
				else:
					configura_mensagem('Escolha uma ATIVIDADE para ver a CHAMADA.', 'falha');
					redirect('atividade/listar/' . $evento->id_evento, 'refresh');									
				endif;
			else:
				configura_mensagem('EVENTO desconhecido.</br>Escolha um EVENTO e uma ATIVIDADE para ver a CHAMADA.', 'falha');
				redirect('evento/listar', 'refresh');
			endif;
		else:
			configura_mensagem('Escolha um EVENTO e uma ATIVIDADE para ver a CHAMADA.', 'falha');
			//redirect('evento/listar', 'refresh');
		endif;
		
		$dados['pagina'] = 'listar';
		$dados['titulo'] = 'Controle de CHAMADAS';

		$this->load->view('chamada', $dados);
	}
	//====================================================================================================
	public function editar(){		
		verifica_login();		
		verifica_permissao($this->session->dados_participante['acesso'], CHAMADAS);

		$dados_formulario = $this->input->post();

		$id_evento = $dados_formulario['id_evento'];
		$dados['eventos'] = $this->evento->recupera_evento($id_evento);

		$id_atividade = $dados_formulario['id_atividade'];
		$dados['atividades'] = $this->atividade->recupera_atividade($id_atividade);
		
		if(isset($dados_formulario['id_presenca'])):		
			$dados_update['id_chamada'] = $dados_formulario['id_presenca'];
			$dados_update['presenca'] = TRUE;			
		else:
			$dados_update['id_chamada'] = $dados_formulario['id_ausencia'];
			$dados_update['presenca'] = FALSE;			
		endif;
		
		if($this->chamada->salvar($dados_update)):
			redirect('chamada/listar/' . $id_evento . '/' . $id_atividade,'refresh');
		else:
			configura_mensagem('Não foi possível realializar a chamada para este participante.', 'falha');
			redirect('chamada/listar/' . $id_evento . '/' . $id_atividade,'refresh');			
		endif;
		
		$dados['pagina'] = 'exibir';
		$dados['titulo'] = 'Exibição de EVENTO';
		$dados['areas'] = $this->area->recupera_areas();
		
		$this->load->view('evento', $dados);
	}
	//====================================================================================================
	public function presenca_total(){		
		verifica_login();		
		verifica_permissao($this->session->dados_participante['acesso'], CHAMADAS);

		$dados_formulario = $this->input->post();

		$id_evento = $dados_formulario['id_evento'];
		$id_atividade = $dados_formulario['id_atividade'];
		$id_agenda = $dados_formulario['id_agenda'];

		if(isset($dados_formulario['total'])):
			$presenca = TRUE;
		else:
			$presenca = FALSE;
		endif;
		
		if($this->chamada->chamada_total($id_agenda, $presenca)):
			redirect('chamada/listar/' . $id_evento . '/' . $id_atividade,'refresh');
		else:
			configura_mensagem('Não foi possível realializar a chamada total para esta atividade.', 'falha');
			redirect('chamada/listar/' . $id_evento . '/' . $id_atividade,'refresh');			
		endif;		
	}
	//====================================================================================================
	public function verifica_presenca_total($id_agenda){
		if($this->chamada->verifica_presenca_total($id_agenda)):
			return TRUE;
		else:
			return TRUE;
		endif;	
	}
	//====================================================================================================	
}