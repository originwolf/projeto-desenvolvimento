<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Atividade_model extends CI_Model {
	//====================================================================================================
	function __construct(){
		parent::__construct();
	}
	//====================================================================================================
	public function recupera_atividade($id=0){		
		$this->db->where('id_atividade', $id);		
		$query = $this->db->get('atividades', 1);		
		if($query->num_rows() == 1):
			$row = $query->row();
			return $row;
		else:
			return NULL;
		endif;
	}
	//====================================================================================================
	public function recupera_atividades_evento($id=0){		
			$this->db->order_by('atividade', 'asc');
			$this->db->where('evento_id', $id);			
			$query = $this->db->get('atividades');
			if($query->num_rows() > 0):
				return $query->result();
			else:
				return NULL;
			endif;		
	}	
	//====================================================================================================
	public function salvar($dados=NULL){
		if(isset($dados['id_atividade']) && $dados['id_atividade'] > 0):			
			$this->db->where('id_atividade', $dados['id_atividade']);			
			unset($dados['id_atividade']);			
			$this->db->update('atividades', $dados);			
			return $this->db->affected_rows();		
		else:			
			$this->db->insert('atividades', $dados);			
			return $this->db->insert_id();		
		endif;
	}
	//====================================================================================================
	public function excluir($id=0){
		$this->db->where('id_atividade', $id);
		$query = $this->db->delete('atividades');
		return $this->db->affected_rows();		
	}
	//====================================================================================================
	public function existe_atividade($atividade=NULL, $id_evento=NULL){
		$query = $this->db->get_where('atividades', array('atividade' => $atividade, 'evento_id' => $id_evento));
		if (empty($query->row_array())):
			return true;
		else:
			return false;
		endif;			
	}
	//====================================================================================================
	public function existe_atividades_evento($id=0){
		$query = $this->db->get_where('atividades', array('evento_id' => $id));
		if (empty($query->row_array())):
			return true;
		else:
			return false;
		endif;			
	}
	//====================================================================================================	
}