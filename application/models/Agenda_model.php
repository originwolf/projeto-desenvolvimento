<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Agenda_model extends CI_Model {
	//====================================================================================================
	function __construct(){
		parent::__construct();
	}
	//====================================================================================================
	public function recupera_agenda($id=0){				
		$this->db->where('id_agenda', $id);		
		$query = $this->db->get('agendas', 1);		
		if($query->num_rows() == 1):
			$row = $query->row();
			return $row;
		else:
			return NULL;
		endif;
	}
	//====================================================================================================
		public function recupera_agenda_atividade($id=0){		
			$this->db->order_by('dia', 'ASC');
			$this->db->order_by('hora_inicio', 'ASC');
			$this->db->where('atividade_id', $id);							
			$query = $this->db->get('agendas');
			if($query->num_rows() > 0):
				return $query->result();
			else:
				return NULL;
			endif;		
	}
	//====================================================================================================
	public function recupera_agenda_atividades_evento($id=0){		
			$this->db->order_by('dia', 'ASC');
			$this->db->order_by('hora_inicio', 'ASC');	
			$this->db->where('evento_id', $id);						
			$query = $this->db->get('agendas');
			if($query->num_rows() > 0):
				return $query->result();
			else:
				return NULL;
			endif;		
	}
	//====================================================================================================	
	public function salvar($dados=NULL){		
		if(isset($dados['id_agenda']) && $dados['id_agenda'] > 0):			
			$this->db->where('id_agenda', $dados['id_agenda']);			
			unset($dados['id_agenda']);			
			$this->db->update('agendas', $dados);			
			return $this->db->affected_rows();		
		else:			
			$this->db->insert('agendas', $dados);			
			return $this->db->insert_id();		
		endif;
	}
	//====================================================================================================
	public function excluir($id=0){
		$this->db->where('id_agenda', $id);
		$query = $this->db->delete('agendas');
		return $this->db->affected_rows();		
	}
	//====================================================================================================
	public function existe_agendas_atividade($id){
		$query = $this->db->get_where('agendas', array('atividade_id' => $id));
		if (empty($query->row_array())):
			return true;
		else:
			return false;
		endif;			
	}
	//====================================================================================================		
	public function existe_agenda($id_atividade=0, $dia=NULL, $hora_inicio=NULL, $hora_termino=NULL){
		$this->db->where('atividade_id =', $id_atividade);
		$this->db->where('dia =', $dia);
		$this->db->where('hora_termino >', $hora_inicio);
		$this->db->where('hora_inicio <', $hora_termino);	
		$query = $this->db->get('agendas');		
		if (empty($query->row_array())):
			return false;
		else:
			return true;
		endif;			
	}
	//====================================================================================================
}