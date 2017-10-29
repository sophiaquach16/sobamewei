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
use App\Classes\TDG\ElectronicTDG;
use Session;
use App\Classes\Mappers\UserCatalogMapper;
use App\Classes\Mappers\ElectronicCatalogMapper;

//reference: https://www.cloudways.com/blog/laravel-login-authentication/
class MainController extends BaseController {

    private $userCatalogMapper;
    private $electronicCatalogMapper;

    public function __construct() {
        $this->userCatalogMapper = new UserCatalogMapper();
        $this->electronicCatalogMapper = new ElectronicCatalogMapper();
    }

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

                $this->userCatalogMapper->makeLoginLog($request->user()->id);

                Session::flash('success_msg', "Successfully logged in.");
                return Redirect::to('');
            } else {
                //dd(Hash::make('admin'));
                //return Redirect::to('login');
                return view('pages.login', ['email' => $request->input('email'), 'error_msg' => 'Wrong email or password.']);
            }
        }
    }

    public function showElectronicCatalog(Request $request) {
        $inputs = $request->all();

        $eSFromType = $this->electronicCatalogMapper->getESByType($request->input('eSType'));
        $electronicSpecifications = $this->electronicCatalogMapper->getESFilteredAndSortedByCriteria($request->input('eSType'), $request->except(['eSType', 'sortBy']), $request->input('sortBy'));

        $brandNames = array();
        foreach ($eSFromType as $eS) {
            if (!in_array($eS->brandName, $brandNames)) {
                array_push($brandNames, $eS->brandName);
            }
        }
        
        $displaySizes = array();
        foreach ($eSFromType as $eS) {
            if (!in_array($eS->displaySize, $displaySizes) && !is_null($eS->displaySize)) {
                array_push($displaySizes, $eS->displaySize);
            }
        }
        
        $hasTouchScreen = false;
        if($request->input('eSType') === 'Laptop'){
            $hasTouchScreen = true;
        }

        return view('pages.index', ['electronicSpecifications' => $electronicSpecifications, 'lastInputs' => $inputs, 'brandNames' => $brandNames, 'displaySizes' => $displaySizes, 'hasTouchScreen' => $hasTouchScreen]);
    }

    public function showRegistration() {
        return view('pages.registration');
    }

    public function doRegistration(Request $request) {

        if ($this->userCatalogMapper->makeNewCustomer((object) $request->input())) {
            Session::flash('success_msg', "Successfully registered.");
            return Redirect::to('/');
        } else {
            Session::flash('error_msg', "The Email already exists.");
            return Redirect::back()->withInput();
        }
    }

}
