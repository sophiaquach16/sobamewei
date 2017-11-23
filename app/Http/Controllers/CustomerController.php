<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Classes\Mappers\ShoppingCartMapper;
use App\Classes\Mappers\ElectronicCatalogMapper;
use App\Classes\Mappers\TransactionMapper;
use Auth;
use Redirect;

class CustomerController extends Controller
{

    private $shoppingCartMapper;
    private $transactionMapper;
    private $electronicCatalogMapper;

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('CheckCustomer');
        $this->middleware(function ($request, $next) {
            $this->shoppingCartMapper = new ShoppingCartMapper(auth()->user()->id);
            $this->transactionMapper = new TransactionMapper(auth()->user()->id);
            $this->electronicCatalogMapper = new ElectronicCatalogMapper();

            return $next($request);
        });


        date_default_timezone_set('America/Montreal');
    }

    public function doAddToCart(Request $request)
    {
        $result = $this->shoppingCartMapper->addToCart($request->input('eSId'), Auth::user()->id,
            date("Y/m/d H:i:s", strtotime("+5 minutes")));

        if ($result === 'itemAddedToCart') {
            $request->session()->flash('success_msg', 'The item is added to the shopping cart.');
        } else if ($result === 'itemOutOfStock') {
            $request->session()->flash('error_msg', 'Out of stock');
        } else if ($result === 'shoppingCartFull') {
            $request->session()->flash('error_msg', 'Your shopping cart is full. Could not add the item.');
        }

        return Redirect::back();
    }

    public function doViewCart()
    {

        $eSList = $this->shoppingCartMapper->viewCart();

        return view('pages.shopping-cart', ['eSList' => $eSList]);

    }

    public function doRemove(Request $request)
    {
        $message = $this->shoppingCartMapper->removeFromCart($request->input('eSId'), Auth::user()->id);
        $request->session()->flash('success_msg', $message);
        return Redirect::back();
    }

    public function doPurchase(Request $request)
    {
        $request['time'] = date("Y-m-d h:i:s a", time());
        $userId = Auth::user()->id;
        $eiList=$this->electronicCatalogMapper->getAllEIForOnePurchaseForUser($userId);
        foreach ($eiList as $ei){
            $this->electronicCatalogMapper->deleteElectronicItems(array($ei->id));
        }
        $trList=$this->transactionMapper->makeNewTransaction($request['time'], $eiList);
        return Redirect::to('/');
    }


    public function showTransactions()
    {
        $transactions = $this->transactionMapper->getAllTransactions(Auth::user()->id);

        return view('pages.my-account', ['transactions' => $transactions]);
    }

    public function showTransactionDetails(Request $request)
    {
        $item_id = ($request->input('item_id'));
        $ElectronicSpec_id = ($request->input('ElectronicSpec_id'));
        $electronicSpecification = $this->electronicCatalogMapper->getElectronicSpecification($ElectronicSpec_id);
        $transaction = $this->transactionMapper->getTransactionByItemId($item_id);
        return view('pages.show-transaction-details', ['eS' => $electronicSpecification,
            'tr' => $transaction]);

    }

    public function doReturnPurchase(Request $request)
    {
        $item_id = ($request->input('item_id'));
        $transactions = $this->transactionMapper->ReturnPurchase(Auth::user()->id,$item_id);
        $transactionRemoved = true;
        //TODO the return code here

        //verify that from the transactions, the item returned or transaction, should no longer
        //be part of the transaction list by searching for the item id.
//        foreach ($transactions as $tr) {
//            if ($tr->item_id == $request->input('item_id')) {
//                $transactionRemoved = false;
//                break;
//            }
//        }
        //if the transaction no longer is part of the transactions, that means it has been
        //removed and show confirmation of return
//        if ($transactionRemoved == true) {
//            $request->session()->flash('success_msg', "Your purchase has been returned.");
//        }

        return view('pages.my-account', ['transactions' => $transactions]);
    }

}
