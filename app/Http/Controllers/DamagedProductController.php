<?php

namespace App\Http\Controllers;

//Imports Laravel
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

//Imports Models
use App\DamagedProduct;
use App\Setting;

//My Libs
use App\LibPDF\DamagedProductPDF;
use Excel;


class DamagedProductController extends Controller
{

	public function productSave(Request $request)
    {
        $product_id = $request->input('allProduct');
        $quantity = $request->input('quantity');

        $damagedProduct = new DamagedProduct;
        $damagedProduct->product_id = $product_id;
        $damagedProduct->quantity = $quantity;
        $damagedProduct->note = $request->input('note');
        $damagedProduct->created_at = date('Y-m-d');
        $damagedProduct->save();

        return response()->json(['status'=>200,'mesg'=>'Damaged Product Save Success']);
    
    }


    public function allDamagedProduct(Request $request)
    {
                                
        $product =  new DamagedProduct;
        $all = $product->productAll();

        return response()->json(['status'=>200,'product'=>$all]);
    }


    public function allProduct(Request $request)
    {
             
        $type = $request->input('type');
        if($type==0){
            $product =  DB::select('SELECT id,name FROM product WHERE id NOT in (SELECT id FROM damaged_product)');
        }else{
            $product = DB::select('SELECT id,name FROM product');
        }                   

        return response()->json(['status'=>200,'product'=>$product]);
    }


    public function getDamagedProduct(Request $request)
    {
        $id = $request->input('id'); 
        $single =  DamagedProduct::find($id);
        return response()->json(['status'=>200,'product'=>$single]); 
    }


    public function productUpdate(Request $request)
    {
        $id = $request->input('id');
        $product_id = $request->input('allProduct');
        $quantity = $request->input('quantity');

        $damagedProduct = DamagedProduct::find($id);
        $damagedProduct->product_id = $product_id;
        $damagedProduct->quantity = $quantity;
        $damagedProduct->note = $request->input('note');
        $damagedProduct->updated_at = date('Y-m-d');
        $damagedProduct->save();

        return response()->json(['status'=>200,'mesg'=>'Damaged Product Update Success']);
    
    }


    public function exportpdf(Request $request)
    {
        $product =  new DamagedProduct;
        $allProduct = $product->productAll();

        $setting = Setting::where('id',1)->first();
        $pdf = new DamagedProductPDF();
        $pdf->SetMargins(20, 10, 11.7);
        $pdf->AliasNbPages();
        $pdf->AddPage();

        $pdf->SetFont('Arial','B',12);
        $pdf->Cell(200,5,'Damaged Product List',0,1,'L');
        $pdf->SetFont('Arial','',10);
        $pdf->Cell(200,5,$setting->company_name,0,1,'L');
        $pdf->Cell(200,5,$setting->phone,0,1,'L');
        $pdf->Cell(200,5,$setting->address,0,1,'L');
        $pdf->Ln(10);

        $pdf->SetFont('Arial','B',12);
        $pdf->cell(25,6,"SL",1,"","C");
        $pdf->cell(35,6,"Product Code",1,"","C");
        $pdf->cell(50,6,"Name",1,"","C");
        $pdf->cell(45,6,"Category",1,"","C");
        $pdf->cell(40,6,"Purchase Price",1,"","C");
        $pdf->cell(25,6,"Quantity",1,"","C");
        $pdf->cell(35,6,"Date",1,"","C");
        $pdf->Ln();
        $pdf->SetFont('Times','',10);

        foreach ($allProduct as $key => $value) {
            $pdf->cell(25,5,$key+1,1,"","C");
            $pdf->cell(35,5,$value->serial_number,1,"","L");
            $pdf->cell(50,5,$value->name,1,"","L");
            $pdf->cell(45,5,$value->categoryName,1,"","L");
            $pdf->cell(40,5,$value->purchase_price,1,"","C");
            $pdf->cell(25,5,$value->quantity,1,"","C");
            $pdf->cell(35,5,$value->date,1,"","L");
            $pdf->Ln();
        }

        $pdf->Output();
        exit;

    }

    public function downloadExcel()
    {
        $type = 'xlsx';
        
        $setting = Setting::where('id',1)->first();
        Excel::create('Damaged-product-record-list', function ($excel) {
            $excel->setTitle('Damaged Product Record List');

            $excel->sheet('Damaged Product', function ($sheet) {

                // first row styling and writing content
                $sheet->mergeCells('A1:E1');
                $sheet->row(1, function ($row) {
                    $row->setFontFamily('Comic Sans MS');
                    $row->setFontSize(30);
                    // $row->setBorder('solid', 'none', 'none', 'solid');
                });

                $sheet->row(1, array('Damaged Product Record List'));

                $product =  new DamagedProduct;
                $allProduct = $product->productAll();

                $sheet->appendRow(2,
                                    array(
                                        'ID',
                                        'Product Code',
                                        'Name',
                                        'Category',
                                        'Purchase Price',
                                        'Quantity',
                                        'Date'
                                        )
                                    );

                // getting last row number (the one we already filled and setting it to bold
                $sheet->row($sheet->getHighestRow(), function ($row) {
                    $row->setFontWeight('bold');
                    $row->setAlignment('center');
                    $row->setBorder('thin', 'thin', 'thin', 'thin');
                });

                // putting users data as next rows
                foreach ($allProduct as $data) {

                    $sheet->appendRow(
                                    array(
                                        $data->id,
                                        $data->serial_number,
                                        $data->name,
                                        $data->categoryName,
                                        $data->purchase_price,
                                        $data->quantity,
                                        $data->date
                                        )
                                    );
                    $sheet->row($sheet->getHighestRow(), function ($row) {
                        $row->setAlignment('center');
                        $row->setBorder('thin', 'thin', 'thin', 'thin');
                    });
                }

                // die();
            });

        })->export('xls');
    }

}