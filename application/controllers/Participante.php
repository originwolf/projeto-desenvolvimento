<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Participante extends CI_Controller {
//====================================================================================================
	function __construct(){
		parent::__construct();

		$this->load->model('participante_model', 'participante');		
		$this->load->model('categoria_model', 'categoria');
		$this->load->model('evento_model', 'evento');
	}
//====================================================================================================
	public function index(){
		$dados['pagina'] = 'login';
		$dados['titulo'] = 'ACESSO AO SISTEMA';
		
		$this->load->view('participante', $dados);		
	}
//====================================================================================================
	public function login(){
		$this->form_validation->set_rules('email', 'EMAIL', 'required|valid_email');
		$this->form_validation->set_rules('senha', 'SENHA', 'required');

		if($this->form_validation->run() == FALSE):	
			if(validation_errors()):				
				configura_mensagem(validation_errors(), 'falha');
			endif;
		else:	
			$dados_formulario = $this->input->post();
	
			$email = $dados_formulario['email'];
			$senha = md5($dados_formulario['senha']);
			$dados_participante = $this->participante->login($email, $senha);

			if ($dados_participante):
				$this->session->set_userdata('dados_participante', $dados_participante);		
				redirect('home', 'refresh');
			else:		
				configura_mensagem('EMAIL ou SENHA inválidos.', 'falha');
			endif;
		endif;

		$dados['pagina'] = 'login';
		$dados['titulo'] = 'ACESSO AO SISTEMA';		
		
		$this->load->view('participante', $dados);		
	}
//====================================================================================================
	public function logout(){
		$this->session->unset_userdata('dados_participante');
		$dados['eventos'] =  $this->evento->recupera_eventos_publicados();
		// $dados['titulo'] = 'IF EVENTOS';		
		$dados['pagina'] = 'home';
		
		$this->load->view('home', $dados);	
	}
//====================================================================================================
	public function listar(){
		verifica_login();	
		verifica_permissao($this->session->dados_participante['acesso'], PARTICIPANTES);

		$dados['pagina'] = 'listar';
		$dados['titulo'] = 'Controle de PARTICIPANTES';

		$dados['participantes'] = $this->participante->recupera_participantes();
		if(isset($dados['participantes']) && sizeof($dados['participantes']) > 0):	
			$this->load->view('participante', $dados);
	else:		
		configura_mensagem('Ainda não há PARTICIPANTES cadastrados.', 'alerta');		
		$this->load->view('participante', $dados);
	endif;
}
//====================================================================================================
public function cadastrar(){
	$this->form_validation->set_rules('nome', 'NOME', 'trim|required|callback_existe_nome');
	$this->form_validation->set_rules('cpf', 'CPF', 'trim|required|min_length[14]|max_length[14]|callback_valida_cpf|callback_existe_cpf');
	$this->form_validation->set_rules('email', 'EMAIL', 'trim|required|valid_email|callback_existe_email');
	$this->form_validation->set_rules('celular', 'CELULAR', 'trim|min_length[16]|max_length[16]');
	$this->form_validation->set_rules('telefone', 'TELEFONE', 'trim|min_length[14]|max_length[14]');
	$this->form_validation->set_rules('categoria', 'CATEGORIA', 'required');
	$this->form_validation->set_rules('senha', 'SENHA', 'trim|required|min_length[5]');
	$this->form_validation->set_rules('confirmar_senha', 'CONFIRMAR SENHA', 'trim|required|matches[senha]');

	if($this->form_validation->run() == FALSE):		
		if(validation_errors()):
			configura_mensagem(validation_errors(), 'falha');
		endif;
	else:
		$dados_formulario = $this->input->post();

		$dados_insert['nome'] = mb_strtoupper($dados_formulario['nome']);
		$dados_insert['cpf'] = $dados_formulario['cpf'];
		$dados_insert['email'] = mb_strtolower($dados_formulario['email']);
		$dados_insert['celular'] = $dados_formulario['celular'];
		$dados_insert['telefone'] = $dados_formulario['telefone'];
		$dados_insert['categoria_id'] = $dados_formulario['categoria'];	
		$dados_insert['senha'] = md5($dados_formulario['senha']);			

		if($id = $this->participante->salvar($dados_insert)):
			if(recupera_permissao($this->session->dados_participante['acesso'], PARTICIPANTES)):
				configura_mensagem('PARTICIPANTE cadastrado com sucesso.', 'sucesso');			
				redirect('participante/listar', 'refresh');
			else:			
				configura_mensagem('PARTICIPANTE já pode se logar no sistema.', 'sucesso');			
				redirect('participante/login', 'refresh');
			endif;		
		else:		
			configura_mensagem('PARTICIPANTE não foi cadastrado.', 'falha');
		endif;
	endif;

	$dados['pagina'] = 'cadastrar';
	$dados['titulo'] = 'Cadastro de Participante';
	$dados['categorias'] = $this->categoria->recupera_categorias();

	$this->load->view('participante', $dados);
}
//====================================================================================================
public function exibir(){
	verifica_login();

	if(($id = $this->uri->segment(3)) > 0):
		if(!valida_login($id)):
			verifica_permissao($this->session->dados_participante['acesso'], PARTICIPANTES);
		endif;

		if($participante = $this->participante->recupera_participante($id)):		
			$dados['participante'] = $participante;		
			$dados_update['id_participante'] = $participante->id_participante;		
		else:			
			configura_mensagem('PARTICIPANTE inexistente.<br>Escolha um PARTICIPANTE para exibir.', 'falha');		
			redirect('participante/listar', 'refresh');
		endif;	
	else:	
		configura_mensagem('Escolha um PARTICIPANTE para exibir.', 'falha');	
		redirect('participante/listar', 'refresh');
	endif;
	
	$dados['pagina'] = 'exibir';
	$dados['titulo'] = 'Exibição de PARTICIPANTE';
	$dados['categorias'] = $this->categoria->recupera_categorias();
	
	$this->load->view('participante', $dados);
}
//====================================================================================================
public function editar(){
	verifica_login();

	if(($id = $this->uri->segment(3)) > 0):
		if(!valida_login($id)):
			verifica_permissao($this->session->dados_participante['acesso'], PARTICIPANTES);
		endif;

		if($participante = $this->participante->recupera_participante($id)):		
			$dados['participante'] = $participante;		
			$dados_update['id_participante'] = $participante->id_participante;		
		else:			
			configura_mensagem('PARTICIPANTE inexistente.<br>Escolha um PARTICIPANTE para editar.', 'falha');
			redirect('participante/listar', 'refresh');
		endif;	
	else:	
		configura_mensagem('Escolha um PARTICIPANTE para editar.', 'falha');	
		redirect('participante/listar', 'refresh');
	endif;
		
	if(isset($_POST['nome']) && $_POST['nome'] != $participante->nome):
		$this->form_validation->set_rules('nome', 'NOME', 'trim|required|callback_existe_nome');
	endif;
	if(isset($_POST['cpf']) && $_POST['cpf'] != $participante->cpf):
		$this->form_validation->set_rules('cpf', 'CPF', 'trim|required|min_length[14]|max_length[14]|callback_valida_cpf|callback_existe_cpf');
	endif;
	if(isset($_POST['email']) && $_POST['email'] != $participante->email):
		$this->form_validation->set_rules('email', 'EMAIL', 'trim|required|valid_email|callback_existe_email');
	endif;
	$this->form_validation->set_rules('celular', 'CELULAR', 'trim|min_length[16]|max_length[16]');
	$this->form_validation->set_rules('telefone', 'TELEFONE', 'trim|min_length[14]|max_length[14]');
	$this->form_validation->set_rules('categoria', 'CATEGORIA', 'required');	
	if(isset($_POST['senha']) && $_POST['senha'] != ''):
		$this->form_validation->set_rules('senha', 'SENHA', 'trim|required|min_length[5]');
		$this->form_validation->set_rules('confirmar_senha', 'CONFIRMAR SENHA', 'trim|required|matches[senha]');
	endif;

	if($this->form_validation->run() == FALSE):	
		if(validation_errors()):
			configura_mensagem(validation_errors(), 'falha');
		endif;	
	else:
		$dados_formulario = $this->input->post();

		$dados_update['nome'] = mb_strtoupper($dados_formulario['nome']);
		$dados_update['cpf'] = $dados_formulario['cpf'];
		$dados_update['email'] = mb_strtolower($dados_formulario['email']);
		$dados_update['celular'] = $dados_formulario['celular'];
		$dados_update['telefone'] = $dados_formulario['telefone'];
		$dados_update['categoria_id'] = $dados_formulario['categoria'];
		if(isset($dados_formulario['senha']) && $dados_formulario['senha'] != ''):
			$dados_update['senha'] = md5($dados_formulario['senha']);
		endif;

		if($id = $this->participante->salvar($dados_update)):		
			configura_mensagem('PARTICIPANTE editado com sucesso.', 'sucesso');
			redirect('participante/exibir/' . $participante->id_participante, 'refresh');				
		else:		
			configura_mensagem('PARTICIPANTE não foi editado.', 'falha');
		endif;
	endif;

	$dados['pagina'] = 'editar';
	$dados['titulo'] = 'Edição de PARTICIPANTE';
	$dados['categorias'] = $this->categoria->recupera_categorias();

	$this->load->view('participante', $dados);
}
//====================================================================================================
public function excluir(){
	verifica_login();
	verifica_permissao($this->session->dados_participante['acesso'], PARTICIPANTES);

	if(($id = $this->uri->segment(3)) > 0):		
		if($participante = $this->participante->recupera_participante($id)):		
			$dados['participante'] = $participante;
			configura_mensagem('Confirma a exclusão deste REGISTRO?', 'alerta');		
		else:			
			configura_mensagem('PARTICIPANTE inexistente.<br>Escolha um PARTICIPANTE para excluir.', 'falha');	
			redirect('participante/listar', 'refresh');
		endif;
	else:	
		configura_mensagem('Escolha um PARTICIPANTE para excluir.', 'falha');	
		redirect('participante/listar', 'refresh');
	endif;

	$this->form_validation->set_rules('enviar', 'Excluir', 'trim|required');	

	if($this->form_validation->run() == FALSE):	
		if(validation_errors()):
			configura_mensagem(validation_errors(), 'falha');
		endif;
	else:
		if($this->participante->excluir($id)):		
			configura_mensagem('PARTICIPANTE excluído com sucesso.', 'sucesso');		
			redirect('participante/listar', 'refresh');
		else:		
			configura_mensagem('O PARTICIPANTE não foi excluído.', 'falha');
		endif;
	endif;

	$dados['pagina'] = 'excluir';
	$dados['titulo'] = 'Exclusão de PARTICIPANTE';
	$dados['categorias'] = $this->participante->recupera_participantes();

	$this->load->view('participante', $dados);
}
//====================================================================================================
public function permitir(){
	verifica_login();
	verifica_permissao($this->session->dados_participante['acesso'], PERMISSOES);

	if(($id = $this->uri->segment(3)) > 0):	
		if($participante = $this->participante->recupera_participante($id)):		
			$dados['participante'] = $participante;		
			$dados_update['id_participante'] = $participante->id_participante;		
		else:			
			configura_mensagem('PARTICIPANTE inexistente.<br>Escolha um PARTICIPANTE para editar.', 'falha');	
			redirect('participante/listar', 'refresh');
		endif;	
	else:	
		configura_mensagem('Escolha um PARTICIPANTE para editar.', 'falha');	
		redirect('participante/listar', 'refresh');
	endif;
	$this->form_validation->set_rules('enviar', 'Salvar', 'trim|required');
	if($this->form_validation->run() == FALSE):	
		if(validation_errors()):
			configura_mensagem(validation_errors(), 'falha');
		endif;
	else:
		$dados_formulario = $this->input->post();

		$dados_update['acesso'] = 0;
		if(isset($dados_formulario['categorias'])):
			$dados_update['acesso'] = configura_permissao($dados_update['acesso'], CATEGORIAS, TRUE);		
		else:
			$dados_update['acesso'] = configura_permissao($dados_update['acesso'], CATEGORIAS, FALSE);		
		endif;
		if(isset($dados_formulario['participantes'])):
			$dados_update['acesso'] = configura_permissao($dados_update['acesso'], PARTICIPANTES, TRUE);		
		else:
			$dados_update['acesso'] = configura_permissao($dados_update['acesso'], PARTICIPANTES, FALSE);		
		endif;
		if(isset($dados_formulario['eventos'])):
			$dados_update['acesso'] = configura_permissao($dados_update['acesso'], EVENTOS, TRUE);		
		else:
			$dados_update['acesso'] = configura_permissao($dados_update['acesso'], EVENTOS, FALSE);		
		endif;
		if(isset($dados_formulario['atividades'])):
			$dados_update['acesso'] = configura_permissao($dados_update['acesso'], ATIVIDADES, TRUE);		
		else:
			$dados_update['acesso'] = configura_permissao($dados_update['acesso'], ATIVIDADES, FALSE);		
		endif;
		if(isset($dados_formulario['agenda'])):
			$dados_update['acesso'] = configura_permissao($dados_update['acesso'], AGENDA, TRUE);		
		else:
			$dados_update['acesso'] = configura_permissao($dados_update['acesso'], AGENDA, FALSE);		
		endif;
		if(isset($dados_formulario['areas'])):
			$dados_update['acesso'] = configura_permissao($dados_update['acesso'], AREAS, TRUE);		
		else:
			$dados_update['acesso'] = configura_permissao($dados_update['acesso'], AREAS, FALSE);		
		endif;
		if(isset($dados_formulario['inscricoes'])):
			$dados_update['acesso'] = configura_permissao($dados_update['acesso'], INSCRICOES, TRUE);		
		else:
			$dados_update['acesso'] = configura_permissao($dados_update['acesso'], INSCRICOES, FALSE);		
		endif;
		if(isset($dados_formulario['chamadas'])):
			$dados_update['acesso'] = configura_permissao($dados_update['acesso'], CHAMADAS, TRUE);		
		else:
			$dados_update['acesso'] = configura_permissao($dados_update['acesso'], CHAMADAS, FALSE);	
		endif;
		if(isset($dados_formulario['permissoes'])):
			$dados_update['acesso'] = configura_permissao($dados_update['acesso'], PERMISSOES, TRUE);	
		else:
			$dados_update['acesso'] = configura_permissao($dados_update['acesso'], PERMISSOES, FALSE);	
		endif;						

		if($id = $this->participante->salvar($dados_update)):		
			configura_mensagem('PERMISSÕES configurada com sucesso.', 'sucesso');		
			redirect('participante/listar/', 'refresh');
		else:		
			configura_mensagem('Não foi possível configurar as permissões.', 'falha');
			redirect('participante/exibir/', 'refresh');
		endif;
	endif;	

	$dados['pagina'] = 'permitir';
	$dados['titulo'] = 'Configuração de PERMISSÕES';	

	$this->load->view('participante', $dados);
}
//====================================================================================================
public function existe_nome($nome){
	$this->form_validation->set_message('existe_nome', 'Este NOME já está cadastrado.');

	if ($this->participante->existe_nome($nome)) {
		return true;
	} else {
		return false;
	}
}
//====================================================================================================
public function existe_cpf($cpf){

	$this->form_validation->set_message('existe_cpf', 'Este CPF já está cadastrado.');

	if ($this->participante->existe_cpf($cpf)) {
		return true;
	} else {
		return false;
	}
}
//====================================================================================================
public function existe_email($email){
	
	$this->form_validation->set_message('existe_email', 'Este EMAIL já está cadastrado.');
	
	if ($this->participante->existe_email($email)) {
		return true;
	} else {
		return false;
	}
}
//====================================================================================================
public function valida_cpf($cpf) {
// Verifica se um número foi informado
	if(empty($cpf)) {
		$this->form_validation->set_message('valida_cpf', 'O campo CPF é obrigatório.');
		return false;
	}
// Elimina possivel mascara
	$cpf = preg_replace("([^0-9])", '', $cpf);
	$cpf = str_pad($cpf, 11, '0', STR_PAD_LEFT);
// Verifica se o numero de digitos informados é igual a 11 
	if (strlen($cpf) != 11) {
		$this->form_validation->set_message('valida_cpf', 'Dígitos no campo CPF não corresponde a um CPF. ' . $cpf);
		return false;
	}
// Verifica se nenhuma das sequências invalidas abaixo 
// foi digitada. Caso afirmativo, retorna falso
	else if ($cpf == '00000000000' || 
		$cpf == '11111111111' || 
		$cpf == '22222222222' || 
		$cpf == '33333333333' || 
		$cpf == '44444444444' || 
		$cpf == '55555555555' || 
		$cpf == '66666666666' || 
		$cpf == '77777777777' || 
		$cpf == '88888888888' || 
		$cpf == '99999999999') {
		$this->form_validation->set_message('valida_cpf', 'Dígitos no campo CPF não corresponde a um CPF válido.');
	return false;
 // Calcula os digitos verificadores para verificar se o
 // CPF é válido
} else {   
	for ($t = 9; $t < 11; $t++) {
		for ($d = 0, $c = 0; $c < $t; $c++) {
			$d += $cpf{$c} * (($t + 1) - $c);
		}
		$d = ((10 * $d) % 11) % 10;
		if ($cpf{$c} != $d) {
			$this->form_validation->set_message('valida_cpf', 'CPF inválido.');
			return false;
		}
	} 
	return true;
}
}
//====================================================================================================
public function recupera_categorias(){	
	$dados_categorias['categorias'] = $this->categoria->recupera_categorias();
	return $dados_categorias;
}
//====================================================================================================
}