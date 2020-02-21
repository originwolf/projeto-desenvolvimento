<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Agenda extends CI_Controller {
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
		verifica_permissao($this->session->dados_participante['acesso'], AGENDA);

		if(($id = $this->uri->segment(3)) > 0):
			if($atividade = $this->atividade->recupera_atividade($id)):
				$dados['atividade'] = $atividade;
				if($evento = $this->evento->recupera_evento($atividade->evento_id)):
					$dados['evento'] = $evento;
					if($agendas = $this->agenda->recupera_agenda_atividade($id)):
						$dados['agendas'] = $agendas;
					else:
						configura_mensagem('Ainda não há AGENDA cadastrada para esta ATIVIDADE.', 'alerta');
					endif;
				else:
					configura_mensagem('EVENTO desconhecido.</br>Escolha um EVENTO e uma ATIVIDADE para listar a AGENDA.', 'falha');
					redirect('evento/listar', 'refresh');
				endif;
			else:
				configura_mensagem('ATIVIDADE desconhecida.</br>Escolha um EVENTO e uma ATIVIDADE para listar a AGENDA.', 'falha');
				redirect('evento/listar', 'refresh');
			endif;
		else:
			configura_mensagem('Escolha um EVENTO e uma ATIVIDADE para listar a AGENDA.', 'falha');
			redirect('evento/listar', 'refresh');
		endif;
		$dados['pagina'] = 'listar';
		$dados['titulo'] = 'Controle de AGENDA';
		
		$this->load->view('agenda', $dados);
	}
	//====================================================================================================
	public function cadastrar(){		
		verifica_login();		
		verifica_permissao($this->session->dados_participante['acesso'], AGENDA);
		
		if(($id = $this->uri->segment(3)) > 0):			
			if($evento = $this->evento->recupera_evento($id)):
				$dados['id_evento'] = $evento->id_evento;
				$dados['evento'] = $evento;							
			else:					
				configura_mensagem('EVENTO inexistente.</br>Escolha um EVENTO e uma ATIVIDADE para cadastrar nova AGENDA.', 'falha');				
				redirect('evento/listar', 'refresh');
			endif;
			if(($id = $this->uri->segment(4)) > 0):			
				if($atividade = $this->atividade->recupera_atividade($id)):
					$dados['id_atividade'] = $atividade->id_atividade;
					$dados['atividade'] = $atividade;							
				else:					
					configura_mensagem('ATIVIDADE inexistente.</br>Escolha uma ATIVIDADE para cadastrar nova AGENDA.', 'falha');				
					redirect('atividade/listar', 'refresh');
				endif;		
			else:			
				configura_mensagem('Escolha uma ATIVIDADE para cadastrar nova AGENDA.', 'falha');			
				redirect('atividade/listar', 'refresh');
			endif;		
		else:			
			configura_mensagem('Escolha um EVENTO e uma ATIVIDADE para cadastrar nova AGENDA.', 'falha');		
			redirect('evento/listar', 'refresh');
		endif;
	
		$this->form_validation->set_rules('dia', 'DIA', 'trim|required|callback_valida_dia');
		$this->form_validation->set_rules('hora_inicio', 'HORA INÍCIO', 'trim|required|callback_valida_hora_inicio');
		$this->form_validation->set_rules('hora_termino', 'HORA TÉRMINO', 'trim|required|callback_valida_hora_termino');		
		
		if($this->form_validation->run() == FALSE):			
			if(validation_errors()):
				configura_mensagem(validation_errors(), 'falha');
			endif;		
		else:			
			$dados_formulario = $this->input->post();
			
			$dados_insert['dia'] = data_mysql($dados_formulario['dia']);
			$dados_insert['hora_inicio'] = $dados_formulario['hora_inicio'];
			$dados_insert['hora_termino'] = $dados_formulario['hora_termino'];
			$dados_insert['atividade_id'] = $atividade->id_atividade;
			$dados_insert['evento_id'] = $evento->id_evento;

			if(data_mysql($dados_insert['dia']) < data_mysql($evento->data_inicio)):
				configura_mensagem('A AGENDA não pode ser inferior à data início do EVENTO.', 'falha');				
			elseif(data_mysql($dados_insert['dia']) > data_mysql($evento->data_termino)):
				configura_mensagem('A AGENDA não pode ser superior à data término do EVENTO.', 'falha');				
			elseif($dados_insert['hora_termino'] < $dados_insert['hora_inicio']):
				configura_mensagem('O horário término não pode ser inferior ao horário início.', 'falha');				
			elseif($this->existe_agenda($atividade->id_atividade, data_mysql($dados_formulario['dia']),$dados_formulario['hora_inicio'], $dados_formulario['hora_termino'])):
				configura_mensagem('Já existe AGENDA neste horário.', 'falha');					
			else:				
				if($id = $this->agenda->salvar($dados_insert)):					
					configura_mensagem('AGENDA cadastrada com sucesso.', 'sucesso');			
					redirect('agenda/listar/' . $atividade->id_atividade, 'refresh');				
				else:				
					configura_mensagem('A AGENDA não foi cadastrada.', 'falha');				
				endif;
			endif;
		endif;
		
		$dados['pagina'] = 'cadastrar';	
		$dados['titulo'] = 'Cadastro de AGENDA';		
	
		$this->load->view('agenda', $dados);
	}
	//====================================================================================================
	public function exibir(){	
		verifica_login();		
		verifica_permissao($this->session->dados_participante['acesso'], AGENDA);
	
		if(($id = $this->uri->segment(3)) > 0):
			
			if($evento = $this->evento->recupera_evento($id)):
				$dados['id_evento'] = $evento->id_evento;
				$dados['evento'] = $evento;
				$dados_update['evento_id'] = $evento->id_evento;							
			else:					
				configura_mensagem('EVENTO inexistente.</br>Escolha um EVENTO e uma ATIVIDADE para exibir uma AGENDA.', 'falha');				
				redirect('evento/listar', 'refresh');
			endif;

			if(($id = $this->uri->segment(4)) > 0):			
				if($atividade = $this->atividade->recupera_atividade($id)):
					$dados['id_atividade'] = $atividade->id_atividade;
					$dados['atividade'] = $atividade;
					$dados_update['atividade_id'] = $atividade->id_atividade;							
				else:					
					configura_mensagem('ATIVIDADE inexistente.</br>Escolha uma ATIVIDADE para exibir uma AGENDA.', 'falha');				
					redirect('atividade/listar/' . $evento->id_evento, 'refresh');
				endif;
			
				if(($id = $this->uri->segment(5)) > 0):				
					if($agenda = $this->agenda->recupera_agenda($id)):
						$dados['id_agenda'] = $agenda->id_agenda;
						$dados['agenda'] = $agenda;
						$dados_update['id_agenda'] = $agenda->id_agenda;								
					else:						
						configura_mensagem('Escolha uma AGENDA para exibir.', 'falha');					
						redirect('agenda/listar/' . $atividade->id_atividade, 'refresh');
					endif;			
				endif;		
			endif;		
		endif;	
		
		$dados['pagina'] = 'exibir';
		$dados['titulo'] = 'Exibição de AGENDA';		
		
		$this->load->view('agenda', $dados);
	}
	//====================================================================================================
	public function editar(){	
		verifica_login();		
		verifica_permissao($this->session->dados_participante['acesso'], AGENDA);
	
		if(($id = $this->uri->segment(3)) > 0):
			
			if($evento = $this->evento->recupera_evento($id)):
				$dados['id_evento'] = $evento->id_evento;
				$dados['evento'] = $evento;
				$dados_update['evento_id'] = $evento->id_evento;							
			else:					
				configura_mensagem('EVENTO inexistente.</br>Escolha um EVENTO e uma ATIVIDADE para editar uma AGENDA.', 'falha');				
				redirect('evento/listar', 'refresh');
			endif;

			if(($id = $this->uri->segment(4)) > 0):			
				if($atividade = $this->atividade->recupera_atividade($id)):
					$dados['id_atividade'] = $atividade->id_atividade;
					$dados['atividade'] = $atividade;
					$dados_update['atividade_id'] = $atividade->id_atividade;							
				else:					
					configura_mensagem('ATIVIDADE inexistente.</br>Escolha uma ATIVIDADE para editar uma AGENDA.', 'falha');				
					redirect('atividade/listar/' . $evento->id_evento, 'refresh');
				endif;
			
				if(($id = $this->uri->segment(5)) > 0):				
					if($agenda = $this->agenda->recupera_agenda($id)):
						$dados['id_agenda'] = $agenda->id_agenda;
						$dados['agenda'] = $agenda;
						$dados_update['id_agenda'] = $agenda->id_agenda;								
					else:						
						configura_mensagem('Escolha uma AGENDA para editar.', 'falha');					
						redirect('agenda/listar/' . $atividade->id_atividade, 'refresh');
					endif;			
				endif;		
			endif;		
		endif;
	
		$this->form_validation->set_rules('dia', 'DIA', 'trim|required');
		$this->form_validation->set_rules('hora_inicio', 'HORA INÍCIO', 'trim|required');
		$this->form_validation->set_rules('hora_termino', 'HORA TÉRMINO', 'trim|required');		
		
		if($this->form_validation->run() == FALSE):			
			if(validation_errors()):
				configura_mensagem(validation_errors(), 'falha');
			endif;
		else:
		
			$dados_formulario = $this->input->post();
		
			$dados_update['dia'] = data_mysql($dados_formulario['dia']);
			$dados_update['hora_inicio'] = $dados_formulario['hora_inicio'];
			$dados_update['hora_termino'] = $dados_formulario['hora_termino'];
		
			if($id = $this->agenda->salvar($dados_update)):			
				configura_mensagem('AGENDA editada com sucesso.', 'sucesso');						
				redirect('agenda/exibir/' . $evento->id_evento . '/' . $atividade->id_atividade . '/' . $agenda->id_agenda, 'refresh');			
			else:				
				configura_mensagem('A AGENDA não foi editada.', 'falha');
			endif;
		endif;
		
		$dados['pagina'] = 'editar';
		$dados['titulo'] = 'Edição de AGENDA';		
		
		$this->load->view('agenda', $dados);
	}
	//====================================================================================================
	public function excluir(){	
		verifica_login();		
		verifica_permissao($this->session->dados_participante['acesso'], AGENDA);
	
		if(($id = $this->uri->segment(3)) > 0):
			
			if($evento = $this->evento->recupera_evento($id)):
				$dados['id_evento'] = $evento->id_evento;
				$dados['evento'] = $evento;
				configura_mensagem('Confirma a exclusão deste REGISTRO?', 'alerta');											
			else:					
				configura_mensagem('EVENTO inexistente.</br>Escolha um EVENTO e uma ATIVIDADE para editar uma AGENDA.', 'falha');				
				redirect('evento/listar', 'refresh');
			endif;

			if(($id = $this->uri->segment(4)) > 0):			
				if($atividade = $this->atividade->recupera_atividade($id)):
					$dados['id_atividade'] = $atividade->id_atividade;
					$dados['atividade'] = $atividade;							
				else:					
					configura_mensagem('ATIVIDADE inexistente.</br>Escolha uma ATIVIDADE para editar uma AGENDA.', 'falha');				
					redirect('atividade/listar/' . $evento->id_evento, 'refresh');
				endif;
			
				if(($id = $this->uri->segment(5)) > 0):				
					if($agenda = $this->agenda->recupera_agenda($id)):
						$dados['id_agenda'] = $agenda->id_agenda;
						$dados['agenda'] = $agenda;								
					else:						
						configura_mensagem('Escolha uma AGENDA para editar.', 'falha');					
						redirect('agenda/listar/' . $atividade->id_atividade, 'refresh');
					endif;			
				endif;		
			endif;		
		endif;
	
		$this->form_validation->set_rules('enviar', 'Excluir', 'trim|required');
	
		if($this->form_validation->run() == FALSE):			
			if(validation_errors()):
				configura_mensagem(validation_errors(), 'falha');
			endif;		
		else:		
			if($id = $this->agenda->excluir($agenda->id_agenda)):			
				configura_mensagem('AGENDA editada com sucesso.', 'sucesso');			
				redirect('agenda/listar/' . $atividade->id_atividade, 'refresh');			
			else:				
				configura_mensagem('A AGENDA não foi editada.', 'falha');
			endif;
		endif;
		
		$dados['pagina'] = 'excluir';
		$dados['titulo'] = 'Exclusão de AGENDA';		
		
		$this->load->view('agenda', $dados);
	}
	//====================================================================================================
	public function valida_dia($data){		
		if(empty($data)):
			$this->form_validation->set_message('valida_dia', 'O campo DIA é obrigatório.');
			return FALSE;
		elseif(strlen($data) != 10):
			$this->form_validation->set_message('valida_dia', 'Verifique a quantidade de dígitos no campo DIA.');
			return FALSE;
		elseif (!valida_data(data_mysql($data))):
				$this->form_validation->set_message('valida_dia','Valor no campo DIA não é uma data válida.', 'falha');
				return FALSE;
		elseif (!compara_datas($data)):
			$this->form_validation->set_message('valida_dia', 'A data no campo DIA não pode ser inferior a data de hoje.');
			return FALSE;
		else:
			return TRUE;
		endif;
	}
	//====================================================================================================
	public function valida_hora_inicio($hora){		
		if(empty($hora)):
			$this->form_validation->set_message('valida_hora_inicio', 'O campo HORA INÍCIO é obrigatório.');
			return FALSE;
		elseif(strlen($hora) != 5):
			$this->form_validation->set_message('valida_hora_inicio', 'Campo HORA INÍCIO preenchido incorretamente.');
			return FALSE;
		elseif(!preg_match('/^([0-1][0-9]|2[0-3]):([0-5][0-9])$/', $hora)):
			$this->form_validation->set_message('valida_hora_inicio', 'Dígitos no campo HORA INÍCIO não corresponde a um horário válido.');
			return FALSE;
		else:
			return TRUE;
		endif;
	}
	//====================================================================================================
	public function valida_hora_termino($hora){		
		if(empty($hora)):
			$this->form_validation->set_message('valida_hora_termino', 'O campo HORA TÉRMINO é obrigatório.');
			return FALSE;
		elseif(strlen($hora) != 5):
			$this->form_validation->set_message('valida_hora_termino', 'Campo HORA TÉRMINO preenchido incorretamente.');
			return FALSE;
		elseif(!preg_match('/^([0-1][0-9]|2[0-3]):([0-5][0-9])$/', $hora)):
			$this->form_validation->set_message('valida_hora_termino', 'Dígitos no campo HORA TÉRMINO não corresponde a um horário válido.');
			return FALSE;		
		else:
			return TRUE;
		endif;
	}
	//====================================================================================================
	public function existe_agenda($id_atividade, $dia, $hora_inicio, $hora_termino){
		if ($this->agenda->existe_agenda($id_atividade, $dia, $hora_inicio, $hora_termino)) {
			return true;
		} else {
			return false;
		}
	}
	//====================================================================================================
}