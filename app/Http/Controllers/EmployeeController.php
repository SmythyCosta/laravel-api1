<?php

namespace App\Http\Controllers;

//Imports Laravel
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

//Imports Models
use App\Employee;
use App\User;

class EmployeeController extends Controller
{

    public function employeeSave(Request $request)
    {

        $employee = new User;
        $employee->name = $request->input('name');
        $employee->email = $request->input('email');
        $employee->phone = $request->input('phone');
        $employee->address = $request->input('address');
        $employee->password = bcrypt($request->input('password'));
        $employee->save();

        return response()->json(['status'=>200,'mesg'=>'Employee Save Success']); 
    }
}