<?php

namespace App\Http\Controllers;

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
use Session;
use App\Classes\Mappers\UserCatalogMapper;
use App\Classes\Mappers\ElectronicCatalogMapper;
use App\Aspect\Annotations\Mapper;
use App\Aspect\Annotations\RetrieveSpecification;

//reference: https://www.cloudways.com/blog/laravel-login-authentication/
class MainController extends BaseController {

    private $userCatalogMapper;
    private $electronicCatalogMapper;

    // want to remove these
    public function __construct() {
        // Replaced two mappers with the MapperAspect
        //$this->userCatalogMapper = new UserCatalogMapper();
        //$this->electronicCatalogMapper = new ElectronicCatalogMapper();
    }

    public function showLogin() {
        return view('pages.login');
    }

    /**
     * @Mapper(mapperType="ucm")
     */
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
            if ($request->mapper->login($request->input('email'), $request->input('password')) && Auth::attempt($inputs)) {
                $request->mapper->makeLoginLog($request->user()->id);

                Session::flash('success_msg', "Successfully logged in.");
                return Redirect::to('');
            } else {
                //dd(Hash::make('admin'));
                //return Redirect::to('login');
                return view('pages.login', ['email' => $request->input('email'), 'error_msg' => 'Wrong email or password.']);
            }
        }
    }

    /**
     * @Mapper(mapperType="ecm")
     */
    public function showElectronicCatalog(Request $request) {
        $inputs = $request->all();

        $eSFromType = $request->mapper->getESByType($request->input('eSType'));
        $electronicSpecifications = $request->mapper->getESFilteredAndSortedByCriteria($request->input('eSType'), $request->except(['eSType', 'sortBy']), $request->input('sortBy'));

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
        if ($request->input('eSType') === 'Laptop') {
            $hasTouchScreen = true;
        }

        $request->session()->put('lastInputs', $inputs);
        $request->session()->put('electronicSpecifications', $electronicSpecifications);

        return view('pages.index', ['electronicSpecifications' => $electronicSpecifications, 'lastInputs' => $inputs, 'brandNames' => $brandNames, 'displaySizes' => $displaySizes, 'hasTouchScreen' => $hasTouchScreen]);
    }

    public function showRegistration() {
        return view('pages.registration');
    }

    /**
     * @Mapper(mapperType="ucm")
     */
    public function doRegistration(Request $request) {

        if ($request->mapper->makeNewCustomer((object) $request->input())) {
            Session::flash('success_msg', "Successfully registered.");
            return Redirect::to('/');
        } else {
            Session::flash('error_msg', "The Email already exists.");
            return Redirect::back()->withInput();
        }
    }

    /**
     * @RetrieveSpecification(from="id")
     */
    public function showDetails(Request $request) {
        $es = $request->object;
        $lastInputs = $request->session()->get('lastInputs');
        $eSpecifications = $request->session()->get('electronicSpecifications');

        if($eSpecifications){

        //Determine previous id of the filtered ES list
        $previousESId = -1;
        $previousES = null;
        foreach ($eSpecifications as $eSpecification) {
            if ($eSpecification->id === $es->id && $previousES !== null) {
                $previousESId = $previousES->id;
                break;
            }
            $previousES = $eSpecification;
        }

        //Determine next id of the filtered ES list
        $nextESId = -1;
        $backwards = array_reverse($eSpecifications);
        $nextES = null;
        foreach ($backwards as $eSpecification) {
            if ($eSpecification->id === $es->id && $nextES !== null) {
                $nextESId = $nextES->id;
                break;
            }
            $nextES = $eSpecification;
        }

        //Create a query string that will be used to return to the catalog with the same filtering results
        $queryStringBack = "";
        foreach ($lastInputs as $key => $value) {
            $queryStringBack .= $key . "=" . $value . "&";
        }
        $queryStringBack = rtrim($queryStringBack, '&');

        return view('pages.details', ['eS' => $es, 'queryStringBack' => $queryStringBack, 'nextESId' => $nextESId, 'previousESId' => $previousESId]);
        }else{
            return view('pages.details', ['eS' => $es]);
        }


    }

    /**
     * @Mapper(mapperType="ucm")
     */
    public function deleteUser(Request $request){
        $message = $request->mapper->deleteUser(Auth::user()->id);
        $request->session()->flash('success_msg', "Your account has been deleted");
        return Redirect::to('/');
    }
}
