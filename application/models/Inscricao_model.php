<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Inscricao_model extends CI_Model {
	//====================================================================================================
	function __construct(){
		parent::__construct();		
	}
	//====================================================================================================
	public function salvar($dados=NULL){
		if(isset($dados['id_inscricao']) && $dados['id_inscricao'] > 0):
			$this->db->where('id_inscricao', $dados['id_inscricao']);
			unset($dados['id_inscricao']);
			$this->db->update('inscricoes', $dados);
			return $this->db->affected_rows();
		else:
			$this->db->insert('inscricoes', $dados);
			return $this->db->insert_id();
		endif;
	}
	//====================================================================================================
	public function excluir($id_inscricao=0){
		$this->db->where('id_inscricao', $id_inscricao);
		$query = $this->db->delete('inscricoes');
		return $this->db->affected_rows();		
	}
	//====================================================================================================
	public function recupera_inscricao($id_inscricao=0){
		$this->db->where('id_inscricao', $id_inscricao);
		$query = $this->db->get('inscricoes', 1);
		if($query->num_rows() == 1):
			$row = $query->row();
			return $row;
		else:
			return NULL;
		endif;		
	}
	//====================================================================================================
	public function recupera_participantes_inscritos($id_atividade=0){
		$this->db->where('atividade_id', $id_atividade);
		$this->db->join('participantes', 'participantes.id_participante = inscricoes.participante_id');
		$this->db->order_by('participantes.nome', 'asc');
		$query = $this->db->get('inscricoes');
		if($query->num_rows() > 0):
			return $query->result();
		else:
			return NULL;
		endif;
	}
	//====================================================================================================
	public function recupera_inscricoes_atividade($id_atividade=0){
		$this->db->where('atividade_id', $id_atividade);		
		$this->db->join('participantes', 'participantes.id_participante = inscricoes.participante_id');
		$this->db->join('categorias', 'categorias.id_categoria = participantes.categoria_id');
		$this->db->order_by('participantes.nome', 'asc');
		$query = $this->db->get('inscricoes');
		if($query->num_rows() > 0):
			return $query->result();
		else:
			return NULL;
		endif;
	}
	//====================================================================================================
		public function recupera_inscricoes_participante($id_participante=0){
		$this->db->where('participante_id', $id_participante);
		$query = $this->db->get('inscricoes');
		if($query->num_rows() > 0):
			return $query->result();
		else:
			return NULL;
		endif;
	}
	//====================================================================================================
	public function existe_inscricao($participante_id, $atividade_id){
		if($participante_id == NULL || $atividade_id == NULL):
			return TRUE;
		endif;
		$query = $this->db->get_where('inscricoes', array('participante_id' => $participante_id, 'atividade_id' => $atividade_id));

		if (empty($query->row_array())):
			return FALSE;
		else:
			return TRUE;
		endif;
	}
	//====================================================================================================
	public function recupera_inscricao_participante_atividade($participante_id, $atividade_id){		
		$query = $this->db->get_where('inscricoes', array('participante_id' => $participante_id, 'atividade_id' => $atividade_id));
		if($query->num_rows() == 1):
			$row = $query->row();
			return $row;
		else:
			return NULL;
		endif;		
	}
	//====================================================================================================	
	public function conta_inscritos_atividade($id_atividade=0){
		$this->db->select('atividade_id');
		$this->db->from('inscricoes');
		$this->db->where('atividade_id', $id_atividade);
		return $this->db->count_all_results();		 		
	}
}
