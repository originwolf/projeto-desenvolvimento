<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Categoria_model extends CI_Model {
	//====================================================================================================
	function __construct(){
		parent::__construct();		
	}
	//====================================================================================================
	public function salvar($dados=NULL){		
		if(isset($dados['id_categoria']) && $dados['id_categoria'] > 0):			
			$this->db->where('id_categoria', $dados['id_categoria']);			
			unset($dados['id_categoria']);			
			$this->db->update('categorias', $dados);			
			return $this->db->affected_rows();		
		else:			
			$this->db->insert('categorias', $dados);			
			return $this->db->insert_id();		
		endif;
	}
	//====================================================================================================
	public function recupera_categorias(){
		$this->db->order_by('categoria', 'asc');
		$query = $this->db->get('categorias');
		if($query->num_rows() > 0):
			return $query->result();
		else:
			return NULL;
		endif;		
	}
	//====================================================================================================
	public function recupera_categoria($id=0){
		$this->db->where('id_categoria', $id);
		$query = $this->db->get('categorias', 1);
		if($query->num_rows() == 1):
			$row = $query->row();
			return $row;
		else:
			return NULL;
		endif;		
	}
	//====================================================================================================
	public function excluir($id=0){
		$this->db->where('id_categoria', $id);
		$query = $this->db->delete('categorias');
		return $this->db->affected_rows();		
	}
	//====================================================================================================
	public function existe_categoria($categoria=NULL){
		$query = $this->db->get_where('categorias', array('categoria' => $categoria));
		if (empty($query->row_array())):
			return true;
		else:
			return false;
		endif;			
	}
	//====================================================================================================		
}