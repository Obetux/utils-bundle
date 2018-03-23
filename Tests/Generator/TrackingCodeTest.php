<?php

namespace Qubit\Bundle\UtilsBundle\Tests\Generator;

use PHPUnit\Framework\TestCase;
use Qubit\Bundle\UtilsBundle\Generator\TrackingCode;

class TrackingCodeTest extends TestCase
{
    public function testTrackingCodeWithLength()
    {
        $instance = new TrackingCode(10);

        $this->assertTrue(strlen($instance->getTrackingCode()) === 10, 'Checks that the generate code has the provided lenght');
    }

    public function testSetTrackingCode()
    {
        $instance = new TrackingCode(10);
        $code1 = $instance->getTrackingCode();
        $code2 = $instance->setTrackingCode('testtrackingcode');

        $this->assertTrue($code1 !== $code2, 'Checks that the setted tracking code is different from the created one');
    }

    public function testConstructorException()
    {
        try {
            new TrackingCode(33);
        } catch (\InvalidArgumentException $ex) {
            $this->assertTrue($ex->getMessage() === 'La longitud del code debe ser un entero entre 1 y 32', 'Checks that the constructor length exceeds valid value');
        }
    }

    public function testSetterException()
    {
        $instance = new TrackingCode();
        try {
            $instance->setTrackingCode('111111111111111111111111111111111111111111111111');
        } catch (\InvalidArgumentException $ex) {
            $this->assertTrue($ex->getMessage() === 'El codigo debe ser un string con longitud entre 1 y 32', 'Checks that the constructor length exceeds valid value');
        }
    }
}