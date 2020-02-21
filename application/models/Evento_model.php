<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Evento_model extends CI_Model {

	function __construct(){
		parent::__construct();
	}
	//====================================================================================================
	public function recupera_evento($id=0){				
		$this->db->where('id_evento', $id);		
		$query = $this->db->get('eventos', 1);		
		if($query->num_rows() == 1):
			$row = $query->row();
			return $row;
		else:
			return NULL;
		endif;
	}
	//====================================================================================================
	public function recupera_eventos(){
		$this->db->order_by('data_inicio', 'desc');
		$this->db->join('areas', 'areas.id_area = eventos.area_id');
		$query = $this->db->get('eventos');
		if($query->num_rows() > 0):
			return $query->result();
		else:
			return NULL;
		endif;		
	}
	//====================================================================================================
	public function recupera_eventos_publicados(){
		$this->db->where('publicar', TRUE);
		$this->db->where('data_termino >=', date('Y-m-d'));
		$this->db->order_by('data_inicio', 'desc');
		$this->db->join('areas', 'areas.id_area = eventos.area_id');
		$query = $this->db->get('eventos');
		if($query->num_rows() > 0):
			return $query->result();
		else:
			return NULL;
		endif;		
	}
	//====================================================================================================
	public function salvar($dados=NULL){		
		if(isset($dados['id_evento']) && $dados['id_evento'] > 0):			
			$this->db->where('id_evento', $dados['id_evento']);			
			unset($dados['id_evento']);			
			$this->db->update('eventos', $dados);			
			return $this->db->affected_rows();		
		else:			
			$this->db->insert('eventos', $dados);			
			return $this->db->insert_id();		
		endif;
	}
	//====================================================================================================
	public function publicar($id=NULL, $publicar=FALSE){		
		if(isset($id)):			
			$this->db->set('publicar', $publicar);
			$this->db->where('id_evento', $id);
			$this->db->update('eventos'); 
			return $this->db->affected_rows();	
		endif;
	}
	//====================================================================================================
	public function excluir($id=0){
		$this->db->where('id_evento', $id);
		$query = $this->db->delete('eventos');
		return $this->db->affected_rows();		
	}
	//====================================================================================================
	public function existe_evento($evento=NULL){
		$query = $this->db->get_where('eventos', array('evento' => $evento));
		if (empty($query->row_array())):
			return true;
		else:
			return false;
		endif;			
	}
	//====================================================================================================
	public function existe_eventos_area($id=0){
		$query = $this->db->get_where('eventos', array('area_id' => $id));
		if (empty($query->row_array())):
			return true;
		else:
			return false;
		endif;			
	}
	//====================================================================================================	
}