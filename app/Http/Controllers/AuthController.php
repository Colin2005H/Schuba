<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Foundation\Auth\User as Authenticatable;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'uti_mail' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);


        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            $user = Auth::user();  // Récupérer l'utilisateur actuellement authentifié
            session(['user' => $user]);  // Stocker l'utilisateur dans la session
            return redirect('/header'); //azjajf
        }

        return back()->withErrors([
            'uti_mail' => 'Les informations d\'identification ne correspondent pas à nos enregistrements.',
        ])->withInput();
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}

?>