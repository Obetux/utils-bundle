<?php

namespace Qubit\Bundle\UtilsBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;

/**
 * This is the class that loads and manages your bundle configuration.
 *
 * @link http://symfony.com/doc/current/cookbook/bundles/extension.html
 */
class UtilsExtension extends Extension implements PrependExtensionInterface
{
    /**
     * {@inheritdoc}
     */
    public function prepend(ContainerBuilder $container)
    {
        $qubitUtilsBundleConfiguration = $container->getExtensionConfig('qubit_utils');

        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $qubitUtilsBundleConfiguration);

        $loader = new Loader\XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.xml');

        $contextManager = new Definition('Qubit\Bundle\UtilsBundle\Context\ContextManager');
        $contextManager->setPublic(true);
        $container->setDefinition('qubit.context.manager', $contextManager);

        // Registramos el servicio Kernel Request
        $container->register(
            'qubit.context.listener.request_listener',
            'Qubit\Bundle\UtilsBundle\EventSubscriber\ContextSubscriber'
        )
            ->addTag(
                'kernel.event_listener',
                array('event' => 'kernel.request', 'method' => 'onKernelRequest', 'priority' => '10000')
            )
            ->addArgument(new Reference('qubit.context.manager'));

        // Registramos el servicio Kernel Response
        $container->register(
            'qubit.context.listener.terminate_listener',
            'Qubit\Bundle\UtilsBundle\EventSubscriber\ContextSubscriber'
        )
            ->addTag('kernel.event_listener', array('event' => 'kernel.response', 'method' => 'onKernelResponse'))
            ->addArgument(new Reference('qubit.context.manager'));
        ;

    }
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        /*$configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.xml');*/
    }
}