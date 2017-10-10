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
class AuthController extends BaseController {

    public function __construct() {
        $this->middleware('auth');
    }

    public function doLogout() {
        Auth::logout();
        Session::flash('success_msg', "Successfully logged out.");
        return redirect('');
    }

}
