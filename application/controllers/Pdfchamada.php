<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pdfchamada extends CI_Controller {
	//====================================================================================================
	function __construct(){		
		parent::__construct();
		$this->load->library('fpdf_gen');		
		$this->load->model('participante_model', 'participante');
		$this->load->model('evento_model', 'evento');
		$this->load->model('atividade_model', 'atividade');
		$this->load->model('agenda_model', 'agenda');
		$this->load->model('inscricao_model', 'inscricao');
		$this->load->model('chamada_model', 'chamada');
	}
	//====================================================================================================
	public function index(){		
		redirect('chamada/listar', 'refresh');
	}
	//====================================================================================================
	public function pdf(){		
		verifica_login();		
		verifica_permissao($this->session->dados_participante['acesso'], INSCRICOES);

		if($id_evento = $this->uri->segment(3)):
			if($evento = $this->evento->recupera_evento($id_evento)):
				$dados['evento'] = $evento;
				if($id_atividade = $this->uri->segment(4)):
					if($atividade = $this->atividade->recupera_atividade($id_atividade)):
						$dados['atividade'] = $atividade;
						$dados['agenda'] = 	$this->agenda->recupera_agenda_atividade($id_atividade);
						if($inscritos = $this->inscricao->recupera_participantes_inscritos($id_atividade)):
							foreach ($inscritos as $inscrito):
								$inscrito->chamada = $this->chamada->recupera_chamadas_inscricao($inscrito->id_inscricao);
							endforeach;
							$dados['inscritos'] = $inscritos;

							$pdf = new FPDF("P", "mm", "A4");
							$this->fpdf->setAuthor('SISCONEVE Sistema Controlador de Eventos');
							$this->fpdf->SetTitle('Controle de Presenca', 0);
							$this->fpdf->AliasNbPages('{np}');
							$this->fpdf->SetAutoPageBreak(false);
							$this->fpdf->SetMargins(20,20,20,20);
							$this->fpdf->SetTextColor(0,0,0);

							$this->fpdf->SetFont('Arial', 'B', '14');							
							$this->fpdf->Cell(0, 10, utf8_decode("CONTROLE DE PRESENÇA"), 0, 0, "C");
							$this->fpdf->Ln(15);

							$this->fpdf->SetFont('Arial', '', '10');							
							$this->fpdf->Cell(0, 10, utf8_decode("EVENTO: " . $evento->evento), 0, 0, "L");
							$this->fpdf->Ln(5);
							$this->fpdf->Cell(0, 10, utf8_decode("ATIVIDADE: " . $atividade->atividade), 0, 0, "L");
							$this->fpdf->Ln(5);
							$this->fpdf->Cell(0, 10, utf8_decode("LOCAL: " . $atividade->local), 0, 0, "L");
							$this->fpdf->Ln(15);

							$this->fpdf->SetFont('Arial', 'B', '10');
							$this->fpdf->Cell(85,7,"PARTICIPANTE","B");
							$this->fpdf->Cell(85,7,"ASSINATURA","B");
							$this->fpdf->Ln(8);

							$this->fpdf->SetFont('Arial', '', '10');
							foreach ($inscritos as $inscrito):
								$this->fpdf->Cell(85,7,	utf8_decode($inscrito->nome),"B");
								$this->fpdf->Cell(85,7,"","B");
								$this->fpdf->Ln(8);
							endforeach;
							
							echo $this->fpdf->Output('Chamada_'. $atividade->atividade . '.pdf', 'I');
						else:
							configura_mensagem('ATIVIDADE ainda sem PARTICIPANTES inscritos.', 'alerta');
							//redirect('atividade/listar/' . $evento->id_evento, 'refresh');
						endif;
					else:
						configura_mensagem('ATIVIDADE desconhecida.</br>Escolha uma ATIVIDADE para ver a CHAMADA.', 'falha');
						redirect('atividade/listar/' . $evento->id_evento, 'refresh');
					endif;						
				else:
					configura_mensagem('Escolha uma ATIVIDADE para ver a CHAMADA.', 'falha');
					redirect('atividade/listar/' . $evento->id_evento, 'refresh');									
				endif;
			else:
				configura_mensagem('EVENTO desconhecido.</br>Escolha um EVENTO e uma ATIVIDADE para ver a CHAMADA.', 'falha');
				redirect('evento/listar', 'refresh');
			endif;
		else:
			configura_mensagem('Escolha um EVENTO e uma ATIVIDADE para ver a CHAMADA.', 'falha');
			redirect('evento/listar', 'refresh');
		endif;
		
		$dados['pagina'] = 'listar';
		$dados['titulo'] = 'Controle de CHAMADAS';

		$this->load->view('chamada', $dados);
	}
	//====================================================================================================
}