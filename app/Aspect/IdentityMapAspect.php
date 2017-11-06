<?php

namespace App\Aspect;

use Go\Aop\Aspect;
use Go\Aop\Intercept\MethodInvocation;
use Go\Lang\Annotation\Before;
use Go\Lang\Annotation\After;
use Go\Lang\Annotation\Around;
use Go\Lang\Annotation\Pointcut;
use Psr\Log\LoggerInterface;

/**
 * Application logging aspect (Example provided by goaop-laravel-bridge)
 */
class IdentityMapAspect implements Aspect
{
    /**
     * 
     */
    //private $logger;
    
    private $map;

    public function __construct()
    {
        //$this->logger = $logger;
    }

    /**
     * Writes a log info before method execution
     *
     * @param MethodInvocation $invocation
     * @Before("execution(public **->*(*))")
     */
    public function beforeMethod(MethodInvocation $invocation)
    {
        $this->logger->info($invocation, $invocation->getArguments());
    }
    
    /**
     * Try to intercept makeNewElectronicSpecification
     * http://go.aopphp.com/docs/pointcut-reference/
     *
     * @param MethodInvocation $invocation
     * @After("execution(public ElectronicCatalogMapper->makeNewElectronicSpecification(*))", scope="target")
     */
    public function makeNewElectronicSpecification(MethodInvocation $invocation)
    {
        
        //http://go.aopphp.com/docs/privileged-advices/
        
        /** @var ElectronicCatalogMapper $callee|$this */
        $callee = $invocation->getThis();
        
        $this->add('ElectronicSpecification', $callee->electronicSpecification);
        
        
    }
    
    private function add($objectClass, $object) {
        if (isset($this->map[$objectClass])) {
            array_push($this->map[$objectClass], $object);
        } else {
            $this->map[$objectClass] = array();
            array_push($this->map[$objectClass], $object);
        }
    }

    private function delete($objectClass, $objectProperty, $objectPropertyValue) {
        if (isset($this->map[$objectClass])) {
            foreach ($this->map[$objectClass] as $key => $value) {
                if ($this->map[$objectClass][$key]->get()->$objectProperty === $objectPropertyValue) {
                    unset($this->map[$objectClass][$key]);
                }
            }
        }
    }

    private function get($objectClass, $objectProperty, $objectPropertyValue) {
        if (isset($this->map[$objectClass])) {
            foreach ($this->map[$objectClass] as $object) {
                if ($object->get()->$objectProperty === $objectPropertyValue) {
                    return $object;
                }
            }
        } else {
            $this->map[$objectClass] = array();
        }

        return null;
    }

    private function clear() {
        $this->map = array();
    }
    
}
