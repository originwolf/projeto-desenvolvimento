<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Xlsxcertificados extends CI_Controller {
	//====================================================================================================
	function __construct(){		
		parent::__construct();		
		$this->load->model('participante_model', 'participante');
		$this->load->model('evento_model', 'evento');
		$this->load->model('atividade_model', 'atividade');
		$this->load->model('agenda_model', 'agenda');
		$this->load->model('inscricao_model', 'inscricao');
		$this->load->model('chamada_model', 'chamada');
		$this->load->library('excel');
	}
	//====================================================================================================
	public function index(){		
		redirect('chamada/listar', 'refresh');
	}
	//====================================================================================================
	public function xlsx(){		
		verifica_login();		
		verifica_permissao($this->session->dados_participante['acesso'], CHAMADAS);

		if($id_evento = $this->uri->segment(3)):
			if($evento = $this->evento->recupera_evento($id_evento)):
				$dados['evento'] = $evento;
				if($id_atividade = $this->uri->segment(4)):
					if($atividade = $this->atividade->recupera_atividade($id_atividade)):
						$dados['atividade'] = $atividade;
						$dados['agenda'] = 	$this->agenda->recupera_agenda_atividade($id_atividade);
						$chamadas = sizeof($dados['agenda']);
						$dados['chamadas'] = $chamadas;
						if($inscritos = $this->inscricao->recupera_participantes_inscritos($id_atividade)):
							$dados['inscritos'] = $inscritos;
							$dados['certificados'] = [];							
							
							$this->excel->setActiveSheetIndex(0);
							$this->excel->getActiveSheet()->getColumnDimension('A') ->setAutoSize(true);				
							$this->excel->getActiveSheet()->setTitle('Certificados');

							$this->excel->getActiveSheet()->setCellValue('A1', 'Nome');
							$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
							
							
							$this->excel->getActiveSheet()->setCellValue('B1', 'CPF');							
							$this->excel->getActiveSheet()->getStyle('B1')->getFont()->setBold(true);
							
							$this->excel->getActiveSheet()->setCellValue('C1', 'Email');							
							$this->excel->getActiveSheet()->getStyle('C1')->getFont()->setBold(true);

							$row = 1;

							foreach ($inscritos as $inscrito):								
								$inscrito->presencas = $this->chamada->recupera_presencas_participante($inscrito->id_inscricao);
							 	if($inscrito->presencas >= ($chamadas / 4 * 3)):
							 		$row += 1;
							 		$this->excel->getActiveSheet()->setCellValue('A' . $row, $inscrito->nome);
							 		$this->excel->getActiveSheet()->setCellValue('B' . $row, $inscrito->cpf);
							 		$this->excel->getActiveSheet()->setCellValue('C' . $row, $inscrito->email);					
							 	endif;
							endforeach;

							$this->excel->getActiveSheet()->getColumnDimension('A') ->setAutoSize(true);
							$this->excel->getActiveSheet()->getColumnDimension('B') ->setAutoSize(true);
							$this->excel->getActiveSheet()->getColumnDimension('C') ->setAutoSize(true);

							$arquivo='CERTIFICADOS_' . $atividade->atividade . '.xlsx'; 
							header('Content-Type: application/vnd.ms-excel');
							header('Content-Disposition: attachment;filename="'.$arquivo.'"'); 
							header('Cache-Control: max-age=0');

							$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel2007');				
							$objWriter->save('php://output');							
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
	}
	//====================================================================================================
}