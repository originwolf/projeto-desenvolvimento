<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Area extends CI_Controller {
	//====================================================================================================
	function __construct(){		
		parent::__construct();		
		$this->load->model('area_model', 'area');
		$this->load->model('evento_model', 'evento');
	}
	//====================================================================================================
	public function index(){		
		redirect('area/listar', 'refresh');
	}
	//====================================================================================================
	public function listar(){		
		verifica_login();		
		verifica_permissao($this->session->dados_participante['acesso'], AREAS);
		
		$dados['pagina'] = 'listar';
		$dados['titulo'] = 'Controle de ÁREAS';		
		$dados['areas'] = $this->area->recupera_areas();
		
		if(isset($dados['areas']) && sizeof($dados['areas']) > 0):			
			$this->load->view('area', $dados);		
		else:			
			configura_mensagem("Ainda não há ÁREAS cadastradas.", 'alerta');			
			$this->load->view('area', $dados);
	endif;
	}
	//====================================================================================================
	public function cadastrar(){		
		verifica_login();		
		verifica_permissao($this->session->dados_participante['acesso'], AREAS);
		
		$this->form_validation->set_rules('area', 'ÁREA', 'trim|required|callback_existe_area');
		
		if($this->form_validation->run() == FALSE):			
			if(validation_errors()):
				configura_mensagem(validation_errors(), 'falha');
			endif;		
		else:			
			$dados_formulario = $this->input->post();			
			$dados_insert['area'] = mb_strtoupper($dados_formulario['area']);			
			if($id = $this->area->salvar($dados_insert)):				
				configura_mensagem('ÁREA cadastrada com sucesso.', 'sucesso');				
				redirect('area/listar', 'refresh');			
			else:				
				configura_mensagem('A ÁREA não foi cadastrada.', 'falha');
			endif;
		endif;
		
		$dados['pagina'] = 'cadastrar';
		$dados['titulo'] = 'Cadastro de ÁREA';
		
		$this->load->view('area', $dados);
	}
	//====================================================================================================
	public function exibir(){		
		verifica_login();		
		verifica_permissao($this->session->dados_participante['acesso'], AREAS);
		
		if(($id = $this->uri->segment(3)) > 0):			
			if($area = $this->area->recupera_area($id)):				
				$dados['area'] = $area;				
				$dados_update['id_area'] = $area->id_area;			
			else:					
				configura_mensagem('ÁREA inexistente.<br>Escolha uma ÁREA para exibir.', 'falha');				
				redirect('area', 'refresh');
			endif;		
		else:			
			configura_mensagem('Escolha uma ÁREA para exibir.', 'falha');			
			redirect('area', 'refresh');
		endif;		
		
		$dados['titulo'] = 'Exibição de ÁREAS';
		$dados['pagina'] = 'exibir';
		
		$this->load->view('area', $dados);
	}
	//====================================================================================================
	public function editar(){		
		verifica_login();		
		verifica_permissao($this->session->dados_participante['acesso'], AREAS);
		
		if(($id = $this->uri->segment(3)) > 0):			
			if($area = $this->area->recupera_area($id)):				
				$dados['area'] = $area;				
				$dados_update['id_area'] = $area->id_area;			
			else:					
				configura_mensagem('ÁREA inexistente.<br>Escolha uma ÁREA para editar.', 'falha');				
				redirect('area', 'refresh');
			endif;		
		else:			
			configura_mensagem('Escolha uma ÁREA para editar.', 'falha');			
			redirect('area', 'refresh');
		endif;
		
		$this->form_validation->set_rules('area', 'ÁREA', 'trim|required|callback_existe_area');		
		if($this->form_validation->run() == FALSE):			
			if(validation_errors()):
				configura_mensagem(validation_errors(), 'falha');
			endif;		
		else:			
			$dados_formulario = $this->input->post();			
			$dados_update['area'] = mb_strtoupper($dados_formulario['area']);			
			if ($this->area->salvar($dados_update)):				
				configura_mensagem('ÁREA alterada com sucesso.', 'sucesso');				
				redirect('area/exibir/' . $area->id_area, 'refresh');			
			else:				
				configura_mensagem('Nenhuma alteração foi realizada.', 'falha');
			endif;
		endif;
		
		$dados['titulo'] = 'Edição de ÁREAS';
		$dados['pagina'] = 'editar';
		
		$this->load->view('area', $dados);
	}
	//====================================================================================================
	public function excluir(){		
		verifica_login();		
		verifica_permissao($this->session->dados_participante['acesso'], AREAS);
		
		if(($id = $this->uri->segment(3)) > 0):			
			if($area = $this->area->recupera_area($id)):				
				$dados['area'] = $area;
				configura_mensagem('Confirma a exclusão deste REGISTRO?', 'alerta');			
			else:				
				configura_mensagem('ÁREA inexistente.<br>Escolha uma ÁREA para excluir.', 'falha');				
				redirect('area/listar', 'refresh');
			endif;		
		else:			
			configura_mensagem('Escolha uma ÁREA para excluir.', 'falha');			
			redirect('area/listar', 'refresh');
		endif;
		$this->form_validation->set_rules('enviar', 'Excluir', 'trim|required');		
		if($this->form_validation->run() == FALSE):			
			if(validation_errors()):
				configura_mensagem(validation_errors(), 'falha');
			endif;		
		else:
			if($this->existe_eventos_area($id)):				
				if($this->area->excluir($id)):					
					configura_mensagem('ÁREA excluída com sucesso.', 'sucesso');					
					redirect('area/listar', 'refresh');				
				else:					
					configura_mensagem('A ÁREA não foi excluída.', 'falha');
				endif;
			else:
				configura_mensagem('Para excluir esta ÁREA é necessário excluir todos os EVENTOS que a usam.', 'falha');
				redirect('area/listar', 'refresh');
			endif;
		endif;
		
		$dados['titulo'] = 'Exclusão de ÁREAS';
		$dados['pagina'] = 'excluir';
		
		$this->load->view('area', $dados);
	}
	//====================================================================================================
	public function existe_area($area){		
		$this->form_validation->set_message('existe_area', 'Esta area já está cadastrada.');		
		if ($this->area->existe_area($area)) {
			return true;
		} else {
			return false;
		}
	}
	//====================================================================================================
	public function existe_eventos_area($id){		
		if($this->evento->existe_eventos_area($id)):		
			return true;			
		else:		
			return false;
		endif;
	}
	//====================================================================================================
}