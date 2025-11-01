<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// Controller for the profile page
class ProfileController extends Controller
{
    public function index (){
        $user = session('user');
        return view('profile')->with(compact('user'));
    }
}
