<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Chamada_model extends CI_Model {
	//====================================================================================================
	function __construct(){
		parent::__construct();		
	}
	//====================================================================================================
	public function salvar($dados=NULL){		
		if(isset($dados['id_chamada']) && $dados['id_chamada'] > 0):			
			$this->db->where('id_chamada', $dados['id_chamada']);
			unset($dados['id_chamada']);
			$this->db->update('chamadas', $dados);
			return $this->db->affected_rows();
		else:
			$this->db->insert('chamadas', $dados);
			return $this->db->insert_id();
		endif;
	}
	//====================================================================================================
	public function recupera_chamadas_inscricao($id_inscricao){
		$this->db->where('inscricao_id', $id_inscricao);
		$this->db->join('agendas', 'agendas.id_agenda = chamadas.agenda_id');
		$this->db->order_by('dia', 'ASC');
		$this->db->order_by('hora_inicio', 'ASC');
		$query = $this->db->get('chamadas');
			if($query->num_rows() > 0):
				return $query->result();
			else:
				return NULL;
			endif;		
	}
	//====================================================================================================
	public function recupera_presencas_participante($id_inscricao=0){
		$this->db->where('inscricao_id', $id_inscricao);		
		$this->db->where('presenca', TRUE);
		return $this->db->count_all_results('chamadas');
	}
	//====================================================================================================
	public function excluir($id=0){
		$this->db->where('inscricao_id', $id);		
		$query = $this->db->delete('chamadas');
		return $this->db->affected_rows();		
	}
	//====================================================================================================
	public function verifica_presenca_total($id_agenda){
		$this->db->where('agenda_id', $id_agenda);
		$this->db->where('presenca', FALSE);		
		$query = $this->db->get('chamadas');
			if($query->num_rows() > 0):
				return FALSE;
			else:
				return TRUE;
			endif;		
	}
	//====================================================================================================
	public function chamada_total($id_agenda, $presenca){
		$this->db->where('agenda_id', $id_agenda);
		$this->db->set('presenca', $presenca);		
		$query = $this->db->update('chamadas');
		return $this->db->affected_rows();
	}
	//====================================================================================================
}