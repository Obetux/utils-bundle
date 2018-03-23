<?php

namespace Qubit\Bundle\UtilsBundle\EventSubscriber;

use Doctrine\Common\Annotations\Reader;
use Doctrine\Common\Util\ClassUtils;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;

class ContextAnnotationSubscriber implements EventSubscriberInterface
{
    protected $reader;

    public function __construct(Reader $reader)
    {
        /** @var AnnotationReader $reader */
        $this->reader = $reader;
    }

    public function onKernelController(FilterControllerEvent $event)
    {
        $controller = $event->getController();
        /*
         * $controller passed can be either a class or a Closure.
         * This is not usual in Symfony2 but it may happen.
         * If it is a class, it comes in array format
         *
         */
        if (!is_array($controller)) {
            return;
        }

        list($controllerObject, $methodName) = $controller;

        $demoAnnotation = 'Qubit\Bundle\UtilsBundle\Annotations\ContextCheck';

        $message = '';

        // Get class annotation
        // Using ClassUtils::getClass in case the controller is an proxy
        $classAnnotation = $this->reader->getClassAnnotation(
            new \ReflectionClass(ClassUtils::getClass($controllerObject)),
            $demoAnnotation
        );
        if ($classAnnotation) {
//            $message .=  $classAnnotation->message.'<br>';
            $classAnnotation->check();
        }

        // Get method annotation
        $controllerReflectObj = new \ReflectionObject($controllerObject);
        $reflectionMethod = $controllerReflectObj->getMethod($methodName);
        $methodAnnotation = $this->reader->getMethodAnnotation($reflectionMethod, $demoAnnotation);
        if ($methodAnnotation) {
//            $message .=  $methodAnnotation->message.'<br>';
            $methodAnnotation->check();
        }

    }

    public static function getSubscribedEvents()
    {
        return [
           'kernel.controller' => 'onKernelController',
        ];
    }
}
