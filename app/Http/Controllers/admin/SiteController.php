<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class SiteController extends Controller
{
    protected $redirectTo = '/';
    protected $redirectAfterLogout = '/login';

    public function login()
    {
        if (Auth::check()) {
            return redirect($this->redirectTo);
        }
        
        if (Request::isMethod('post')) {
            $request = app('request');
            if (Auth::attempt(['login' => $request->input('login'), 'password' => $request->input('password')])) {
                return redirect($this->redirectTo);
            }
        }
        
        return view('admin/auth/login');
    }
    
    public function logout()
    {
        Auth::logout();
        
        return redirect($this->redirectAfterLogout);
    }
    
    public function home()
    {
        return view('admin/home');
    }
}
