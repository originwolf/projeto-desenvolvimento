<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Area_model extends CI_Model {
	//====================================================================================================
	function __construct(){
		parent::__construct();		
	}
	//====================================================================================================
	public function salvar($dados=NULL){		
		if(isset($dados['id_area']) && $dados['id_area'] > 0):			
			$this->db->where('id_area', $dados['id_area']);			
			unset($dados['id_area']);			
			$this->db->update('areas', $dados);			
			return $this->db->affected_rows();		
		else:			
			$this->db->insert('areas', $dados);			
			return $this->db->insert_id();		
		endif;
	}
	//====================================================================================================
	public function recupera_areas(){		
			$this->db->order_by('area', 'asc');
			$query = $this->db->get('areas');
			if($query->num_rows() > 0):
				return $query->result();
			else:
				return NULL;
			endif;		
	}
	//====================================================================================================
	public function recupera_area($id=0){
		$this->db->where('id_area', $id);
		$query = $this->db->get('areas', 1);
		if($query->num_rows() == 1):
			$row = $query->row();
			return $row;
		else:
			return NULL;
		endif;		
	}
	//====================================================================================================
	public function excluir($id=0){
		$this->db->where('id_area', $id);
		$query = $this->db->delete('areas');
		return $this->db->affected_rows();		
	}
	//====================================================================================================
	public function existe_area($area=NULL){
		$query = $this->db->get_where('areas', array('area' => $area));
		if (empty($query->row_array())):
			return true;
		else:
			return false;
		endif;
	}
	//====================================================================================================		
}