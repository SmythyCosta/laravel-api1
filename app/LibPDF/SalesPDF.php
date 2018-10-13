<?php

namespace App\LibPDF;
use Anouar\Fpdf\Fpdf as baseFpdf;

class SalesPDF extends baseFpdf{

	public function __construct(){
		$orientation = 'L';
		$unit = 'mm';
		$size = 'A4';
		parent::__construct($orientation, $unit, $size);
	}

	function Header(){
		if($this->PageNo() != 1){
			$this->SetFont('Arial','B',12);
	        $this->cell(15,6,"SL",1,"","C");
	        $this->cell(35,6,"Invoice Code",1,"","C");
	        $this->cell(45,6,"Customer Name",1,"","C");
	        $this->cell(35,6,"date",1,"","C");
	        $this->cell(35,6,"Amount",1,"","C");
	        $this->cell(35,6,"Due",1,"","C");
	        $this->cell(35,6,"Payment Type",1,"","C");
			$this->Ln();
		}
	}

}