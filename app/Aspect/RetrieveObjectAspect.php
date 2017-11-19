<?php

namespace App\Aspect;


use Doctrine\Common\Annotations\Annotation;
use Doctrine\Common\Annotations\Reader;
use Go\Aop\Aspect;
use Go\Aop\Intercept\MethodInvocation;
use Go\Lang\Annotation\Before;
use App\Aspect\RetrieveObjectAspect;
use App\Aspect\Annotations\RetrieveObject;
use App\Classes\Mappers\ElectronicCatalogMapper;

/**
 * Application logging aspect (Example provided by goaop-laravel-bridge)
 */
class RetrieveObjectAspect implements Aspect
{
    public function __construct()
    {
    }

  /**
   * Writes a log info before method execution
   *
   * @param MethodInvocation $invocation
   * @Before("execution(public **->*(*))")
   */
  public function beforeMethod(MethodInvocation $invocation)
  {
    $retrieveObj = $invocation->getMethod()->getAnnotation(RetrieveObject::class);
    if ($retrieveObj === null) return;
    $request = $invocation->getArguments()[0];

    $id = $this->getId($retrieveObj->from, $request);
    $request->object = $this->getObject($retrieveObj->kind, $id);
  }

    // from query string or input get the id of object you're trying to get
  public function getId($from, $request) {
    if ($from == "querystring") return $request->input('id');
  }

  // from kind return the right mapper, one of the 3
  public function getObject($kind, $id) {
    if ($kind == "electronic") {
      $mapper = new ElectronicCatalogMapper();
      return $mapper->getElectronicSpecification($id);
    }
    if ($kind == 2) return ShoppingCartMapper;
    if ($kind == 3) return UserCatalogMapper;
  }


}
