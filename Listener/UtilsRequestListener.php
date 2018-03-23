<?php

namespace Qubit\Bundle\UtilsBundle\Listener;

use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * UtilsRequestListener
 * @package Qubit\Bundle\UtilsBundle\Services
 */
class UtilsRequestListener
{
    protected $container;
    
    /**
     * __construct
     * 
     * @param object $container ContainerInterface Object
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }    

}
