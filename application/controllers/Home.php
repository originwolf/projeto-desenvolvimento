<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Home extends CI_Controller {
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
		$dados['eventos'] =  $this->evento->recupera_eventos_publicados();
		$dados['pagina'] = 'home';
		// $dados['titulo'] = 'SISTEMA CONTROLADOR DE EVENTOS ACADÊMICOS';

		$this->load->view('home', $dados);			
	}
	//====================================================================================================
	public function listar_eventos(){		
		verifica_login();		
		
		$dados['pagina'] = 'listar_eventos';
		$dados['titulo'] = 'EVENTOS';
		$dados['eventos'] =  $this->evento->recupera_eventos_publicados();
						
		if(!isset($dados['eventos'])):			
			configura_mensagem("Ainda não há EVENTOS publicados.", 'alerta');			
		endif;
		$this->load->view('home', $dados);					
	}
		//====================================================================================================
	public function listar_atividades(){
		verifica_login();

		if(($id_evento = $this->uri->segment(3)) > 0):
			if($evento = $this->evento->recupera_evento($id_evento)):
				$dados['evento'] = $evento;
				if($atividades = $this->atividade->recupera_atividades_evento($dados['evento']->id_evento)):
					$dados['atividades'] = $atividades;					
					foreach ($dados['atividades'] as $atividade):
						if ($this->existe_inscricao($this->session->dados_participante['id_participante'], $atividade->id_atividade)):
							$atividade->inscrito = TRUE;
							$dados['inscricao'] = $this->inscricao->recupera_inscricao_participante_atividade($this->session->dados_participante['id_participante'], $atividade->id_atividade);			
						else:
							$atividade->inscrito = FALSE;
        				endif;
        				$atividade->inscritos = $this->inscricao->conta_inscritos_atividade($atividade->id_atividade);	
						if($agenda = $this->agenda->recupera_agenda_atividade($atividade->id_atividade)):
							$atividade->agenda = $agenda;
						else:
							//configura_mensagem('Alguma(s) ATIVIDADE(S) ainda não tem AGENDA cadastrada.', 'alerta');
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
		
		$dados['pagina'] = 'listar_atividades';
		$dados['titulo'] = 'ATIVIDADES';
		
		$this->load->view('home', $dados);					
	}
	//====================================================================================================
	public function listar_inscricoes(){
		verifica_login();		

		if(($id_participante = $this->uri->segment(3)) > 0):
			if(!valida_login($id_participante)):
				verifica_permissao($this->session->dados_participante['acesso'], INSCRICOES);
			endif;
			$dados['id_participante'] = $id_participante;
			if($inscricoes = $this->inscricao->recupera_inscricoes_participante($id_participante)):
				$dados['inscricoes'] = $inscricoes;
				foreach ($dados['inscricoes'] as  $inscricao):
					$inscricao->evento = $this->evento->recupera_evento($inscricao->evento_id);
					$inscricao->atividade = $this->atividade->recupera_atividade($inscricao->atividade_id);
					$inscricao->atividade->agenda = $this->agenda->recupera_agenda_atividade($inscricao->atividade_id);
				endforeach;					
			else:
				configura_mensagem('PARTICIPANTE não está inscrito em qualquer ATIVIDADE.', 'alerta');
				//redirect('home', 'refresh');
			endif;
		else:
			configura_mensagem('PARTICIPANTE desconhecido.</br>Faça o LOGIN novamente.', 'falha');
			redirect('home', 'refresh');
		endif;
				
		$dados['pagina'] = 'listar_inscricoes';
		$dados['titulo'] = 'INSCRIÇÕES';
		
		$this->load->view('home', $dados);					
	}
	//====================================================================================================
	public function inscrever(){
		verifica_login();

		if(($id_evento = $this->uri->segment(3)) > 0):
			$evento = $this->evento->recupera_evento($id_evento);
			$dados['evento'] = $evento;
			if(($id_atividade = $this->uri->segment(4)) > 0):
				$atividade = $this->atividade->recupera_atividade($id_atividade);
				$inscritos = $this->inscricao->conta_inscritos_atividade($id_atividade);
				if($inscritos >= $atividade->vagas):
					configura_mensagem('Vagas esgotadas para esta ATIVIDADE.', 'falha');
					redirect('home/listar_atividades/' . $evento->id_evento,'refresh');
				endif;
				$dados['atividade'] = $atividade;
				$agenda = $this->agenda->recupera_agenda_atividade($id_atividade);
			else:
				configura_mensagem('Atividade desconhecida. Escolha uma atividade para se cadastrar', 'falha');
			endif;
		else:
			configura_mensagem('Evento desconhecido. Escolha um evento e uma atividade para se cadastrar', 'falha');
		endif;

		$this->form_validation->set_rules('enviar', 'Inscrever-se', 'trim|required');
		if($this->form_validation->run() == FALSE):
			if(validation_errors()):
				configura_mensagem(validation_errors(), 'falha');
			endif;
		else:
			$dados_inscricao_insert['participante_id'] = $this->session->dados_participante['id_participante'];
			$dados_inscricao_insert['evento_id'] = $evento->id_evento;
			$dados_inscricao_insert['atividade_id'] = $atividade->id_atividade;

			if($this->existe_inscricao($dados_inscricao_insert['participante_id'], $dados_inscricao_insert['atividade_id'])):
				configura_mensagem('PARTICIPANTE já cadastrado nesta ATIVIDADE', 'falha');
				redirect('home/listar_atividades/' . $evento->id_evento,'refresh');
			elseif (!isset($agenda) || sizeof($agenda) < 1):
				configura_mensagem('Esta ATIVIDADE ainda não possui AGENDA', 'falha');
				redirect('home/listar_atividades/' . $evento->id_evento,'refresh');
			elseif($this->prazo_expirado($agenda)):
				configura_mensagem('Prazo de inscrição expirado para esta ATIVIDADE', 'falha');
				redirect('home/listar_atividades/' . $evento->id_evento,'refresh');
			elseif($this->verifica_agenda_simultanea($dados_inscricao_insert['participante_id'], $agenda)):
				configura_mensagem('PARTICIPANTE já inscrito em outra ATIVIDADE neste dia e neste horário', 'falha');
				redirect('home/listar_atividades/' . $evento->id_evento,'refresh');
			else:
				if($id_inscricao = $this->inscricao->salvar($dados_inscricao_insert)):
					foreach ($agenda as $chamada):
						$dados_chamada_insert['inscricao_id'] = $id_inscricao;
						$dados_chamada_insert['agenda_id'] = $chamada->id_agenda;						
						$dados_chamada_insert['presenca'] = FALSE;

						$id_chamada = $this->chamada->salvar($dados_chamada_insert);						
					endforeach;
					configura_mensagem('INSCRIÇÃO realizada com sucesso.', 'sucesso');
					redirect('home/listar_atividades/' . $evento->id_evento, 'refresh');
				else:				
					configura_mensagem('Não foi possível realizar a INSCRIÇÃO.', 'falha');
				endif;
			endif;
		endif;		
		
		$dados['pagina'] = 'listar_atividades';
		$dados['titulo'] = 'ATIVIDADES';
		
		$this->load->view('home', $dados);
	}	
	//====================================================================================================
	public function desinscrever(){		
		verifica_login();		
		
		if(($id_participante = $this->uri->segment(3)) > 0):
			if(!valida_login($id_participante)):
				verifica_permissao($this->session->dados_participante['acesso'], INSCRICOES);
			endif;
			$dados['id_participante'] = $id_participante;
			if(($id_inscricao = $this->uri->segment(4)) > 0):			
				if($inscricao = $this->inscricao->recupera_inscricao($id_inscricao)):							
					$inscricao->evento = $this->evento->recupera_evento($inscricao->evento_id);
					$inscricao->atividade = $this->atividade->recupera_atividade($inscricao->atividade_id);
					$inscricao->atividade->agenda = $this->agenda->recupera_agenda_atividade($inscricao->atividade_id);
					$dados['inscricao'] = $inscricao;
					if(isset($inscricao->atividade->agenda) && sizeof($inscricao->atividade->agenda) > 0):						
						if($this->prazo_expirado($inscricao->atividade->agenda)):
							configura_mensagem('Não é possível realizar desinscrição após Data e Hora do início da AGENDA da ATIVIDADE', 'falha');
							redirect('home/listar_inscricoes/' . $id_participante, 'refresh');
						else:
							configura_mensagem('Confirma a DESINSCRIÇÃO?', 'alerta');
						endif;
					endif;												
				else:					
					configura_mensagem('INSCRIÇÃO inexistente.<br>Escolha uma INSCRIÇÃO desinscrever-se.', 'falha');	
					redirect('home/listar_inscricoes/' . $id_participante, 'refresh');
				endif;
			else:
				configura_mensagem('INSCRICÃO desconhecida.</br>Escolha uma INSCRICÃO para desinscrever-se.', 'falha');
				redirect('home/listar_inscricoes/' . $id_participante, 'refresh');
			endif;
		else:			
			configura_mensagem('Escolha uma INSCRIÇÃO para desinscrever-se.', 'falha');
			redirect('home/listar_inscricoes/' . $id_participante, 'refresh');
		endif;
		
		$this->form_validation->set_rules('enviar', 'Excluir', 'trim|required');		
		if($this->form_validation->run() == FALSE):			
			if(validation_errors()):
				configura_mensagem(validation_errors(), 'falha');
			endif;		
		else:	
			if($this->chamada->excluir($id_inscricao)):
				if($this->inscricao->excluir($id_inscricao)):
					configura_mensagem('DESINSCRIÇÃO realizada com sucesso.', 'sucesso');
					redirect('home/listar_atividades/' . $inscricao->evento_id, 'refresh');					
				else:
					configura_mensagem('Não foi possível DESINSCREVER-SE.', 'falha');
				endif;
				configura_mensagem('DESINSCRIÇÃO realizada com sucesso.', 'sucesso');
				redirect('home/listar_atividades/' . $inscricao->evento_id, 'refresh');					
			else:				
				configura_mensagem('Não foi possível DESINSCREVER-SE.', 'falha');
			endif;		
		endif;
		
		$dados['pagina'] = 'desinscrever';
		$dados['titulo'] = 'INSCRIÇÃO';		
		
		$this->load->view('home', $dados);
	}
	//====================================================================================================
	public function existe_inscricao($participante_id=NULL, $atividade_id=NULL){
		if ($this->inscricao->existe_inscricao($participante_id, $atividade_id)):
			return TRUE;
		else:
			return FALSE;
		endif;
	}
	//====================================================================================================
	public function verifica_agenda_simultanea($participante_id, $agenda_atividade){
		$result = FALSE;
		$agendas = [];	
		$inscricoes_participante = $this->inscricao->recupera_inscricoes_participante($participante_id);
		if(isset($inscricoes_participante) && sizeof($inscricoes_participante) > 0):			
			foreach ($inscricoes_participante as $inscricao_participante):
				array_push($agendas, $this->agenda->recupera_agenda_atividade($inscricao_participante->atividade_id));	
			endforeach;
		endif;		
		if(isset($agendas) && sizeof($agendas) > 0):
			foreach ($agendas as $agenda_participante):
				foreach ($agenda_atividade as $dia_hora_atividade):
					foreach ($agenda_participante as $dia_hora_participante):
						if ($dia_hora_atividade->dia == $dia_hora_participante->dia && 
							$dia_hora_atividade->hora_termino > $dia_hora_participante->hora_inicio && 
							$dia_hora_atividade->hora_inicio < $dia_hora_participante->hora_termino):
							$result = TRUE;							
						endif;
					endforeach;
				endforeach;
			endforeach;
		endif;		
		return $result;	
	}
	//====================================================================================================
	public function prazo_expirado($agenda){
		$dia_atividade = $this->attribute_in_array($agenda, 'dia', 'min');
		$hora_inicio_atividade =  $this->attribute_in_array($agenda, 'hora_inicio', 'min');
		if(date('Y-m-d') > $dia_atividade):
			return TRUE;
		elseif(date('Y-m-d') == $dia_atividade):
			if(date('H-i-s') > $hora_inicio_atividade):
				return TRUE;
			else:
				return FALSE;
			endif;
		else:
			return FALSE;
		endif;
	}
	//====================================================================================================
	public function attribute_in_array($array, $attribute, $function) {
	    $result = array_map(function($o) use($attribute){return $o->$attribute;}, $array);
	    if(function_exists($function)) {
	        return $function($result);
	    }
	    return false;
	}				
}