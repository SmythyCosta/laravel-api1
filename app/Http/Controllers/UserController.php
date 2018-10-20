<?php

namespace App\Http\Controllers;

//Imports Laravel
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

//Imports Models
use App\Models\Setting;
use App\Menu;
use App\Submenu;
use App\UserRole;
use App\User;
use App\LibPDF\UserPDF;


//libs
use Excel;
use Hash;
use JWTAuth;
use JWTAuthException;


class UserController extends Controller
{

	private $user;
    
    public function __construct(User $user){
        $this->user = $user;
    }

    public function passwordUpdate(Request $request)
    {
        $id = $request->input('id');
        $currentPassword = $request->input('currentPassword');
        $confirmPassword = bcrypt(($request->input('confirmPassword')));
        $status = '';
        $mesg = '';
        $user = User::find($id);
        if (!Hash::check($currentPassword , $user->password)){
            $status = '500';
            $mesg = "Old password don't match";
        }else{
            $user->password = $confirmPassword;
            $user->save();
            $mesg = "password chnage successfully";
        }

        return response()->json(['status'=>$status,'mesg'=>$mesg]); 
        
    }

	public function profileUpdate(Request $request)
    {
        $id = $request->input('id');
        $user = User::find($id);;
        $user->name = $request->input('name');
        $user->phone = $request->input('phone');
        $user->address = $request->input('address');

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            // Get the contents of the file
            $contents = $file->openFile()->fread($file->getSize());
            $user->image = $contents;
        }
        
        $user->save();
        return response()->json(['status'=>200,'mesg'=>'Profile Update Success']); 
        
    }

    public function userCreate(Request $request)
    {
        $email = $request->input('email');
        $exists = $this->userExistsCheck($id=null,$email);

        if($exists->id > 0){
            return response()->json(['status'=>300,'mesg'=>'user already exists']);    
        }

        $user = new User;
        $user->name = $request->input('name');
        $user->email = $email;
        $user->phone = $request->input('phone');
        $user->address = $request->input('address');
        $user->password = bcrypt($request->input('password'));
        $user->status = $request->input('status');
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            // Get the contents of the file
            $contents = $file->openFile()->fread($file->getSize());
            $user->image = $contents;
        }
        $user->save();

        return response()->json(['status'=>200,'mesg'=>'User created successfully']); 
   
    }

    public function userExistsCheck($id,$email)
    {
        if($id==null){
           $check =  User::select(DB::raw('count(id) as id'))->where('email',"{$email}")->first();
        }else{
             $check =  User::select(DB::raw('count(id) as id'))->whereNotIn('id',[$id])->where('email',$email)->first();
        }
        return $check;
    }

    public function login(Request $request){
        $credentials = $request->only('email', 'password');
        $token = null;
        try {
           if (!$token = JWTAuth::attempt($credentials)) {
            return response()->json(['status'=>400,'mesg'=>'invalid email or password']);
           }
        } catch (JWTAuthException $e) {
            return response()->json(['status'=>500,'mesg'=>'failed to create token']);
        }
        $user = JWTAuth::toUser($token);
        if($user->status==0){
            return response()->json(['status'=>300,'mesg'=>'Deactive Your Account']);
        }

        return response()->json(compact('token'));
    }

    public function getAuthUser(Request $request){
        $user = JWTAuth::toUser($request->token);
        $data = [ 
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'phone' => $user->phone,
            'address' => $user->address,
            'image' => base64_encode($user->image)
        ];

        return response()->json(['user' => $data,'status'=>200]);
    }

    public function allUser(Request $request)
    {
        $all = User::select('id', 'name', 'email', 'phone', 'address','type','status')->orderBy('id','DESC')->get();
        return response()->json(['status'=>200,'user'=>$all]); 
    }

    public function getUserData(Request $request)
    {
        $id = $request->input('id');
        $find = User::find($id);
        $data = [
            'id' => $find->id,
            'name' => $find->name,
            'email' => $find->email,
            'phone' => $find->phone,
            'address' => $find->address,
            'type' => $find->type,
            'status' => $find->status,
            'image' => base64_encode($find->image)
        ];

        return response()->json(['status'=>200,'user'=>$data]);
    }

    public function userUpdate(Request $request)
    {
        $id = $request->input('id');
        $email = $request->input('email');

        $exists = $this->userExistsCheck($id,$email);
        if($exists->id > 0){
            return response()->json(['status'=>300,'mesg'=>'user already exists']);    
        }
        $user = User::find($id);
        $user->name = $request->input('name');
        $user->email = $email;
        $user->phone = $request->input('phone');
        $user->address = $request->input('address');
        if(!empty($request->input('password'))){
            $user->password = bcrypt($request->input('password'));
        }
        $user->status = $request->input('status');
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            // Get the contents of the file
            $contents = $file->openFile()->fread($file->getSize());
            $user->image = $contents;
        }
        $user->save();
        return response()->json(['status'=>200,'mesg'=>'User Update Success']); 
    }

    public function userDelete(Request $request)
    {
        $id = $request->input('id');
        $cat= User::find($id);
        $cat->delete();
        return response()->json(['status'=>200,'mesg'=>'User delete Success']);
    }

    public function exportpdf(Request $request)
    {
        $allCustomer = User::all();
        $setting = Setting::where('id',1)->first();
        $pdf = new UserPDF();
        $pdf->SetMargins(40, 10, 11.7);
        $pdf->AliasNbPages();
        $pdf->AddPage();
    
        $pdf->SetFont('Arial','B',12);
        // $pdf->Cell(5);
        $pdf->Cell(200,5,'User Record List',0,1,'L');
        $pdf->SetFont('Arial','',10);
        $pdf->Cell(200,5,$setting->company_name,0,1,'L');
        $pdf->Cell(200,5,$setting->phone,0,1,'L');
        $pdf->Cell(200,5,$setting->address,0,1,'L');
        $pdf->Ln(10);

        $pdf->SetFont('Arial','B',12);
        $pdf->cell(10,6,"SL",1,"","C");
        $pdf->cell(45,6,"Name",1,"","C");
        $pdf->cell(45,6,"Email",1,"","C");
        $pdf->cell(45,6,"Phone",1,"","C");
        $pdf->cell(35,6,"Address",1,"","C");
        $pdf->cell(20,6,"Type",1,"","C");
        $pdf->cell(20,6,"Status",1,"","C");
        $pdf->Ln();
        $pdf->SetFont('Times','',10);

        foreach ($allCustomer as $key => $value) {
            $pdf->cell(10,5,$key+1,1,"","C");
            $pdf->cell(45,5,$value->name,1,"","L");
            $pdf->cell(45,5,$value->email,1,"","L");
            $pdf->cell(45,5,$value->phone,1,"","L");
            $pdf->cell(35,5,$value->address,1,"","L");
            $pdf->cell(20,5,(($value->type==1) ? 'Admin' : 'User'),1,"","L");
            $pdf->cell(20,5,(($value->status==1) ? 'Active' : 'Deactive'),1,"","L");
            $pdf->Ln();
        }
        $pdf->Output();
        exit;
    }

    public function downloadExcel()
    {
        $type = 'xlsx';

        $setting = Setting::where('id',1)->first();
        Excel::create('user-record-list', function ($excel) {
            $excel->setTitle('User Record List');

            $excel->sheet('User Record', function ($sheet) {

                // first row styling and writing content
                $sheet->mergeCells('A1:E1');
                $sheet->row(1, function ($row) {
                    $row->setFontFamily('Comic Sans MS');
                    $row->setFontSize(30);
                    // $row->setBorder('solid', 'none', 'none', 'solid');
                });
                // $sheet->setBorder('A1:F1', 'thin');
                $sheet->row(1, array('User Record List'));
                // getting data to display - in my case only one record
                $users = User::all();

                $sheet->appendRow(2,
                                    array(
                                        'SL',
                                        'Name',
                                        'Email',
                                        'Phone',
                                        'Address',
                                        'Type',
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
                foreach ($users as $key => $user) {

                    $sheet->appendRow(
                                    array(
                                        $key+1,
                                        $user['name'],
                                        $user['email'],
                                        $user['phone'],
                                        $user['address'],
                                        (($user['type']==1) ? 'Admin' : 'User'),
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