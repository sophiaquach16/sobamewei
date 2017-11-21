<?php

namespace App\Aspect\Annotations;

use Doctrine\Common\Annotations\Annotation;
use Doctrine\Common\Annotations\Reader;
use Go\Aop\Aspect;
use Go\Aop\Intercept\MethodInvocation;
use Go\Lang\Annotation\Before;


/**
 * @Annotation
 * @Target("METHOD")
 */
class Mapper extends Annotation {

  /**
   * @Required
   *
   * @var string
   */
  public $mapperType;

}
