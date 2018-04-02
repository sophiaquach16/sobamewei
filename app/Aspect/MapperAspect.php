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
use App\Classes\Mappers\TransactionMapper;

/**
 * Application logging aspect (Example provided by goaop-laravel-bridge)
 */
class MapperAspect implements Aspect
{
  private $electronicCatalogMapper;
  private $shoppingCartMapper;
  private $userCatalogMapper;
  private $transactionMapper;

  public function __construct()
  {
    $this->electronicCatalogMapper = new ElectronicCatalogMapper();
    //$this->shoppingCartMapper = new ShoppingCartMapper();
    $this->userCatalogMapper = new UserCatalogMapper();
    //$this->transactionMapper = new TransactionMapper();
  }

  /**
   * Writes a log info before method execution
   *
   * @param MethodInvocation $invocation
   * @Before("execution(public **->*(*))")
   */
  public function beforeMethod(MethodInvocation $invocation)
  {
    $retrieveObj = $invocation->getMethod()->getAnnotation(Mapper::class);
    if ($retrieveObj == null) return;

    $mapperType = $retrieveObj->mapperType;
    $request = $invocation->getArguments()[0];

    // check which mapper to use:

    if ($mapperType == "ecm"){
      $request->mapper = $this->electronicCatalogMapper;
    }

    if ($mapperType == "scm") {
      $request->mapper = $this->shoppingCartMapper;
      //$request->mapper = new ShoppingCartMapper(auth()->user()->id);

    }

    if ($mapperType == "ucm"){
      $request->mapper = $this->userCatalogMapper;
    }

    if ($mapperType = "tm") {
      //$request->mapper = $this->transactionMapper;
    }

  }


}
