<?php

namespace App\LibPDF;
use Anouar\Fpdf\Fpdf as baseFpdf;


class CustomerLib extends baseFpdf{

    public function __construct()
    {
        $orientation = 'L';
        $unit = 'mm';
        $size = 'A4';
        parent::__construct($orientation, $unit, $size);
    }

    function Header()
    {
        if($this->PageNo() != 1){

            $this->SetFont('Arial','B',12);
            $this->cell(15,6,"SL",1,"","C");
            $this->cell(45,6,"Name",1,"","C");
            $this->cell(50,6,"Email",1,"","C");
            $this->cell(30,6,"Phone",1,"","C");
            $this->cell(50,6,"Address",1,"","C");
            $this->cell(20,6,"Status",1,"","C");
            $this->Ln(); // Line break

        }   
    }

    function SetCellMargin($margin){
        //
        $this->cMargin = $margin;
    }

}