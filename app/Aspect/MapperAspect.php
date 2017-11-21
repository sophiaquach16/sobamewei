<?php

namespace App\Aspect;


use Doctrine\Common\Annotations\Annotation;
use Doctrine\Common\Annotations\Reader;
use Go\Aop\Aspect;
use Go\Aop\Intercept\MethodInvocation;
use Go\Lang\Annotation\Before;
use App\Aspect\MapperAspect;
use App\Aspect\Annotations\Mapper;
use App\Classes\Mappers\ElectronicCatalogMapper;
use App\Classes\Mappers\UserCatalogMapper;
use App\Classes\Mappers\ShoppingCartMapper;

/**
 * Application logging aspect (Example provided by goaop-laravel-bridge)
 */
class MapperAspect implements Aspect
{
  private $electronicCatalogMapper;
  private $shoppingCartMapper;
  private $userCatalogMapper;

  public function __construct()
  {
    $this->electronicMapper = new ElectronicCatalogMapper();
    $this->shoppingCartMapper = new ShoppingCartMapper();
    $this->userCatalogMapper = new UserCatalogMapper();
  }

  /**
   * Writes a log info before method execution
   *
   * @param MethodInvocation $invocation
   * @Before("execution(public **->*(*))")
   */
  public function beforeMethod(MethodInvocation $invocation)
  {
    if ($from == "ecm"){
      $this->electronicCatalogMapper->$methodCall;
    }
    if ($from == "scm") {
      $this->shoppingCartMapper->$methodCall;
    }
    if ($from == "ucm"){
      $this->userCatalogMapper->$methodCall;
    }

  }


}
