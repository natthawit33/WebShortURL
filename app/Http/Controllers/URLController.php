<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class URLController extends Controller
{
    public function create(Request $request)
{
   
    $token = session('auth_token');
    if (!$token) {
        return redirect()->route('login')->with('error', 'Please log in to continue');
    }

  
    $url = $request->input('urlori');

   
    $response = Http::withHeaders([
        'Authorization' => 'Bearer ' . $token, 
        'Content-Type' => 'application/json',
        'Cookie' => 'XSRF-TOKEN=' . $request->cookie('XSRF-TOKEN')
    ])
    ->post(env('API_URL') . 'urls', [
        'urlori' => $url, 
    ]);

  
    if ($response->successful()) {
        $data = $response->json()['data']; 
        $shortUrl = $data['short_url']; 
        $originalUrl = $data['original_url']; 
        return view('home.index', compact('shortUrl', 'originalUrl'));
    } else {
        return back()->withErrors(['error' => 'Failed to create short URL']);
    }
}



public function Myurl()
{

    $token = session('auth_token');
    if (!$token) {
        return redirect()->route('login')->with('error', 'Please log in to continue');
    }

    $response = Http::withHeaders([
        'Authorization' => 'Bearer ' . $token, 
        'Content-Type' => 'application/json',  
        'Cookie' => 'XSRF-TOKEN=' . cookie('XSRF-TOKEN')
    ])->get(env('API_URL') . 'urls'); 


    if ($response->successful()) {

        $data = $response->json('data');  


        return view('home.mylist', [
            'Myurls' => $data['data'], 
            'pagination' => $data['links'], 
            'currentPage' => $data['current_page'], 
            'lastPage' => $data['last_page']
        ]);
    } else {
        return back()->withErrors(['message' => 'Failed to fetch data from the API.']);
    }
}


public function deleteUrl($id)
{
   
    $token = session('auth_token');
    if (!$token) {
        return redirect()->route('login')->with('error', 'Please log in to continue');
    }


    $response = Http::withHeaders([
        'Authorization' => 'Bearer ' . $token, 
        'Content-Type' => 'application/json',  
        'Cookie' => 'XSRF-TOKEN=' . cookie('XSRF-TOKEN')
    ])->delete(env('API_URL') . 'urls/' . $id); 

   
    if ($response->successful()) {
        return redirect()->route('mylist')->with('success', 'URL deleted successfully.');
    } else {
        return back()->withErrors(['message' => 'Failed to delete the URL.']);
    }
}


public function updateUrl($id, Request $request)
{
    $token = session('auth_token');
    if (!$token) {
        return redirect()->route('login')->with('error', 'Please log in to continue');
    }

    
    $request->validate([
        'urlori' => 'required|url'
    ]);

   
    $response = Http::withHeaders([
        'Authorization' => 'Bearer ' . $token,
        'Content-Type' => 'application/json',
        'Cookie' => 'XSRF-TOKEN=' . cookie('XSRF-TOKEN')
    ])
    ->put(env('API_URL') . 'urls/' . $id, [
        'urlori' => $request->urlori
    ]);

   
    if ($response->successful()) {
   
        return redirect()->route('mylist')->with('success', 'URL updated successfully.');
    } else {
     
        return back()->withErrors(['message' => 'Failed to update the URL.']);
    }
}



public function redirectUrl($shortUrl)
{
    $token = session('auth_token');
    if (!$token) {
        return redirect()->route('login')->with('error', 'Please log in to continue');
    }

    
    $response = Http::withHeaders([
        'Authorization' => 'Bearer ' . $token,
        'Cookie' => 'XSRF-TOKEN=' . cookie('XSRF-TOKEN')
    ])->get(env('API_URL') . 'r/' . $shortUrl);

    
    if ($response->successful()) {
       
       
        $originalUrl = $response->json('original_url');
        
        if (!$originalUrl) {
            return back()->withErrors(['message' => 'Original URL not found.']);
        }

   
        return redirect()->away($originalUrl);
    } else {
    
        return back()->withErrors(['message' => 'Failed to retrieve the original URL.']);
    }
}



}
