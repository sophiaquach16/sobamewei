<?php

namespace App\Aspect;


use Doctrine\Common\Annotations\Annotation;
use Doctrine\Common\Annotations\Reader;
use Go\Aop\Aspect;
use Go\Aop\Intercept\MethodInvocation;
use Go\Lang\Annotation\Before;
use App\Aspect\RetrieveObjectAspect;
use App\Aspect\Annotations\RetrieveObject;

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

  }

  // from kind return the right mapper, one of the 3
  public function getMapper($kind) {
    if ($kind == 1) return ElectronicCatalalogMapper;
  }

  // from query string or input get the id of object you're trying to get
  public function getId($request, $from) {

  }

}
