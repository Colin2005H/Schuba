<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Foundation\Auth\User as Authenticatable;

// controller for the authentication of users
class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'uti_mail' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);


        if (Auth::attempt($credentials)) { // Check if the credentials are correct then
            $request->session()->regenerate(); 
            $user = Auth::user();  // Fetch current user logged in
            session(['user' => $user]);  // Store user in session
            return redirect('/home'); // Redirect to home page
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

        return redirect('/'); // Redirect to login page
    }
}

?>