<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    public function index() {
        if(Auth::check())
            return Redirect('/panel');
        else
            return view("Login");
    }

    public function access(Request $request) {
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password, 'is_admin' => true])) {
            return Redirect('/panel');
        } else {
            Session::flash("login_error_message", trans('errors.auth'));

            return Redirect('/login-panel');
        }
    }

    public function logout() {
        if (Auth::check()) {
           Auth::logout();
           Session::flush();
        }
        return Redirect('/login-panel');
   }
}
