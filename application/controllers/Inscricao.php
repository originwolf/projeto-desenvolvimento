<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Inscricao extends CI_Controller {
	function __construct(){
		parent::__construct();
		$this->load->model('participante_model', 'participante');
		$this->load->model('evento_model', 'evento');
		$this->load->model('atividade_model', 'atividade');
		$this->load->model('agenda_model', 'agenda');
		$this->load->model('inscricao_model', 'inscricao');
	}
//====================================================================================================
	public function listar(){
		verifica_login();
		verifica_permissao($this->session->dados_participante['acesso'], INSCRICOES);

		if($id_evento = $this->uri->segment(3)):
			if($evento = $this->evento->recupera_evento($id_evento)):
				$dados['evento'] = $evento;
				if($id_atividade = $this->uri->segment(4)):
					if($atividade = $this->atividade->recupera_atividade($id_atividade)):
						$dados['atividade']	= $atividade;			
						if($inscricoes = $this->inscricao->recupera_inscricoes_atividade($atividade->id_atividade)):
							$dados['inscricoes'] = $inscricoes;					
						else:
							configura_mensagem('Ninguém está INSCRITO nesta ATIVIDADE.', 'alerta');
						endif;				
					else:
						configura_mensagem('ATIVIDADE desconhecida.</br>Escolha um EVENTO e uma ATIVIDADE para listar os INCRITOS.', 'falha');
						redirect('evento/listar', 'refresh');
					endif;
				else:
					configura_mensagem('Escolha um EVENTO e uma ATIVIDADE para listar os INCRITOS.', 'falha');
					redirect('evento/listar', 'refresh');
				endif;
			else:
				configura_mensagem('EVENTO desconhecido.</br>Escolha um EVENTO e uma ATIVIDADE para listar os INCRITOS.', 'falha');
				redirect('evento/listar', 'refresh');
			endif;			
		else:
			configura_mensagem('Escolha um EVENTO e uma ATIVIDADE para listar os INCRITOS.', 'falha');
			redirect('evento/listar', 'refresh');
		endif;

		$dados['pagina'] = 'listar';
		$dados['titulo'] = 'Controle de INSCRIÇÕES';
		
		$this->load->view('inscricao', $dados);
	}
//====================================================================================================
	public function existe_inscricao($participante_id, $atividade_id){
		if ($this->inscricao->existe_inscricao($participante_id, $atividade_id)):
			return TRUE;
		else:
			return FALSE;
		endif;
	}
	//====================================================================================================
	public function data_inscricao_expirada($agenda){
		if($agenda->dia > date('Y-m-d')):
			return FALSE;
		elseif($agenda->dia == date('Y-m-d')):
			if($agenda->hora_inicio > date('H:i:s')):
				return FALSE;
			else:				
				return TRUE;
			endif;
		else:			
			return TRUE;
		endif;
	}	
}