<?php
namespace App\Classes\Mappers;

use App\Classes\Core\ElectronicCatalog as ElectronicCatalog;
use App\Classes\Core\ShoppingCart as ShoppingCart;
use App\Classes\TDG\ShoppingCartTDG as ShoppingCartTDG;
use App\Classes\TDG\ElectronicCatalogTDG as ElectronicCatalogTDG;
use App\Classes\UnitOfWork as UnitOfWork;
use App\Classes\IdentityMap as IdentityMap;
use PhpDeal\Annotation as Contract;

class ShoppingCartMapper extends ShoppingCartMapper__AopProxied implements \Go\Aop\Proxy
{

    /**
     * Property was created automatically, do not change it manually
     */
    private static $__joinPoints = [];
    
    
    public function __construct($userId)
    {
        return self::$__joinPoints['method:__construct']->__invoke($this, [$userId]);
    }
    
    /**
     * //@Contract\Verify("Auth::check() && Auth::user()->admin === 0 && count($this->shoppingCart->getEIList()) < 7")
     */
    public function addToCart($eSId, $userId, $expiry)
    {
        return self::$__joinPoints['method:addToCart']->__invoke($this, [$eSId, $userId, $expiry]);
    }
    
    
    public function updateEI($eI)
    {
        return self::$__joinPoints['method:updateEI']->__invoke($this, [$eI]);
    }
    
    
    public function viewCart()
    {
        return self::$__joinPoints['method:viewCart']->__invoke($this);
    }
    
    
    public function removeFromCart($eSId, $userId)
    {
        return self::$__joinPoints['method:removeFromCart']->__invoke($this, [$eSId, $userId]);
    }
    
}
\Go\Proxy\ClassProxy::injectJoinPoints('App\Classes\Mappers\ShoppingCartMapper',array (
  'method' => 
  array (
    '__construct' => 
    array (
      0 => 'advisor.App\\Aspect\\LoggingAspect->beforeMethod',
    ),
    'addToCart' => 
    array (
      0 => 'advisor.App\\Aspect\\LoggingAspect->beforeMethod',
    ),
    'updateEI' => 
    array (
      0 => 'advisor.App\\Aspect\\LoggingAspect->beforeMethod',
    ),
    'viewCart' => 
    array (
      0 => 'advisor.App\\Aspect\\LoggingAspect->beforeMethod',
    ),
    'removeFromCart' => 
    array (
      0 => 'advisor.App\\Aspect\\LoggingAspect->beforeMethod',
    ),
  ),
));