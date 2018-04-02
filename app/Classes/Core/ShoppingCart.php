<?php

namespace App\Classes\Core;

use PhpDeal\Annotation as Contract;
use App\Classes\Core\ElectronicItem;


/**
 * shopping cart class
 * @Contract\Invariant("Auth::check() && Auth::user()->admin === 0 && count($this->eIList) >= 0 && count($this->eIList) <= 7")
 */
class ShoppingCart  {
    private static  $instance= null;
    private $eIList;

    /**
     * Current size
     *
     * @var int
     */
    private $size;


    private function __construct(){
        $this->eIList = array();
        $this->size =0;
    }

    public static function getInstance(){
        if(self::$instance==null){
            self::$instance= new ShoppingCart();
        }
        return self::$instance;
    }


    /**
     * Adds an item to the shopping cart
     *
     * @param ElectronicItem $eI
     *
     * @Contract\Verify("Auth::check() === true && Auth::user()->admin === 0 && ($this->size <= 7) && Auth::user()->id === $eI->getUserId() && strtotime($eI->getExpiryForUser()) > strtotime(date('Y-m-d H:i:s')) ")    // missing check if it belongs to this user
     * @Contract\Ensure("$__result->getId()== $eI->getId() && ($this->size==$__old->size+1) &&  ($this->size<=7)")   //post-condition
     *
     */
    public function addEIToCart($eI){

        array_push($this->eIList, $eI);
        $this->size = count($this->eIList);
        $lastEIPushed= $this->eIList[count($this->eIList)-1] ;
        return $lastEIPushed;

    }

    /**
     * returns the item that are in shopping cart
     *
     * @Contract\Ensure("$this->size == $__old->size")   //post-condition
     *
     */
    public function getEIList(){
        $this->removeOutdatedEI();
        return $this->eIList;
    }



    public function setEIList($eIListData) {
        $this->eIList = array();
        //dd($eSListData);
        foreach ($eIListData as $eIData) {
            $eI = new ElectronicItem($eIData);
            array_push($this->eIList, $eI);

        }
        $this->size= count($this->eIList);
    }

    //helper method to remove the outdated EI in the eIList


    private function removeOutdatedEI(){
        foreach($this->eIList as $key => $value){
            if(strtotime($this->eIList[$key]->get()->expiryForUser) < strtotime(date("Y-m-d H:i:s"))){
                unset($this->eIList[$key]);
            }
        }
        $this->size= count($this->eIList);
    }

    //remove removed items in eIList

    /**
     * @Contract\Ensure("count($this->getEIList()) === $__old->size-1")
     */
    public function updateEIList(){
        foreach($this->eIList as $key => $value){
            if(strtotime($this->eIList[$key]->get()->expiryForUser) == null && $this->eIList[$key]->get()->userId == null){
                unset($this->eIList[$key]);
            }
        }
        $this->size= count($this->eIList);
    }

}
