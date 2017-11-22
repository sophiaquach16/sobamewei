<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Classes\Mappers\ShoppingCartMapper;
use App\Classes\Mappers\ElectronicCatalogMapper;
use App\Classes\Mappers\TransactionMapper;
use Auth;
use Redirect;

class CustomerController extends Controller {

    private $shoppingCartMapper;
    private $transactionMapper;
    private $electronicCatalogMapper;

    public function __construct() {
        $this->middleware('auth');
        $this->middleware('CheckCustomer');
        $this->middleware(function ($request, $next) {
            $this->shoppingCartMapper = new ShoppingCartMapper(auth()->user()->id);
            $this->transactionMapper = new TransactionMapper();
            $this->electronicCatalogMapper = new ElectronicCatalogMapper();

            return $next($request);
        });


        date_default_timezone_set('America/Montreal');
    }

    public function doAddToCart(Request $request) {
        $result = $this->shoppingCartMapper->addToCart($request->input('eSId'), Auth::user()->id, date("Y/m/d H:i:s", strtotime("+5 minutes")));

        if ($result === 'itemAddedToCart') {
            $request->session()->flash('success_msg', 'The item is added to the shopping cart.');
        } else if($result === 'itemOutOfStock') {
            $request->session()->flash('error_msg', 'Out of stock');
        } else if($result === 'shoppingCartFull'){
            $request->session()->flash('error_msg', 'Your shopping cart is full. Could not add the item.');
        }

        return Redirect::back();
    }

    public function doViewCart() {

        $eSList = $this->shoppingCartMapper->viewCart();

        return view('pages.shopping-cart', ['eSList' => $eSList]);

    }

    public function doRemove(Request $request){
        $message = $this->shoppingCartMapper->removeFromCart($request->input('eSId'), Auth::user()->id);
        $request->session()->flash('success_msg', $message);
        return Redirect::back();
    }

    public function doPurchase(Request $request){
        $request['time']=date("Y-m-d h:i:s a", time());
        $message = $this->shoppingCartMapper->purchase(Auth::user()->id,$request['time']);
        $request->session()->flash('success_msg', $message);
        //return view('pages.shopping-cart', ['eSList' => $eSList]);
        return Redirect::to('/');
    }


    public function showTransactions() {
        $transactions = $this->transactionMapper->getAllTransactions(Auth::user()->id);

        return view('pages.my-account', ['transactions' => $transactions]);
    }

    public function showTransactionDetails(Request $request) {
        $item_id=($request->input('item_id'));
        $customer_id=($request->input('customer_id'));
        $ElectronicSpec_id=($request->input('ElectronicSpec_id'));
        $serialNumber=($request->input('serialNumber'));
        $timestamp=($request->input('timestamp'));
        $electronicSpecification = $this->electronicCatalogMapper->getElectronicSpecification($ElectronicSpec_id);

        return view ('pages.show-transaction-details',['eS' => $electronicSpecification]);
    }
}
