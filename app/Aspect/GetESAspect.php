<?php

namespace App\Aspect;

use Go\Aop\Aspect;
use Go\Aop\Intercept\MethodInvocation;
use Go\Lang\Annotation\Before;
use Psr\Log\LoggerInterface;

class GetESAspect implements Aspect
{
    /**
     * @var LoggerInterface
     */

    public function __construct()
    {}

    /**
     * Writes a log info before method execution
     *
     * @param MethodInvocation $invocation
     * @Before("execution(public **->showDetails(*))")
     */
    public function beforeMethod(MethodInvocation $invocation)
    {
        $request = $invocation->getArguments()[0];
        $request->itemId = $request->input('id');
    }
}
