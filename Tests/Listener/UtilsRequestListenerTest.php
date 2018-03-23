<?php

namespace Qubit\Bundle\UtilsBundle\Tests\Listener;

use PHPUnit\Framework\TestCase;
use Qubit\Bundle\UtilsBundle\Generator\TrackingCode;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\KernelEvents;
use Qubit\Bundle\UtilsBundle\Listener\UtilsRequestListener;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Qubit\Bundle\UtilsBundle\DependencyInjection\UtilsExtension;

/**
 * UtilsRequestListenerTest
 */
class UtilsRequestListenerTest extends TestCase
{
    private $trackingCodeHeader;
    
    /**
     * setUp
     */
    public function setUp() {
        $this->trackingCodeHeader = '111111155';
    }
    
    /**
     * testHeaderWithTrackingCode
     */
    public function testHeaderWithTrackingCode()
    {
        $dispatcher = new EventDispatcher();
        $kernel = $this->getMockBuilder('Symfony\Component\HttpKernel\HttpKernelInterface')->getMock();
        $container = $this->getContainer();
        
        $trackingFirst = $container->get('qubit.utilities.tracking_code')->getTrackingCode();
        
        $request = new Request();
        $request->headers->set(TrackingCode::TRACKING_CODE_HEADER_NAME, $this->trackingCodeHeader);
        
        $dispatcher->addListener(KernelEvents::REQUEST, array(new UtilsRequestListener($container), 'onKernelRequest'));
        $event = new GetResponseEvent($kernel, $request, HttpKernelInterface::MASTER_REQUEST);
        
        $dispatcher->dispatch(KernelEvents::REQUEST, $event);
        
        $trackingSecond = $container->get('qubit.utilities.tracking_code')->getTrackingCode();
        
        // Check the first tracking code generated in the container is not equal to the tracking code passed via header
        $this->assertNotEquals($trackingFirst, $trackingSecond);
        // Check the tracking code injected in the container is the same as the passed via header
        $this->assertEquals($this->trackingCodeHeader, $trackingSecond);
    }
    
    /**
     * testHeaderWitoutTrackingCode
     */
    public function testHeaderWitoutTrackingCode()
    {
        $dispatcher = new EventDispatcher();
        $kernel = $this->getMockBuilder('Symfony\Component\HttpKernel\HttpKernelInterface')->getMock();
        $container = $this->getContainer();
        
        $trackingFirst = $container->get('qubit.utilities.tracking_code')->getTrackingCode();
        
        $request = new Request();
        
        $dispatcher->addListener(KernelEvents::REQUEST, array(new UtilsRequestListener($container), 'onKernelRequest'));
        $event = new GetResponseEvent($kernel, $request, HttpKernelInterface::MASTER_REQUEST);
        
        $dispatcher->dispatch(KernelEvents::REQUEST, $event);
        
        $trackingSecond = $container->get('qubit.utilities.tracking_code')->getTrackingCode();
        
        // Check the tracking code is not equal at the header for the tests
        $this->assertNotEquals($this->trackingCodeHeader, $trackingSecond);
        // Check the tracking code are equal as the generated when the container is created
        $this->assertEquals($trackingFirst, $trackingSecond);
    }
        
    
    /**
     * getContainer
     */
    protected function getContainer()
    {
        $container = new ContainerBuilder();
        $container->getCompilerPassConfig()->setOptimizationPasses(array());
        $container->getCompilerPassConfig()->setRemovingPasses(array());

        $loader = new UtilsExtension();

        $loader->prepend($container);
        $loader->load(array(), $container);
        $container->compile();

        return $container;
    }
}
