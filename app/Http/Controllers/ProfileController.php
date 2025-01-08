<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function index (){
        $user = session('user');
        return view('profile')->with(compact('user'));
    }
}