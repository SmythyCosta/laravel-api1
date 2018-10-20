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

}