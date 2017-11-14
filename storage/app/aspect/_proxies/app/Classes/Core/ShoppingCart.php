<?php
namespace App\Classes\Core;

use PhpDeal\Annotation as Contract;
use App\Classes\Core\ElectronicItem as ElectronicItem;
/**
 * shopping cart class
 * @Contract\Invariant("count($this->eIList) >= 0 && count($this->eIList) <= 7")
 */
class ShoppingCart extends ShoppingCart__AopProxied implements \Go\Aop\Proxy
{

    /**
     * Property was created automatically, do not change it manually
     */
    private static $__joinPoints = [];
    
    /**
     * Adds an item to the shopping cart
     *
     * @param ElectronicItem $eI
     *
     * @Contract\Verify("Auth::check() === true && Auth::user()->admin === 0 && ($this->size <= 7) && Auth::user()->id === $eI->getUserId() && strtotime($eI->getExpiryForUser()) > strtotime(date('Y-m-d H:i:s')) ")// missing check if it belongs to this user
     * @Contract\Ensure("$__result->getId()== $eI->getId() && ($this->size==$__old->size+1) &&  ($this->size<=7)")   //post-condition
     * 
     */
    public function addEIToCart($eI)
    {
        return self::$__joinPoints['method:addEIToCart']->__invoke($this, [$eI]);
    }
    
    /**
     * returns the item that are in shopping cart
     *
     * @Contract\Ensure("$this->size == $__old->size")   //post-condition
     * 
     */
    public function getEIList()
    {
        return self::$__joinPoints['method:getEIList']->__invoke($this);
    }
    
    
    public function setEIList($eIListData)
    {
        return self::$__joinPoints['method:setEIList']->__invoke($this, [$eIListData]);
    }
    
    
    public function updateEIList()
    {
        return self::$__joinPoints['method:updateEIList']->__invoke($this);
    }
    
}
\Go\Proxy\ClassProxy::injectJoinPoints('App\Classes\Core\ShoppingCart',array (
  'method' => 
  array (
    'addEIToCart' => 
    array (
      0 => 'advisor.App\\Aspect\\LoggingAspect->beforeMethod',
      1 => 'advisor.PhpDeal\\Aspect\\PreconditionCheckerAspect->preConditionContract',
      2 => 'advisor.PhpDeal\\Aspect\\InvariantCheckerAspect->invariantContract',
      3 => 'advisor.PhpDeal\\Aspect\\PostconditionCheckerAspect->postConditionContract',
    ),
    'getEIList' => 
    array (
      0 => 'advisor.App\\Aspect\\LoggingAspect->beforeMethod',
      1 => 'advisor.PhpDeal\\Aspect\\InvariantCheckerAspect->invariantContract',
      2 => 'advisor.PhpDeal\\Aspect\\PostconditionCheckerAspect->postConditionContract',
    ),
    'setEIList' => 
    array (
      0 => 'advisor.App\\Aspect\\LoggingAspect->beforeMethod',
      1 => 'advisor.PhpDeal\\Aspect\\InvariantCheckerAspect->invariantContract',
    ),
    'updateEIList' => 
    array (
      0 => 'advisor.App\\Aspect\\LoggingAspect->beforeMethod',
      1 => 'advisor.PhpDeal\\Aspect\\InvariantCheckerAspect->invariantContract',
    ),
  ),
));