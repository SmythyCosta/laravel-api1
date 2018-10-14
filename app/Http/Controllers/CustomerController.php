<?php

namespace App\Http\Controllers;

//Imports Laravel
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

//Imports Models
use App\Customer;
use App\Setting; 
use App\LibPDF\CustomerPDF;

//
use Excel;

class CustomerController extends Controller
{

    public function customerSave(Request $request)
    {
        $customer = new Customer;
        $customer->name = $request->input('name');
        $customer->phone = $request->input('phone');
        $customer->email = $request->input('email');
        $customer->address = $request->input('address');
        $customer->discount_percentage = $request->input('discount_percentage');
        $customer->status = $request->input('status');
        $customer->gender = $request->input('gender');
        $customer->created_at = date('Y-m-d');
        
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            // Get the contents of the file
            $contents = $file->openFile()->fread($file->getSize());
            $customer->image = $contents;
        }

        $customer->save();
        return response()->json(['status'=>200,'mesg'=>'Customer Save Success']); 
    }

    public function allCustomerList()
    {
        $all = DB::table('customer')->select('customer.id', 'customer.name')
                    ->where('status',1)
                    ->orderBy('id','DESC')
                    ->get();

        return response()->json(['status'=>200,'customer'=>$all]);
    }

    public function allCustomer()
    {
        $customer = new Customer();
        $data = $customer->allCustomer();
        return response()->json(['status'=>200,'customer'=>$data]);
    }

    public function getCustomer(Request $request)
    {
        $id = $request->input('id');
        $find = Customer::find($id);
        $data = [
            'id' => $find->id,
            'name' => $find->name,
            'email' => $find->email,
            'phone' => $find->phone,
            'address' => $find->address,
            'discount_percentage' => $find->discount_percentage,
            'status' => $find->status,
            'gender' => $find->gender,
            'image' => base64_encode($find->image)
        ];
        // echo '<img src="data:image/jpeg;base64,'.base64_encode( $find->image ).'"/>';
        return response()->json(['status'=>200,'customer'=>$data]);
    }

    public function update(Request $request)
    {
        $id = $request->input('id');
        $customer = Customer::find($id);
        $customer->name = $request->input('name');
        $customer->phone = $request->input('phone');
        $customer->email = $request->input('email');
        $customer->address = $request->input('address');
        $customer->discount_percentage = $request->input('discount_percentage');
        $customer->status = $request->input('status');
        $customer->gender = $request->input('gender');
        $customer->updated_at = date('Y-m-d');
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            // Get the contents of the file
            $contents = $file->openFile()->fread($file->getSize());
            $customer->image = $contents;
        }
        $customer->save();
        return response()->json(['status'=>200,'mesg'=>'Customer Update Success']); 
    }

    public function getCustomerByDiscount(Request $request)
    {
        $id = $request->input('id');
        $customer = Customer::select('id','discount_percentage')->where('id',$id)->first();
        return response()->json(['status'=>200,'customer'=>$customer]); 
    }

    public function getCustomerInfo(Request $request)
    {
        $id = $request->input('id');
        $customer = Customer::select('id','name','email','address','phone','discount_percentage','status','image')->where('id',$id)->first();
        $invoice = DB::table('invoice')->select('id','invoice_code')->where('customer_id',$id)->get();
        $paymentInfo = '';
        foreach ($invoice as $key => $value) {
            $payment = DB::table('payment')->select(DB::raw('DATE_FORMAT(created_at,"%d %M %Y") as date'),'id','payment_type',DB::raw('SUM(amount) as amount'))->where('invoice_id',$value->id)->first();
            // print_r($payment);
            $paymentInfo[] = [
                'id' => $value->id,
                'invoice_code' => $value->invoice_code,
                'amount' => $payment->amount,
                'payment_type' => $payment->payment_type,
                'date' => $payment->date
            ];
        }
        $customerData = [
            'id' => $customer->id,
            'name' => $customer->name,
            'email' => $customer->email,
            'phone' => $customer->phone,
            'address' => $customer->address,
            'discount_percentage' => $customer->discount_percentage,
            'status' => $customer->status,
            'image' => base64_encode($customer->image)
        ];
        return response()->json(['status'=>200,'customer'=>$customerData,'purchase'=>$paymentInfo]); 
    }

    public function exportpdf(Request $request)
    {
        $customer = new Customer();
        $allCustomer = $customer->allCustomer();

        $setting = Setting::where('id',1)->first();
        $pdf = new CustomerPDF();
        $pdf->SetMargins(45, 10, 11.7);
        $pdf->AliasNbPages();
        $pdf->AddPage();
    
        $pdf->SetFont('Arial','B',12);
        // $pdf->Cell(5);
        $pdf->Cell(200,5,'Customer Record List',0,1,'L');
        $pdf->SetFont('Arial','',10);
        $pdf->Cell(200,5,$setting->company_name,0,1,'L');
        $pdf->Cell(200,5,$setting->phone,0,1,'L');
        $pdf->Cell(200,5,$setting->address,0,1,'L');
        $pdf->Cell(200,5,'Currency : '.$setting->currency,0,1,'L');
        $pdf->Ln(10);

        $pdf->SetFont('Arial','B',12);
        $pdf->cell(15,6,"SL",1,"","C");
        $pdf->cell(45,6,"Name",1,"","C");
        $pdf->cell(50,6,"Email",1,"","C");
        $pdf->cell(30,6,"Phone",1,"","C");
        $pdf->cell(50,6,"Address",1,"","C");
        $pdf->cell(20,6,"Status",1,"","C");
        $pdf->Ln();
        $pdf->SetFont('Times','',10);

        foreach ($allCustomer as $key => $value) {
            $pdf->cell(15,5,$key+1,1,"","C");
            $pdf->cell(45,5,$value->name,1,"","L");
            $pdf->cell(50,5,$value->email,1,"","L");
            $pdf->cell(30,5,$value->phone,1,"","L");
            $pdf->cell(50,5,$value->address,1,"","L");
            $pdf->cell(20,5,(($value->status==1) ? 'Active' : 'Deactive'),1,"","L");
            $pdf->Ln();
        }

        $pdf->Output();
        exit;
    }

    public function downloadExcel()
    {

        Excel::create('customer-record-list', function ($excel) {
            $excel->setTitle('Customer Record');

            $excel->sheet('Customer Record', function ($sheet) {

                // first row styling and writing content
                $sheet->mergeCells('A1:F1');
                $sheet->row(1, function ($row) {
                    $row->setFontFamily('Comic Sans MS');
                    $row->setFontSize(30);
                    // $row->setBorder('solid', 'none', 'none', 'solid');
                });

                $sheet->row(1, array('Customer Record List'));

                // getting data to display - in my case only one record
                $allData = Customer::get()->toArray();

                $sheet->appendRow(2,
                                    array(
                                        'ID',
                                        'Name',
                                        'Email',
                                        'Phone',
                                        'Address',
                                        'Status'
                                        )
                                    );

                // getting last row number (the one we already filled and setting it to bold
                $sheet->row($sheet->getHighestRow(), function ($row) {
                    $row->setFontWeight('bold');
                    $row->setAlignment('center');
                    $row->setBorder('thin', 'thin', 'thin', 'thin');
                });

                // putting users data as next rows
                foreach ($allData as $user) {

                    $sheet->appendRow(
                                    array(
                                        $user['id'],
                                        $user['name'],
                                        $user['email'],
                                        $user['phone'],
                                        $user['address'],
                                        (($user['status']==1) ? 'Active' : 'Deactive')
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