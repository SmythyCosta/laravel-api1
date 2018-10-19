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

}