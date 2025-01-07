<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class RoleController extends Controller
{
    public function getRole()
    {
        if (Auth::check()) {
           
            return Auth::user()->getRole();
        }

        return 'non_connecté';
    }
    
}
