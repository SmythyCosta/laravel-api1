<?php

namespace App\LibPDF;
use Anouar\Fpdf\Fpdf as baseFpdf;

class UserPDF extends baseFpdf{

	public function __construct(){
		$orientation = 'L';
		$unit = 'mm';
		$size = 'A4';
		parent::__construct($orientation, $unit, $size);
	}

}