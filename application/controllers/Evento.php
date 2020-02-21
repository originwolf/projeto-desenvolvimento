<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Evento extends CI_Controller {
	//====================================================================================================
	function __construct(){		
		parent::__construct();
		
		$this->load->model('evento_model', 'evento');
		$this->load->model('area_model', 'area');
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
		verifica_permissao($this->session->dados_participante['acesso'], EVENTOS);
		
		$dados['pagina'] = 'listar';
		$dados['titulo'] = 'Controle de EVENTOS';		
		$dados['eventos'] = $this->evento->recupera_eventos();
		
		if(isset($dados['eventos']) && sizeof($dados['eventos']) > 0):			
			$this->load->view('evento', $dados);		
		else:			
			configura_mensagem("Ainda não há EVENTOS cadastrados.", 'alerta');			
			$this->load->view('evento', $dados);
		endif;
	}
	//====================================================================================================
	public function cadastrar(){		
		verifica_login();		
		verifica_permissao($this->session->dados_participante['acesso'], EVENTOS);
		
		$this->form_validation->set_rules('evento', 'EVENTO', 'trim|required|callback_existe_evento');
		$this->form_validation->set_rules('inicio', 'DATA INÍCIO', 'trim|required|callback_valida_data_inicio');
		$this->form_validation->set_rules('termino', 'DATA TÉRMINO', 'trim|required|callback_valida_data_termino');
		$this->form_validation->set_rules('area', 'ÁREA', 'required');
		
		if($this->form_validation->run() == FALSE):			
			if(validation_errors()):
				configura_mensagem(validation_errors(), 'falha');
			endif;		
		else:			
			$dados_formulario = $this->input->post();		
			if(!compara_datas($dados_formulario['inicio'], $dados_formulario['termino'])):
				configura_mensagem('A DATA TÉRMINO não pode ser inferior à DATA INÍCIO.', 'falha');
			else:			
				$dados_insert['evento'] = mb_strtoupper($dados_formulario['evento']);
				$dados_insert['descricao'] = texto_mysql(mb_strtoupper($dados_formulario['descricao']));
				$dados_insert['data_inicio'] = data_mysql($dados_formulario['inicio']);
				$dados_insert['data_termino'] = data_mysql($dados_formulario['termino']);
				$dados_insert['area_id'] = $dados_formulario['area'];
						
				if($id = $this->evento->salvar($dados_insert)):				
					configura_mensagem('EVENTO cadastrado com sucesso.', 'sucesso');				
					redirect('evento/listar', 'refresh');			
				else:				
					configura_mensagem('O EVENTO não foi cadastrado.', 'falha');
				endif;
			endif;
		endif;
		
		$dados['pagina'] = 'cadastrar';
		$dados['titulo'] = 'Cadastro de EVENTO';
		$dados['areas'] = $this->area->recupera_areas();
		
		$this->load->view('evento', $dados);
	}
	//====================================================================================================
		public function exibir(){		
		verifica_login();		
		verifica_permissao($this->session->dados_participante['acesso'], EVENTOS);
		
		if(($id = $this->uri->segment(3)) > 0):		
			if($evento = $this->evento->recupera_evento($id)):				
				$dados['evento'] = $evento;				
				$dados_update['id_evento'] = $evento->id_evento;								
			else:					
				configura_mensagem('EVENTO inexistente.<br>Escolha um EVENTO para editar.', 'falha');		
				redirect('evento/listar', 'refresh');
			endif;			
		else:			
			configura_mensagem('Escolha um EVENTO para editar.', 'falha');			
			redirect('evento/listar', 'refresh');
		endif;
				
		$dados['pagina'] = 'exibir';
		$dados['titulo'] = 'Exibição de EVENTO';
		$dados['areas'] = $this->area->recupera_areas();
		
		$this->load->view('evento', $dados);
	}
	//====================================================================================================
	public function editar(){		
		verifica_login();		
		verifica_permissao($this->session->dados_participante['acesso'], EVENTOS);
		
		if(($id = $this->uri->segment(3)) > 0):		
			if($evento = $this->evento->recupera_evento($id)):				
				$dados['evento'] = $evento;				
				$dados_update['id_evento'] = $evento->id_evento;								
			else:					
				configura_mensagem('EVENTO inexistente.<br>Escolha um EVENTO para editar.', 'falha');				
				redirect('evento/listar', 'refresh');
			endif;			
		else:			
			configura_mensagem('Escolha um EVENTO para editar.', 'falha');			
			redirect('evento/listar', 'refresh');
		endif;
		
		$this->form_validation->set_rules('evento', 'EVENTO', 'trim|required');
		$this->form_validation->set_rules('data_inicio', 'DATA INÍCIO', 'trim|required|callback_valida_data_inicio');
		$this->form_validation->set_rules('data_termino', 'DATA TÉRMINO', 'trim|required|callback_valida_data_termino');
		$this->form_validation->set_rules('area', 'ÁREA', 'required');
		
		if($this->form_validation->run() == FALSE):			
			if(validation_errors()):
				configura_mensagem(validation_errors(), 'falha');
			endif;		
		else:			
			$dados_formulario = $this->input->post();
			
			if(compara_datas($dados_formulario['data_termino'], $dados_formulario['data_inicio'])):
				configura_mensagem('A DATA TÉRMINO não pode ser inferior à Data Início.', 'falha');
			endif;
			
			$dados_update['evento'] = mb_strtoupper($dados_formulario['evento']);
			$dados_update['descricao'] = texto_mysql(mb_strtoupper($dados_formulario['descricao']));
			$dados_update['data_inicio'] = data_mysql($dados_formulario['data_inicio']);
			$dados_update['data_termino'] = data_mysql($dados_formulario['data_termino']);
			$dados_update['area_id'] = $dados_formulario['area'];
						
			if($id = $this->evento->salvar($dados_update)):				
				configura_mensagem('EVENTO editado com sucesso.', 'sucesso');
				redirect('evento/exibir/' . $evento->id_evento, 'refresh');							
			else:				
				configura_mensagem('O EVENTO não foi editado.', 'falha');
			endif;
		endif;
		
		$dados['pagina'] = 'editar';
		$dados['titulo'] = 'Edição de EVENTO';
		$dados['areas'] = $this->area->recupera_areas();
		
		$this->load->view('evento', $dados);
	}
	//====================================================================================================
	public function excluir(){		
		verifica_login();		
		verifica_permissao($this->session->dados_participante['acesso'], EVENTOS);
		
		if(($id = $this->uri->segment(3)) > 0):			
			if($evento = $this->evento->recupera_evento($id)):				
				$dados['evento'] = $evento;
				configura_mensagem('Confirma a exclusão deste REGISTRO?', 'alerta');			
			else:				
				configura_mensagem('EVENTO inexistente.<br>Escolha um EVENTO para excluir.', 'falha');				
				redirect('evento/listar', 'refresh');
			endif;		
		else:			
			configura_mensagem('Escolha um EVENTO para excluir.', 'falha');			
			redirect('evento/listar', 'refresh');
		endif;

		$this->form_validation->set_rules('enviar', 'Excluir', 'trim|required');
		
		if($this->form_validation->run() == FALSE):			
			if(validation_errors()):
				configura_mensagem(validation_errors(), 'falha');
			endif;		
		else:
			if($this->existe_atividades_evento($id)):				
				if($this->evento->excluir($id)):					
					configura_mensagem('EVENTO excluído com sucesso.', 'sucesso');					
					redirect('evento/listar', 'refresh');				
				else:					
					configura_mensagem('O EVENTO não foi excluído.', 'falha');
				endif;
			else:
				configura_mensagem('Para excluir este EVENTO é necessário excluir todas as ATIVIDADES que o usam.', 'falha');
				redirect('evento/listar', 'refresh');
			endif;
		endif;
		
		$dados['pagina'] = 'excluir';
		$dados['titulo'] = 'Exclusão de EVENTO';		
		$dados['areas'] = $this->area->recupera_areas();
		
		$this->load->view('evento', $dados);
	}
		//====================================================================================================
	public function publicar(){		
		verifica_login();		
		verifica_permissao($this->session->dados_participante['acesso'], EVENTOS);
		
		if(($id_evento = $this->uri->segment(3)) > 0):		
			if($evento = $this->evento->recupera_evento($id_evento)):
				$dados['evento'] = $evento;
				if($evento->publicar == TRUE):
					$publicar = FALSE;
					if($id = $this->evento->publicar($id_evento, $publicar)):				
						configura_mensagem('EVENTO despublicado com sucesso.', 'sucesso');
						redirect('evento/exibir/' . $id_evento, 'refresh');						
					else:				
						configura_mensagem('O EVENTO não foi alterado.', 'falha');
					endif;
				else:					
					if($atividades = $this->atividade->recupera_atividades_evento($id_evento)):
						$agenda_cadastrada = TRUE;
						foreach ($atividades as $atividade):
							$agenda = $this->agenda->recupera_agenda_atividade($atividade->id_atividade);
							if(isset($agenda) && sizeof($agenda) > 0):
								
							else:
								$agenda_cadastrada = FALSE;
							endif;
						endforeach;
						if ($agenda_cadastrada == TRUE):
							$publicar = TRUE;
					
							if($id = $this->evento->publicar($id_evento, $publicar)):				
								configura_mensagem('EVENTO publicado com sucesso.', 'sucesso');
								redirect('evento/exibir/' . $id_evento, 'refresh');
							else:				
								configura_mensagem('O EVENTO não foi alterado.', 'falha');
							endif;							
						else:
							configura_mensagem('Não é possível pulblicar EVENTOS sem que todas as suas ATIVIDADES possuam AGENDAS cadastradas.', 'falha');
						endif;
					else:
						configura_mensagem('Não é possível publicar EVENTOS que não possuam ATIVIDADES cadastradas.', 'falha');
					endif;						
				endif;
			else:					
				configura_mensagem('EVENTO inexistente.<br>Escolha um EVENTO para publicar.', 'falha');				
				redirect('evento/listar', 'refresh');
			endif;
		else:					
			configura_mensagem('EVENTO inexistente.<br>Escolha um EVENTO para publicar.', 'falha');				
			redirect('evento/listar', 'refresh');
		endif;			
				
		$dados['pagina'] = 'exibir';
		$dados['titulo'] = 'Exibição de EVENTO';
		$dados['areas'] = $this->area->recupera_areas();
		
		$this->load->view('evento', $dados);
	}
	//====================================================================================================
	public function existe_evento($evento){		
		$this->form_validation->set_message('existe_evento', 'Este EVENTO já está cadastrado.');
		
		if ($this->evento->existe_evento($evento)) {
			return TRUE;
		} else {
			return FALSE;
		}
	}
	//====================================================================================================
	public function valida_data_inicio($data){		
		if(empty($data)):
			$this->form_validation->set_message('valida_data_inicio', 'O campo DATA INÍCIO é obrigatório.');
			return FALSE;
		elseif(strlen($data) != 10):
			$this->form_validation->set_message('valida_data_inicio', 'Verifique a quantidade de dígitos no campo DATA INÍCIO.');
			return FALSE;
		elseif (!valida_data(data_mysql($data))):
				$this->form_validation->set_message('valida_data_inicio','Valor no campo DATA INÍCIO não é uma data válida.', 'falha');
				return FALSE;
		elseif (!compara_datas($data)):
			$this->form_validation->set_message('valida_data_inicio', 'A DATA INÍCIO não pode ser inferior a data de hoje.');
			return FALSE;
		else:
			return TRUE;
		endif;
	}
	//====================================================================================================
	public function valida_data_termino($data){
		if(empty($data)):
			$this->form_validation->set_message('valida_data_termino', 'O campo DATA TÉRMINO é obrigatório.');
			return FALSE;
		elseif(strlen($data) != 10):
			$this->form_validation->set_message('valida_data_termino', 'Verifique a quantidade de dígitos no campo DATA TÉRMINO.');
			return FALSE;
		elseif (!valida_data(data_mysql($data))):
				$this->form_validation->set_message('valida_data_termino','Valor no campo DATA TÉRMINO não é uma data válida.', 'falha');
				return FALSE;
		elseif (!compara_datas($data)):
			$this->form_validation->set_message('valida_data_termino', 'A DATA TÉRMINO não pode ser inferior a data de hoje.');
			return FALSE;
		else:
			return TRUE;
		endif;
	}
	//====================================================================================================
	public function existe_atividades_evento($id){		
		if($this->atividade->existe_atividades_evento($id)):		
			return true;			
		else:		
			return false;
		endif;
	}
	//====================================================================================================
}