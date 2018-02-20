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
        $result=$this->transactionMapper->makeNewTransaction($request['time'], $eiList);
        if ($result === 'transactionMade') {
            $request->session()->flash('success_msg', 'Your purchase has been placed.');

        } else if ($result === 'transactionFailed') {
            $request->session()->flash('error_msg', 'Your transaction is failed.');
        }
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
        $serialNumber = ($request->input('serialNumber'));
        $ElectronicSpecification_id = ($request->input('ElectronicSpec_id'));

        $result = $this->transactionMapper->ReturnPurchase($item_id);

        if ($result === 'purchaseReturned') {
            $request->session()->flash('success_msg', 'Your purchase has been returned.');
            $this->electronicCatalogMapper->addReturnedEI($item_id,$serialNumber,$ElectronicSpecification_id);
        } else if ($result === 'returnFailed') {
            $request->session()->flash('error_msg', 'Return failed, please try again.');
        }

        return Redirect::to('/');

    }

}
