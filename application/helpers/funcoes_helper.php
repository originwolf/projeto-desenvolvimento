<?php
defined('BASEPATH') OR exit('ACESSO RESTRITO');

if (defined('CATEGORIAS') == false) define('CATEGORIAS', 1);
if (defined('PARTICIPANTES') == false) define('PARTICIPANTES', 2);
if (defined('EVENTOS') == false) define('EVENTOS', 3);
if (defined('ATIVIDADES') == false) define('ATIVIDADES', 4);
if (defined('AGENDA') == false) define('AGENDA', 5);
if (defined('AREAS') == false) define('AREAS', 6);
if (defined('INSCRICOES') == false) define('INSCRICOES', 7);
if (defined('CHAMADAS') == false) define('CHAMADAS', 8);
if (defined('PERMISSOES') == false) define('PERMISSOES', 9);

if(!function_exists('recupera_login')):
	function recupera_login(){
		$ci = & get_instance();
		if($ci->session->dados_participante['logado'] != TRUE ||
			$ci->session->dados_participante['id_participante'] == NULL ||
			$ci->session->dados_participante['nome'] == NULL ||
			$ci->session->dados_participante['cpf'] == NULL ||
			$ci->session->dados_participante['email'] == NULL ||
			$ci->session->dados_participante['categoria_id'] == NULL ||
			$ci->session->dados_participante['acesso'] == NULL):
			return false;
		else:
			return true;
		endif;
	}
endif;

if(!function_exists('verifica_login')):
	function verifica_login($redirect='participante/login'){
		$ci = & get_instance();
		if(!recupera_login()):
			configura_mensagem('<p>Faça login ou cadastre-se</p>');
			redirect($redirect, 'refresh');
		endif;
	}
endif;

if(!function_exists('valida_login')):
	function valida_login($id, $redirect='home'){
		$ci = & get_instance();
		if($id == $ci->session->dados_participante['id_participante']):
			return TRUE;
		else:
			return FALSE;
		endif;
	}
endif;

if(!function_exists('configura_mensagem')):
	function configura_mensagem($mensagem=NULL, $layout=NULL){
		$ci = & get_instance();
		$ci->session->set_userdata('Mensagem', $mensagem);
		$ci->session->set_userdata('Layout', $layout);
	}
endif;

if(!function_exists('recupera_mensagem')):
	function recupera_mensagem($destroy=TRUE){
		$ci = & get_instance();
		$retorno['mensagem'] = $ci->session->userdata('Mensagem');
		$retorno['layout'] = $ci->session->userdata('Layout');
		if($destroy) $ci->session->unset_userdata('Mensagem');
		if($destroy) $ci->session->unset_userdata('Layout');
		return $retorno;
	}
endif;

if(!function_exists('configura_permissao')):
	function configura_permissao($acesso, $posicao, $altera){
		$ci = & get_instance();
		if($posicao==32):
			if($altera):
				return -1 * abs($acesso);
			else:
				return abs($acesso);
			endif;
		else:
			$novo_acesso = pow(2, ($posicao - 1));
			if($altera):
				return $acesso | $novo_acesso;
			else:
				return $acesso & ~ $novo_acesso;
			endif;
		endif;			
	}
endif;

if(!function_exists('recupera_permissao')):
	function recupera_permissao($acesso, $posicao){
		$ci = & get_instance();	
		if($posicao==32):			
			return ($acesso != abs($acesso));			
		else:
			$novo_acesso = pow(2, ($posicao - 1));
			if($acesso & $novo_acesso):
				return TRUE;
			else:
				return FALSE;
			endif;
		endif;				
	}
endif;

if(!function_exists('verifica_permissao')):
	function verifica_permissao($acesso, $posicao, $redirect='home'){
		$ci = & get_instance();	
		if(!recupera_permissao($acesso, $posicao)):					
			$ci->session->unset_userdata('dados_participante');
			configura_mensagem('ACESSO RESTRITO!</br>Verifique suas PERMISSÕES de acesso.', 'falha');		
			redirect($redirect, 'refresh');
		endif;			
	}
endif;

if(!function_exists('data_mysql')):
	function data_mysql($data){
		$ci = & get_instance();	
		$data = implode("-",array_reverse(explode("/", $data)));
		return $data;
	}
endif;

if(!function_exists('compara_datas')):
	function compara_datas($data_1, $data_2=NULL){
		$ci = & get_instance();
		$data_1 = data_mysql($data_1);		
		if($data_2 == NULL):
			$data_2 = date("Y-m-d");
			if ($data_2 > $data_1):
				return FALSE;
			else:
				return TRUE;
			endif;
		else:
			$data_2 = data_mysql($data_2);
			if ($data_1 > $data_2):
				return FALSE;
			else:
				return TRUE;
			endif;
		endif;	
	}
endif;

if(!function_exists('valida_data')):
	function valida_data($data){
		$ci = & get_instance();		
		$data = explode('-', $data);
		return checkdate($data[1], $data[2], $data[0]);			
	}
endif;

if(!function_exists('texto_mysql')):
	function texto_mysql($string=NULL){
		return htmlentities($string);			
	}
endif;

if(!function_exists('mysql_texto')):
	function mysql_texto($string=NULL){
		return html_entity_decode($string);			
	}
endif;
