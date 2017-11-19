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
use App\Classes\Mappers\UserCatalogMapper;
use App\Aspect\Annotations\RetrieveSpecification;
use Image;
use Session;

//reference: https://www.cloudways.com/blog/laravel-login-authentication/
class AdminController extends BaseController {

    private $electronicCatalogMapper;

    public function __construct() {
        $this->electronicCatalogMapper = new ElectronicCatalogMapper();
        $this->UserCatalogMapper = new UserCatalogMapper();
        $this->middleware('auth');
        $this->middleware('CheckAdmin');
    }

    //to locally save the image and also access them publicly,
    //create a simlink that  allow public access to the local images directory with command:
    //php artisan storage:link
    //more info: https://laravel.com/docs/5.5/filesystem#the-public-disk
    public function doAddItems(Request $request) {
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            //image will be saved with timestamp as its name
            $name = time() . '.' . $image->getClientOriginalExtension();
            //file destination  is in 'app/public/image' folder in laravel project
            $destinationPath = public_path('images/' . $name);
            Image::make($image)->resize(500, 500, function ($constraint) {
                $constraint->aspectRatio();
            })->save($destinationPath);

            // direct access to the image with url stored in $url
            $url = asset('/images/' . $name);
        } else {
            $url = null;
        }

        $electronicSpecificationData = (object) $request->except(['_token', 'quantity']);
        $electronicSpecificationData->image = $url;

        if ($this->electronicCatalogMapper->makeNewElectronicSpecification($request->input('quantity'), $electronicSpecificationData)) { //
            Session::flash('success_msg', "Successfully added the electronic specification.");
            return Redirect::to('inventory');
        } else {
            Session::flash('error_msg', "The Model number already exists.");
            return Redirect::back()->withInput();
        }
    }

    /**
     * @RetrieveSpecification(from="modifyRadioSelection")
     */
    public function doModifyOrDelete(Request $request) {
        if ($request->object !== null && $request->input('submitButton') === 'modify') {
            $eSToModify = $request->object;
            $request->session()->put('eSToModify', $eSToModify);
            switch ($eSToModify->ElectronicType_id) {
                case "1":
                    return view('pages.modify.desktop', ['eSToModify' => $eSToModify]);
                case "2":
                    return view('pages.modify.laptop', ['eSToModify' => $eSToModify]);
                case "3":
                    return view('pages.modify.monitor', ['eSToModify' => $eSToModify]);
                case "4":
                    return view('pages.modify.tablet', ['eSToModify' => $eSToModify]);
            }
            return view('index', ['eSToModify' => $eSToModify]);
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
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            //image will be saved with timestamp as its name
            $name = time() . '.' . $image->getClientOriginalExtension();
            //file destination  is in 'app/public/image' folder in laravel project
            $destinationPath = public_path('images/' . $name);
            Image::make($image)->resize(500, 500, function ($constraint) {
                $constraint->aspectRatio();
            })->save($destinationPath);

            // direct access to the image with url stored in $url
            $url = asset('/images/' . $name);
        } else {
            $url = null;
        }

        $electronicSpecificationData = (object) $request->except(['quantity', 'ElectronicType_id', '_token']);
        $electronicSpecificationData->image = $url;

        if ($this->electronicCatalogMapper->modifyElectronicSpecification($request->input('quantity'), $request->session()->get('eSToModify'), $electronicSpecificationData)) {
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
    public function showRegisteredUsers(){
        $users =$this->UserCatalogMapper->getAllUsers();
        return view('pages.show-registered-users', ['user' => $users]);
    }

}
