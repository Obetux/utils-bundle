<?php

namespace Qubit\Bundle\UtilsBundle\Tests\DependencyInjection;

use PHPUnit\Framework\TestCase;
use Qubit\Bundle\UtilsBundle\DependencyInjection\Configuration;
use Symfony\Component\Config\Definition\Processor;

class ConfigurationTest extends TestCase
{
    public function testZeroConfiguration()
    {
        $processor = new Processor();
        $configurationArray = $processor->processConfiguration(new Configuration(), []);

        $this->assertTrue(count($configurationArray) === 0, 'Checks that no configuration is required');
    }
}