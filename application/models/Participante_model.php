<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Participante_model extends CI_Model {
	//====================================================================================================
	function __construct(){
		parent::__construct();
	}
	//====================================================================================================
	public function recupera_participante($id=0){		
		$this->db->where('id_participante', $id);		
		$query = $this->db->get('participantes', 1);		
		if($query->num_rows() == 1):
			$row = $query->row();
			return $row;
		else:
			return NULL;
		endif;
	}
	//====================================================================================================
	public function recupera_participantes(){		
		$this->db->order_by('nome', 'asc');
		$this->db->join('categorias', 'categorias.id_categoria = participantes.categoria_id');			
		$query = $this->db->get('participantes');
		if($query->num_rows() > 0):
			return $query->result();
		else:
			return NULL;
		endif;		
	}
	//====================================================================================================
	public function login($email=NULL, $senha=NULL){		
		$this->db->where('email', $email);
		$this->db->where('senha', $senha);		
		$consulta = $this->db->get('participantes', 1);		
		if ($consulta->num_rows() == 1):			
			$resultado = array(
						'id_participante' => $consulta->row(0)->id_participante,
						'nome' => $consulta->row(0)->nome,
						'cpf' => $consulta->row(0)->cpf,
						'email' => $consulta->row(0)->email,						
						'acesso' => $consulta->row(0)->acesso,
						'categoria_id' => $consulta->row(0)->categoria_id,
						'logado' => TRUE
					);			
			return $resultado;
		else:
			return false;
		endif;		
	}
	//====================================================================================================
	public function salvar($dados=NULL){		
		if(isset($dados['id_participante']) && $dados['id_participante'] > 0):			
			$this->db->where('id_participante', $dados['id_participante']);			
			unset($dados['id_participante']);			
			$this->db->update('participantes', $dados);			
			return $this->db->affected_rows();		
		else:			
			$this->db->insert('participantes', $dados);			
			return $this->db->insert_id();		
		endif;
	}
	//====================================================================================================
	public function excluir($id=0){
		$this->db->where('id_participante', $id);
		$query = $this->db->delete('participantes');
		return $this->db->affected_rows();		
	}
	//====================================================================================================
	public function existe_nome($nome=NULL){
		$query = $this->db->get_where('participantes', array('nome' => $nome));
		if (empty($query->row_array())):
			return true;
		else:
			return false;
		endif;			
	}
	//====================================================================================================
	public function existe_cpf($cpf=NULL){
		$query = $this->db->get_where('participantes', array('cpf' => $cpf));
		if (empty($query->row_array())):
			return true;
		else:
			return false;
		endif;			
	}
	//====================================================================================================
	public function existe_email($email=NULL){
		$query = $this->db->get_where('participantes', array('email' => $email));
		if (empty($query->row_array())):
			return true;
		else:
			return false;
		endif;			
	}
	//====================================================================================================
	public function existe_participantes_categoria($id=0){
		$query = $this->db->get_where('participantes', array('categoria_id' => $id));
		if (empty($query->row_array())):
			return true;
		else:
			return false;
		endif;			
	}
	//====================================================================================================		
}