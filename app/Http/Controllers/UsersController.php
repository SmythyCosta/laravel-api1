<?php

namespace App\Http\Controllers;

//Imports Laravel
use Illuminate\Http\Request;

//Imports Models
use App\User;

class UsersController extends Controller{
    
    public function index() {
        return User::all();
    }

    public function store(Request $request) {
        return User::create($request->all());
    }

    public function update(Request $request, User $user) {
        $user->update($request->all());
        return $user;
    }

    public function show(User $user) {
        return $user;
    }

    public function destroy(Request $request, User $user) {
        $user->delete();
        return $user;
    }
}
