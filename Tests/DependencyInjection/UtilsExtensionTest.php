<?php

namespace Qubit\Bundle\UtilsBundle\Tests\DependencyInjection;

use PHPUnit\Framework\TestCase;
use Qubit\Bundle\UtilsBundle\DependencyInjection\UtilsExtension;
use Qubit\Bundle\UtilsBundle\Generator\TrackingCode;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class UtilsExtensionTest extends TestCase
{
    public function testLoadedBundleServices()
    {
        $container = $this->getContainer();

        $trackingCodeServiceInstance = $container->getDefinition('qubit.utilities.tracking_code');
        
        $this->assertTrue(!is_null($trackingCodeServiceInstance), 'Checks that the instance is not null');        
        $this->assertEquals(TrackingCode::class, $trackingCodeServiceInstance->getClass(), 'ContainerBuilder class assert instanceof TrackingCode class');
    }
    
    /**
     * getContainer
     */
    protected function getContainer(array $config = array())
    {
        $container = new ContainerBuilder();
        $container->getCompilerPassConfig()->setOptimizationPasses(array());
        $container->getCompilerPassConfig()->setRemovingPasses(array());

        $loader = new UtilsExtension();

        $loader->prepend($container);
        $container->compile();

        return $container;
    }
}
