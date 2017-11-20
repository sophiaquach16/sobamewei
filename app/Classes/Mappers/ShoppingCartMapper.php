<?php



namespace App\Classes\Mappers;

use App\Classes\Core\ElectronicCatalog;
use App\Classes\Core\ShoppingCart;
use App\Classes\TDG\ShoppingCartTDG;
use App\Classes\TDG\ElectronicCatalogTDG;
use App\Classes\Mappers\ElectronicCatalogMapper;
use App\Classes\Core\Transaction;
use App\Classes\UnitOfWork;
use App\Classes\IdentityMap;
use PhpDeal\Annotation as Contract;

class ShoppingCartMapper {

    private $electronicCatalogTDG;
    private $shoppingCart;
    private $transaction;
    private $shoppingCartTDG;
    private $unitOfWork;
    private $identityMap;
    private $electronicSpecification;
    private $ElectronicCatalogMapper;

    function __construct($userId) {
        $this->electronicCatalogTDG = new ElectronicCatalogTDG();
        $this->electronicCatalog = new ElectronicCatalog($this->electronicCatalogTDG->findAll());
        $this->shoppingCart = ShoppingCart::getInstance();
        $this->shoppingCartTDG = new ShoppingCartTDG();
        $this->unitOfWork = new UnitOfWork(['shoppingCartMapper' => $this]);
        $this->identityMap = new IdentityMap();
        $this->transaction = new transaction();
        $this->shoppingCart->setEIList($this->shoppingCartTDG->findAllEIFromUser($userId));
        $this->ElectronicCatalogMapper = new ElectronicCatalogMapper();
    }

    /**
     * //@Contract\Verify("Auth::check() && Auth::user()->admin === 0 && count($this->shoppingCart->getEIList()) < 7")
     */
    function addToCart($eSId, $userId, $expiry) {
        if (count($this->shoppingCart->getEIList()) < 7) {
            $eI = $this->electronicCatalog->reserveFirstEIFromES($eSId, $userId, $expiry);

            if ($eI != null) {
                $this->shoppingCart->addEIToCart($eI);
                $this->unitOfWork->registerDirty($eI);
                $this->unitOfWork->commit();
                
                return 'itemAddedToCart';
            } else {
                return 'itemOutOfStock';
            }
        } else {
            return 'shoppingCartFull';
        }
    }

    function updateEI($eI) {
        $this->shoppingCartTDG->updateEI($eI);
    }

    function viewCart(){
        return $this->electronicCatalog->getESListFromEIList($this->shoppingCart->getEIList());
    }

    function removeFromCart($eSId, $userId){
        $removedEI = $this->electronicCatalog->unsetUserAndExpiryFromEI($eSId, $userId);
        $this->unitOfWork->registerDirty($removedEI);
        $this->unitOfWork->commit();
        $this->shoppingCart->updateEIList();
        return 'Item Removed';
    }
    function purchase($userId, $timeStamp){
        $this->transaction->setTimeStamp($timeStamp);
        $purchaseList = $this->viewCart();

        if($purchaseList !=null){

            $list= $this->transaction->purchase($userId);

            foreach($list as $ei) {
                $this->unitOfWork->registerNew($ei);

               // $this->unitOfWork->registerDeleted($ei);
                $this->unitOfWork->commit();

            }
            //delete the ei from the catalog
            $this->deleteEI($list);
            return 'Your order is successfully placed';
        }
        else{
            return 'The shoppingCart is empty';
        }
    }

    function saveTransaction($transaction) {

        $timeStamp = $this->transaction->getTimeStamp();
        return $this->shoppingCartTDG->addTransaction($transaction, $timeStamp);
    }

    private function deleteEI($purchaseList){
        $ids=array();
        foreach($purchaseList as $ei) {
            $id=$ei->getId();
           // dd($ei);
            array_push($ids, $id);

        }

        $this->ElectronicCatalogMapper->deleteElectronicItems($ids);
    }

}
