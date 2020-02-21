<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Atividade extends CI_Controller {
	//====================================================================================================
	function __construct(){		
		parent::__construct();		
		$this->load->model('evento_model', 'evento');
		$this->load->model('atividade_model', 'atividade');		
		$this->load->model('agenda_model', 'agenda');
	}
	//====================================================================================================
	public function index(){		
		redirect('evento/listar', 'refresh');
	}
	//====================================================================================================
	public function listar(){
		verifica_login();
		verifica_permissao($this->session->dados_participante['acesso'], ATIVIDADES);

		if(($id = $this->uri->segment(3)) > 0):
			if($evento = $this->evento->recupera_evento($id)):
				$dados['evento'] = $evento;
				if($atividades = $this->atividade->recupera_atividades_evento($dados['evento']->id_evento)):
					$dados['atividades'] = $atividades;
					foreach ($dados['atividades'] as $atividade):
						if($agenda = $this->agenda->recupera_agenda_atividade($atividade->id_atividade)):
							$atividade->agenda = $agenda;
						endif;
					endforeach;
				else:
					configura_mensagem('Ainda não há ATIVIDADES cadastradas para este EVENTO.', 'alerta');
				endif;
			else:
				configura_mensagem('EVENTO inexistente.</br>Escolha um EVENTO para visualizar suas ATIVIDADES.', 'falha');
				redirect('evento/listar', 'refresh');
			endif;
		else:
			configura_mensagem('Escolha um EVENTO para listar as ATIVIDADES.', 'falha');
			redirect('evento/listar', 'refresh');
		endif;	
		
		$dados['pagina'] = 'listar';
		$dados['titulo'] = 'Controle de ATIVIDADES';
		
		$this->load->view('atividade', $dados);
	}
	//====================================================================================================
	public function cadastrar(){		
		verifica_login();		
		verifica_permissao($this->session->dados_participante['acesso'], ATIVIDADES);
		
		if(($id = $this->uri->segment(3)) > 0):				
			if($evento = $this->evento->recupera_evento($id)):
				$dados['id_evento'] = $evento->id_evento;
				$dados['evento'] = $evento;							
			else:					
				configura_mensagem('EVENTO inexistente.</br>Escolha um EVENTO para cadastrar nova ATIVIDADE.', 'falha');	
				redirect('evento/listar', 'refresh');
			endif;		
		else:			
			configura_mensagem('Escolha um EVENTO para para cadastrar nova ATIVIDADE.', 'falha');			
			redirect('evento/listar', 'refresh');
		endif;
		
		$this->form_validation->set_rules('atividade', 'ATIVIDADE', 'trim|required|callback_existe_atividade['. $evento->id_evento .']');
		$this->form_validation->set_rules('local', 'LOCAL', 'trim|required');
		$this->form_validation->set_rules('vagas', 'VAGAS', 'trim|required');		
		
		if($this->form_validation->run() == FALSE):			
			if(validation_errors()):
				configura_mensagem(validation_errors(), 'falha');
			endif;		
		else:			
			$dados_formulario = $this->input->post();
			
			$dados_insert['atividade'] = mb_strtoupper($dados_formulario['atividade']);
			$dados_insert['descricao'] = texto_mysql(mb_strtoupper($dados_formulario['descricao']));
			$dados_insert['local'] = mb_strtoupper($dados_formulario['local']);
			$dados_insert['vagas'] = mb_strtoupper($dados_formulario['vagas']);
			$dados_insert['evento_id'] = $evento->id_evento;			
			
			if($id = $this->atividade->salvar($dados_insert)):				
				configura_mensagem('ATIVIDADE cadastrada com sucesso.</br>Cadastre a AGENDA', 'sucesso');
				$id_atividade = $id;				
				redirect('agenda/cadastrar/' . $evento->id_evento . '/' . $id_atividade, 'refresh');			
			else:				
				configura_mensagem('A ATIVIDADE não foi cadastrada.', 'falha');				
			endif;
		endif;
		
		$dados['pagina'] = 'cadastrar';
		$dados['titulo'] = 'Cadastro de ATIVIDADES';		
		
		$this->load->view('atividade', $dados);
	}
	//====================================================================================================
	public function exibir(){		
		verifica_login();		
		verifica_permissao($this->session->dados_participante['acesso'], ATIVIDADES);

		if(($id = $this->uri->segment(3)) > 0):			
			if($atividade = $this->atividade->recupera_atividade($id)):				
				$dados['atividade'] = $atividade;				
				$dados['evento'] = $this->evento->recupera_evento($atividade->evento_id);
				$dados_update['id_atividade'] = $atividade->id_atividade;
				$dados_update['evento_id'] = $atividade->evento_id;								
			else:					
				configura_mensagem('ATIVIDADE inexistente.<br>Escolha uma ATIVIDADE para editar.', 'falha');				
				redirect('atividade/listar/' . $atividade->evento_id, 'refresh');
			endif;			
		else:			
			configura_mensagem('Escolha uma ATIVIDADE para editar.', 'falha');			
			redirect('atividade/listar/' . $atividade->evento_id, 'refresh');
		endif;
		
		$dados['pagina'] = 'exibir';
		$dados['titulo'] = 'Exibição de ATIVIDADE';		
		
		$this->load->view('atividade', $dados);
	}
	//====================================================================================================
	public function editar(){		
		verifica_login();		
		verifica_permissao($this->session->dados_participante['acesso'], ATIVIDADES);

		if(($id = $this->uri->segment(3)) > 0):			
			if($atividade = $this->atividade->recupera_atividade($id)):				
				$dados['atividade'] = $atividade;				
				$dados['evento'] = $this->evento->recupera_evento($atividade->evento_id);
				$dados_update['id_atividade'] = $atividade->id_atividade;
				$dados_update['evento_id'] = $atividade->evento_id;								
			else:					
				configura_mensagem('ATIVIDADE inexistente.<br>Escolha uma ATIVIDADE para editar.', 'falha');				
				redirect('atividade/listar/' . $atividade->evento_id, 'refresh');
			endif;			
		else:			
			configura_mensagem('Escolha uma ATIVIDADE para editar.', 'falha');			
			redirect('atividade/listar/' . $atividade->evento_id, 'refresh');
		endif;
		
		$this->form_validation->set_rules('atividade', 'ATIVIDADE', 'trim|required');
		$this->form_validation->set_rules('local', 'LOCAL', 'trim|required');
		$this->form_validation->set_rules('vagas', 'VAGAS', 'trim|required');
		
		if($this->form_validation->run() == FALSE):			
			if(validation_errors()):
				configura_mensagem(validation_errors(), 'falha');
			endif;		
		else:			
			$dados_formulario = $this->input->post();
			
			$dados_update['atividade'] = mb_strtoupper($dados_formulario['atividade']);
			$dados_update['descricao'] = texto_mysql(mb_strtoupper($dados_formulario['descricao']));
			$dados_update['local'] = mb_strtoupper($dados_formulario['local']);
			$dados_update['vagas'] = $dados_formulario['vagas'];			
			
			if($id = $this->atividade->salvar($dados_update)):				
				configura_mensagem('ATIVIDADE editada com sucesso.', 'sucesso');				
				redirect('atividade/exibir/' . $atividade->id_atividade, 'refresh');			
			else:				
				configura_mensagem('A ATIVIDADE não foi editada.', 'falha');
			endif;
		endif;
		
		$dados['pagina'] = 'editar';
		$dados['titulo'] = 'Edição de ATIVIDADE';		
		
		$this->load->view('atividade', $dados);
	}
	//====================================================================================================
	public function excluir(){		
		verifica_login();		
		verifica_permissao($this->session->dados_participante['acesso'], ATIVIDADES);
		
		if(($id = $this->uri->segment(3)) > 0):			
			if($atividade = $this->atividade->recupera_atividade($id)):				
				$dados['atividade'] = $atividade;				
				$dados['evento'] = $this->evento->recupera_evento($atividade->evento_id);
				configura_mensagem('Confirma a exclusão deste REGISTRO?', 'alerta');							
			else:					
				configura_mensagem('ATIVIDADE inexistente.<br>Escolha uma ATIVIDADE para excluir.', 'falha');				
				redirect('atividade/listar/' . $atividade->evento_id, 'refresh');
			endif;			
		else:			
			configura_mensagem('Escolha uma ATIVIDADE para excluir.', 'falha');			
			redirect('atividade/listar/' . $atividade->evento_id, 'refresh');
		endif;
		
		$this->form_validation->set_rules('enviar', 'Excluir', 'trim|required');		
		if($this->form_validation->run() == FALSE):			
			if(validation_errors()):
				configura_mensagem(validation_errors(), 'falha');
			endif;		
		else:	
			if($this->existe_agendas_atividade($id)):				
				if($id = $this->atividade->excluir($id)):					
					configura_mensagem('ATIVIDADE excluida com sucesso.', 'sucesso');					
					redirect('atividade/listar/' . $atividade->evento_id, 'refresh');				
				else:					
					configura_mensagem('A ATIVIDADE não foi excluída.', 'falha');
				endif;
			else:
				configura_mensagem('Para excluir esta ATIVIDADE é necessário excluir todas as AGENDAS que a usam.', 'falha');
				redirect('atividade/listar/' . $atividade->evento_id, 'refresh');
			endif;
		endif;
		
		$dados['pagina'] = 'excluir';
		$dados['titulo'] = 'Edição de ATIVIDADE';		
		
		$this->load->view('atividade', $dados);
	}
	//====================================================================================================
	public function existe_atividade($atividade, $id_evento){	
		$this->form_validation->set_message('existe_atividade', 'Esta ATIVIDADE já está cadastrada.');		
		if ($this->atividade->existe_atividade($atividade, $id_evento)) {
			return TRUE;
		} else {
			return FALSE;
		}
	}
	//====================================================================================================
		public function existe_agendas_atividade($id){		
		if($this->agenda->existe_agendas_atividade($id)):		
			return true;			
		else:		
			return false;
		endif;
	}
	//====================================================================================================
}