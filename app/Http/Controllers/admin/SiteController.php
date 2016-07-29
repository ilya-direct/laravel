<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;

class SiteController extends Controller
{
    public function home()
    {
        return view('admin/home');
    }

    public function login()
    {
        if (Auth::check()) {
            return redirect('/');
        } else {
            return view('admin/auth/login');
        }
    }
}
