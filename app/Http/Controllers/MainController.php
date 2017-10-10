<?php

namespace App\Http\Controllers;

use Hash;
use Redirect;
use Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesResources;
use Illuminate\Html\HtmlServiceProvider;
use Illuminate\Http\Request;
use App\ElectronicTDG;
use Session;

//reference: https://www.cloudways.com/blog/laravel-login-authentication/
class MainController extends BaseController {

    public function showLogin() {
        return view('pages.login');
    }

    public function doLogin(Request $request) {
        $inputs = array(
            'email' => $request->input('email'),
            'password' => $request->input('password')
        );

        $rules = array(
            'email' => 'required|email',
            'password' => 'required|alphaNum|min:1'
        );

        $validator = Validator::make($inputs, $rules);

        if ($validator->fails()) {
            return Redirect::to('login')->withErrors($validator);
        } else {
            if (Auth::attempt(array(
                        'email' => $request->input('email'),
                        'password' => $request->input('password')
                    ))) {
                Session::flash('success_msg', "Successfully logged in.");
                return Redirect::to('');
            } else {
                //dd(Hash::make('admin'));
                //return Redirect::to('login');
                return view('pages.login', ['email' => $request->input('email'), 'error_msg' => 'Wrong email or password.']);
            }
        }
    }

}
