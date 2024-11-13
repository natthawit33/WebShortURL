<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('login.login');
    }

    public function login(Request $request)
    {
     
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);
    
       
        $apiUrl = env('API_URL') . 'login'; 
    
     
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Cookie' => 'XSRF-TOKEN=' . $request->cookie('XSRF-TOKEN') 
        ])->post($apiUrl, [
            'email' => $request->email,
            'password' => $request->password,
        ]);
    

        if ($response->successful()) {

            $token = $response->json()['token']; 
            $name = $response->json()['name']; 
            session(['auth_token' => $token]);
            session(['name' => $name]);

            return redirect()->intended('/index')
                             ->with('token', $token); 
    
        }
    
       
        return back()->withErrors([
            'email' => 'Credentials do not match our records.',
        ]);
    }


    public function logout(Request $request)
    {
      
        $request->session()->forget('auth_token');
        $request->session()->flush();
        return redirect('/login')->with('success', 'Logout Success');
    }
    


     public function showRegisterForm()
     {
         return view('login.regis');
     }
 
  
     public function register(Request $request)
     {
       
         $response = Http::post(env('API_URL') . 'register', [
             'name' => $request->name,
             'email' => $request->email,
             'password' => $request->password,
             'password_confirmation' => $request->password_confirm,
         ]);
 
      
         if ($response->successful()) {
             return redirect()->route('login')->with('success', 'Registration successful, please log in.');
         } else {
             return redirect()->back()->withErrors(['message' => 'Registration failed. Please try again.']);
         }
     }
}
