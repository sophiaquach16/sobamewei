<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Classes\Mappers\ShoppingCartMapper;
use Auth;
use Redirect;

class CustomerController extends Controller {

    private $shoppingCartMapper;

    public function __construct() {
        $this->middleware('auth');
        $this->middleware('CheckCustomer');

        $this->middleware(function ($request, $next) {
            $this->shoppingCartMapper = new ShoppingCartMapper(auth()->user()->id);
            
            return $next($request);
        });
        

        date_default_timezone_set('America/Montreal');
    }

    public function doAddToCart(Request $request) {
        if ($this->shoppingCartMapper->addToCart($request->input('eSId'), Auth::user()->id, date("Y/m/d H:i:s", strtotime("+5 minutes")))) {
            $request->session()->flash('success_msg', 'The item is added to the shopping cart.');
        } else {
            $request->session()->flash('error_msg', 'Out of stock');
        }
        return Redirect::to('/');
    }

}
