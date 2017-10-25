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
use App\Classes\Mappers\ElectronicCatalogMapper;
use Session;

//reference: https://www.cloudways.com/blog/laravel-login-authentication/
class AdminController extends BaseController {

    private $electronicCatalogMapper;

    public function __construct() {
        $this->electronicCatalogMapper = new ElectronicCatalogMapper();
        $this->middleware('auth');
        $this->middleware('CheckAdmin');
    }

    public function doAddItems(Request $request) {
        if ($this->electronicCatalogMapper->makeNewElectronicSpecification($request->input('quantity'), (object) $request->except(['_token', 'quantity']))) {
            Session::flash('success_msg', "Successfully added the electronic specification.");
            return Redirect::to('inventory');
        } else {
            Session::flash('error_msg', "The Model number already exists.");
            return Redirect::back()->withInput();
        }
    }

    public function doModifyOrDelete(Request $request) {
        if ($request->input('modifyRadioSelection') && $request->input('submitButton') === 'modify') {
            $eSToModify = $this->electronicCatalogMapper->getElectronicSpecification($request->input('modifyRadioSelection'));
            $request->session()->put('eSToModify', $eSToModify);
            switch ($eSToModify->ElectronicType_id) {
                case "1":
                    return view('pages.modify.desktop', ['eSToModify' => $eSToModify]);
                    break;
                case "2":
                    return view('pages.modify.laptop', ['eSToModify' => $eSToModify]);
                    break;
                case "3":
                    return view('pages.modify.monitor', ['eSToModify' => $eSToModify]);
                    break;
                case "4":
                    return view('pages.modify.tablet', ['eSToModify' => $eSToModify]);
                    break;
                // case "5":
                //     return view('pages.modify.television', ['eSToModify' => $eSToModify]);
                //     break;
            }
            return view('', ['eSToModify' => $eSToModify]);
        } else {
            if ($request->input('deleteCheckboxSelections') && $request->input('submitButton') === 'delete') {
                $this->electronicCatalogMapper->deleteElectronicItems($request->input('deleteCheckboxSelections'));
                Session::flash('success_msg', "Successfully deleted the electronic items.");
                return Redirect::back();
            } else {
                Session::flash('error_msg', "No checkboxes are selected.");
                return Redirect::back();
            }
        }
    }

    public function doModify(Request $request) {
        if ($this->electronicCatalogMapper->modifyElectronicSpecification($request->input('quantity'),$request->session()->get('eSToModify'), (object)$request->except(['quantity','ElectronicType_id', '_token']))) {
            Session::flash('success_msg', "Successfully modified the electronic specification.");
            return Redirect::to('inventory');
        } else {
            Session::flash('error_msg', "The model number already exists.");
            return Redirect::back();
        }
    }

    public function showInventory() {
        $electronicSpecifications = $this->electronicCatalogMapper->getAllElectronicSpecifications();

        return view('pages.inventory', ['electronicSpecifications' => $electronicSpecifications]);
    }

    public function showAddItems() {
        return view('pages.add-items');
    }

}
