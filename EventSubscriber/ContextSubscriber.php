<?php
namespace Qubit\Bundle\UtilsBundle\EventSubscriber;

use Qubit\Bundle\UtilsBundle\Context\ContextManager;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use Symfony\Component\HttpKernel\Event\FinishRequestEvent;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

/**
 * Class HeaderListener
 * @package App\EventListener
 */
class ContextSubscriber
{

    /**
     * @var ContextManager
     */
    private $context;
    /**
     * HeaderListener constructor.
     */
    public function __construct(ContextManager $context)
    {
        $this->context = $context;
    }

    /**
     * @param GetResponseEvent $event
     *
     * @return \Symfony\Component\HttpFoundation\Request
     */
    public function onKernelRequest(GetResponseEvent $event)
    {
        $request = $event->getRequest();

//        $request->headers->set('x-XXX-x', 'SARLANGA');

        $context = $request->headers->get('x-context');

        if (!is_null($context)) {
            $this->context->load($context);
        }

//        dump($request->headers);exit;

        return $request;
    }

    /**
     * @param FilterResponseEvent $event
     *
     * @return Response
     */
    public function onKernelResponse(FilterResponseEvent $event)
    {
        $response = $event->getResponse();

        $response->headers->set('x-sarlanga-x', 'SARLANGA');
        $response->headers->set('x-context', $this->context->getToken());

        return $response;
    }
}