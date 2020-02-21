<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pdf extends CI_Controller {
	public function pdfExport(){
		$this->load->library('fpdf_gen');
		$pdf = new FPDF("P", "mm", "A4");

		$this->fpdf->setAuthor('Denis Antonio Rocha');
		$this->fpdf->SetTitle('Testando Relatório Codeiginter', 0);
		$this->fpdf->AliasNbPages('{np}');
		$this->fpdf->SetAutoPageBreak(false);
		$this->fpdf->SetMargins(8,8,8,8);
		$this->fpdf->SetFont('Arial', '', '18');

		$this->fpdf->Ln(4);		
		$this->fpdf->Cell(95,10,'',0,0,"L");
		$this->fpdf->SetTextColor(65,65,255);
		$this->fpdf->Cell(2, -6, "Teste Linha 1", 0, 0, "C");

		$this->fpdf->Ln(6);
		$this->fpdf->SetFont('Arial', '', '10');
		$this->fpdf->Cell(100,10,'',0,0,"L");
		$this->fpdf->SetTextColor(0,0,0);
		$this->fpdf->Cell(2, -6, "Teste Linha 2", 0, 0, "C");

		echo $this->fpdf->Output('Teste relatorio pdf php.pdf', 'D');

	}
}