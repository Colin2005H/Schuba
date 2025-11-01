<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Models\Enseigner;
use App\Models\User;
use Illuminate\Http\Request;

class RoleController extends Controller
{    
    /**
     * getRole
     *return the role of the user (responsable, eleve, ...)
     * @param  mixed $user
     * @return void
     */
    public function getRole(User $user)
    {
            return $user->getRole();
        

        return 'non_connecté';
    }

    public function getTeachingLevel($userId)
    {       
            $ens = new Enseigner();
            return $ens->getTeachingLevel($userId);
        

        return 'non_connecté';
    }
    
}
