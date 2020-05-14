<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Categoria extends CI_Controller {
	//====================================================================================================
	function __construct(){		
		parent::__construct();
		
		$this->load->model('categoria_model', 'categoria');
		$this->load->model('participante_model', 'participante');
	}
	//====================================================================================================
	public function index(){		
		redirect('categoria/listar', 'refresh');
	}
	//====================================================================================================
	public function listar(){		
		verifica_login();		
		verifica_permissao($this->session->dados_participante['acesso'], CATEGORIAS);
		
		$dados['pagina'] = 'listar';
		$dados['titulo'] = 'Controle de CATEGORIAS';
		
		$dados['categorias'] = $this->categoria->recupera_categorias();
		
		if(isset($dados['categorias']) && sizeof($dados['categorias']) > 0):	
			$this->load->view('categoria', $dados);		
		else:			
			configura_mensagem("Ainda não há CATEGORIAS cadastradas.", 'alerta');			
			$this->load->view('categoria', $dados);
	endif;
	}
	//====================================================================================================
	public function cadastrar(){		
		verifica_login();		
		verifica_permissao($this->session->dados_participante['acesso'], CATEGORIAS);
				
		$this->form_validation->set_rules('categoria', 'CATEGORIA', 'trim|required|callback_existe_categoria');		
		if($this->form_validation->run() == FALSE):			
			if(validation_errors()):
				configura_mensagem(validation_errors(), 'falha');
			endif;		
		else:			
			$dados_formulario = $this->input->post();			
			$dados_insert['categoria'] = mb_strtoupper($dados_formulario['categoria']);			
			if($id = $this->categoria->salvar($dados_insert)):				
				configura_mensagem('CATEGORIA cadastrada com sucesso.', 'sucesso');
				redirect('categoria/listar', 'refresh');							
			else:				
				configura_mensagem('A CATEGORIA não foi cadastrada.', 'falha');
			endif;
		endif;
		
		$dados['pagina'] = 'cadastrar';
		$dados['titulo'] = 'Cadastro de CATEGORIA';
		
		$this->load->view('categoria', $dados);
	}
	//====================================================================================================
		public function exibir(){		
		verifica_login();		
		verifica_permissao($this->session->dados_participante['acesso'], CATEGORIAS);		
		if(($id = $this->uri->segment(3)) > 0):			
			if($categoria = $this->categoria->recupera_categoria($id)):				
				$dados['categoria'] = $categoria;				
				$dados_update['id_categoria'] = $categoria->id_categoria;			
			else:					
				configura_mensagem('CATEGORIA inexistente.<br>Escolha uma CATEGORIA para exibir.', 'falha');
				redirect('categoria', 'refresh');
			endif;		
		else:			
			configura_mensagem('Escolha uma CATEGORIA para exibir.', 'falha');			
			redirect('categoria', 'refresh');
		endif;
						
		$dados['titulo'] = 'Exibição de CATEGORIA';
		$dados['pagina'] = 'exibir';
		
		$this->load->view('categoria', $dados);
	}
	//====================================================================================================
	public function editar(){		
		verifica_login();		
		verifica_permissao($this->session->dados_participante['acesso'], CATEGORIAS);		
		if(($id = $this->uri->segment(3)) > 0):			
			if($categoria = $this->categoria->recupera_categoria($id)):				
				$dados['categoria'] = $categoria;				
				$dados_update['id_categoria'] = $categoria->id_categoria;			
			else:					
				configura_mensagem('CATEGORIA inexistente.<br>Escolha uma CATEGORIA para editar.', 'falha');	
				redirect('categoria', 'refresh');
			endif;		
		else:			
			configura_mensagem('Escolha uma CATEGORIA para editar.', 'falha');			
			redirect('categoria', 'refresh');
		endif;
		
		$this->form_validation->set_rules('categoria', 'CATEGORIA', 'trim|required|callback_existe_categoria');		
		if($this->form_validation->run() == FALSE):			
			if(validation_errors()):
				configura_mensagem(validation_errors(), 'falha');
			endif;		
		else:			
			$dados_formulario = $this->input->post();			
			$dados_update['categoria'] = mb_strtoupper($dados_formulario['categoria']);			
			if ($this->categoria->salvar($dados_update)):				
				configura_mensagem('CATEGORIA alterada com sucesso.', 'sucesso');
				redirect('categoria/exibir/' . $categoria->id_categoria, 'refresh');			
			else:				
				configura_mensagem('Nenhuma alteração foi realizada.', 'falha');
			endif;
		endif;
		
		$dados['titulo'] = 'Edição de CATEGORIA';
		$dados['pagina'] = 'editar';
		
		$this->load->view('categoria', $dados);
	}
	//====================================================================================================
	public function excluir(){		
		verifica_login();		
		verifica_permissao($this->session->dados_participante['acesso'], CATEGORIAS);
		
		if(($id = $this->uri->segment(3)) > 0):			
			if($categoria = $this->categoria->recupera_categoria($id)):				
				$dados['categoria'] = $categoria;
				configura_mensagem('Confirmar a exclusão deste REGISTRO?', 'alerta');
			else:				
				configura_mensagem('CATEGORIA inexistente.<br>Escolha uma CATEGORIA para excluir.', 'falha');
				redirect('categoria/listar', 'refresh');
			endif;		
		else:			
			configura_mensagem('Escolha uma CATEGORIA para excluir.', 'falha');			
			redirect('categoria/listar', 'refresh');
		endif;
		
		$this->form_validation->set_rules('enviar', 'Excluir', 'trim|required');
		
		if($this->form_validation->run() == FALSE):			
			if(validation_errors()):
				configura_mensagem(validation_errors(), 'falha');
			endif;		
		else:
			if($this->existe_participantes_categoria($id)):				
				if($this->categoria->excluir($id)):					
					configura_mensagem('CATEGORIA excluída com sucesso.', 'sucesso');					
					redirect('categoria/listar', 'refresh');				
				else:					
					configura_mensagem('A CATEGORIA não foi excluída.', 'falha');
				endif;
			else:
				configura_mensagem('Para excluir esta CATEGORIA é necessário excluir todos os PARTICIPANTES que a usam.', 'falha');
				redirect('categoria/listar', 'refresh');
			endif;
		endif;
		
		$dados['titulo'] = 'Exclusão de CATEGORIA';
		$dados['pagina'] = 'excluir';
		
		$this->load->view('categoria', $dados);
	}
	//====================================================================================================
	public function existe_categoria($categoria){		
		$this->form_validation->set_message('existe_categoria', 'Esta categoria já está cadastrada.');
		
		if ($this->categoria->existe_categoria($categoria)):
			return true;			
		else:		
			return false;
		endif;
	}
	//====================================================================================================
	public function existe_participantes_categoria($id){		
		if($this->participante->existe_participantes_categoria($id)):		
			return true;			
		else:		
			return false;
		endif;
	}
	//====================================================================================================
}