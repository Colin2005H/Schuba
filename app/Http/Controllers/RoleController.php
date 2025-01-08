<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Models\User;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function getRole(User $user)
    {
            return $user->getRole();
        

        return 'non_connecté';
    }
    
}
