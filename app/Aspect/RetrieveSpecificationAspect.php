<?php

namespace App\Aspect;


use Doctrine\Common\Annotations\Annotation;
use Doctrine\Common\Annotations\Reader;
use Go\Aop\Aspect;
use Go\Aop\Intercept\MethodInvocation;
use Go\Lang\Annotation\Before;
use App\Aspect\RetrieveSpecificationAspect;
use App\Aspect\Annotations\RetrieveSpecification;
use App\Classes\Mappers\ElectronicCatalogMapper;

/**
 * Application logging aspect (Example provided by goaop-laravel-bridge)
 */
class RetrieveSpecificationAspect implements Aspect
{
    private $mapper;

    public function __construct()
    {
      $this->mapper = new ElectronicCatalogMapper();
    }

  /**
   * Writes a log info before method execution
   *
   * @param MethodInvocation $invocation
   * @Before("execution(public **->*(*))")
   */
  public function beforeMethod(MethodInvocation $invocation)
  {
    $retrieveObj = $invocation->getMethod()->getAnnotation(RetrieveSpecification::class);
    if ($retrieveObj === null) return;
    $request = $invocation->getArguments()[0]; // which is Request $request

    $id = $request->input($retrieveObj->from); // input of modifyRadioSelection
    if ($id !== null) $request->object = $this->getObject($id);
  }

  public function getObject($id) {
    return $this->mapper->getElectronicSpecification($id);
  }

}
