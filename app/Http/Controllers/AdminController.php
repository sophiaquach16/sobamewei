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
use App\Http\Middleware\checkAdmin;

//reference: https://www.cloudways.com/blog/laravel-login-authentication/
class AdminController extends BaseController {

    public function __construct() {
        $this->middleware('auth');
        $this->middleware('CheckAdmin');
    }

    public function doAddItems(Request $request) {
        $electronicTDG = new ElectronicTDG();
        $inputs = $request->except('_token');

        $electronicTDG->add($inputs);

        return Redirect::to('inventory');
        //$electronicTDG->;
    }

    public function showInventory() {
        $electronicTDG = new ElectronicTDG();
        $items = $electronicTDG->getAll();
        
        return view('pages.inventory', ['items' => $items]);
    }
    
    public function showAddItems() {
        return view('pages.add-items');
    }

}
