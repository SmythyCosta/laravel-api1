<?php

namespace App\Http\Controllers;

//Imports Laravel
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

//Imports Models
use App\Product;
use App\Setting;

//My Libs
use App\LibPDF\ProductPDF;


class ProductController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function productSave(Request $request)
    {
        $product = new Product;
        $product->serial_number = $request->input('serial_number');
        $product->category_id = $request->input('category');
        $product->sub_category_id = $request->input('subCategory');
        $product->name = $request->input('name');
        $product->purchase_price = $request->input('purchase_price');
        $product->selling_price = $request->input('selling_price');
        $product->note = $request->input('note');
        $product->status = $request->input('status');

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            // Get the contents of the file
            $contents = $file->openFile()->fread($file->getSize());
            $product->image = $contents;
        }
        $product->save();
        
        return response()->json(['status'=>200,'mesg'=>'Product Save Success']);
    }


    public function allProduct(Request $request)
    {
                                
        $product =  new Product;
        $all = $product->productAll();

        return response()->json(['status'=>200,'product'=>$all]);
    }


    public function getProduct(Request $request)
    {
        $id = $request->input('id');
        $single = DB::table('product')
                        ->leftJoin('category', 'product.category_id', '=', 'category.id')
                        ->leftJoin('sub_category', 'product.sub_category_id', '=', 'sub_category.id')
                        ->leftJoin('damaged_product', 'product.id', '=', 'damaged_product.product_id')
                        ->select('product.id','product.serial_number','product.name','product.category_id','product.sub_category_id','product.purchase_price','product.selling_price','product.stock_quantity','product.note','product.status','product.image','damaged_product.quantity as damagedQuantity','category.name as categoryName','sub_category.name as subCategoryName')
                        ->where('product.id',$id)
                        ->first();
        $data = [
            'id'  => $single->id,
            'serial_number'  => $single->serial_number,
            'name'  => $single->name,
            'category_id'  => $single->category_id,
            'categoryName'  => $single->categoryName,
            'sub_category_id'  => $single->sub_category_id,
            'subCategoryName'  => $single->subCategoryName,
            'purchase_price'  => $single->purchase_price,
            'selling_price'  => $single->selling_price,
            'note'  => $single->note,
            'status'  => $single->status,
            'stock_quantity'  => $single->stock_quantity-$single->damagedQuantity,
            'image'  => base64_encode($single->image),
        ];        
        
        return response()->json(['status'=>200,'product'=>$data]); 
    
    }


    public function productUpdate(Request $request)
    {
        $id = $request->input('id');
        $product = Product::find($id);
        $product->serial_number = $request->input('serial_number');
        $product->category_id = $request->input('category');
        $product->sub_category_id = $request->input('subCategory');
        $product->name = $request->input('name');
        $product->purchase_price = $request->input('purchase_price');
        $product->selling_price = $request->input('selling_price');
        $product->note = $request->input('note');
        $product->status = $request->input('status');

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            
            // Get the contents of the file
            $contents = $file->openFile()->fread($file->getSize());
            $product->image = $contents;
        
        }
        
        $product->save();
        
        return response()->json(['status'=>200,'mesg'=>'Product Update Success']);
    }


    public function getProductInfo(Request $request)
    {
        $id = $request->input('id');
        $single= Product::select('id','serial_number','name','purchase_price','selling_price','stock_quantity')->where('id',$id)->first();
    
        return response()->json(['status'=>200,'product'=>$single]); 
    
    }


    public function exportpdf(Request $request)
    {
        $product =  new Product;
        $allProduct = $product->productAll();
        $setting = Setting::where('id',1)->first();
        $pdf = new ProductPDF();
        $pdf->SetMargins(30, 10, 11.7);
        $pdf->AliasNbPages();
        $pdf->AddPage();

        $pdf->SetFont('Arial','B',12);
        // $pdf->Cell(5);
        $pdf->Cell(200,5,'Product Record List',0,1,'L');
        $pdf->SetFont('Arial','',10);
        $pdf->Cell(200,5,$setting->company_name,0,1,'L');
        $pdf->Cell(200,5,$setting->phone,0,1,'L');
        $pdf->Cell(200,5,$setting->address,0,1,'L');
        $pdf->Ln(10);

        $pdf->SetFont('Arial','B',11);
        $pdf->cell(25,6,"SL",1,"","C");
        $pdf->cell(33,6,"Serial Number",1,"","C");
        $pdf->cell(50,6,"Name",1,"","C");
        $pdf->cell(50,6,"Category",1,"","C");
        $pdf->cell(33,6,"Purchase Price",1,"","C");
        $pdf->cell(30,6,"Selling Price",1,"","C");
        $pdf->cell(20,6,"Quantity",1,"","C");
        $pdf->Ln();
        $pdf->SetFont('Times','',10);

        foreach ($allProduct as $key => $value) {
            $pdf->cell(25,5,$key+1,1,"","C");
            $pdf->cell(33,5,$value->serial_number,1,"","C");
            $pdf->cell(50,5,$value->name,1,"","L");
            $pdf->cell(50,5,$value->categoryName,1,"","L");
            $pdf->cell(33,5,$value->purchase_price,1,"","C");
            $pdf->cell(30,5,$value->selling_price,1,"","C");
            $pdf->cell(20,5,$value->stock_quantity-$value->damagedQuantity,1,"","C");
            $pdf->Ln();
        }

        $pdf->Output();
        exit;
    }

    public function downloadExcel()
    {
        $type = 'xlsx';
        
        $setting = Setting::where('id',1)->first();
        Excel::create('product-record-list', function ($excel) {
            $excel->setTitle('Product Record List');

            // Chain the setters
            $excel->sheet('Product Record', function ($sheet) {

                // first row styling and writing content
                $sheet->mergeCells('A1:E1');
                $sheet->row(1, function ($row) {
                    $row->setFontFamily('Comic Sans MS');
                    $row->setFontSize(30);
                });

                $sheet->row(1, array('Product Record List'));

                // getting data to display - in my case only one record
                $product =  new Product;
                $allProduct = $product->productAll();
                
                // setting column names for data - you can of course set it manually
                $sheet->appendRow(2,
                                    array(
                                        'ID',
                                        'Serial Number',
                                        'Name',
                                        'Category',
                                        'Purchase Price',
                                        'Selling Price',
                                        'Quantity'
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
                                        $data->selling_price,
                                        $data->stock_quantity-$data->damagedQuantity
                                        )
                                    );
                    $sheet->row($sheet->getHighestRow(), function ($row) {
                        $row->setAlignment('center');
                        $row->setBorder('thin', 'thin', 'thin', 'thin');
                    });
                }
            });

        })->export('xls');
    }

}
