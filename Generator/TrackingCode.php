<?php

namespace Qubit\Bundle\UtilsBundle\Generator;

/**
 * Class TrackingCode
 *
 * @package Qubit\Bundle\UtilsBundle\Generator
 */
class TrackingCode
{
    const TRACKING_CODE_HEADER_NAME = 'X-Tracking-Id';
    const TRACKING_CODE_ERROR_HEADER_NAME = 'X-TrackingId-Error';

    private $trackingCode;
    private $trackingCodeHeader = false;

    public function __construct(int $length = 8)
    {
        if (!is_int($length) || $length > 32 || $length < 1) {
            throw new \InvalidArgumentException('La longitud del code debe ser un entero entre 1 y 32');
        }

        $this->trackingCode = $this->generateCode($length); 
    }

    /**
     * @return string
     */
    public function getTrackingCode(): string
    {
        return $this->trackingCode;
    }
    
    public function setTrackingCodeHeader()
    {
        $this->trackingCodeHeader = true;
    }
    
    public function getTrackingCodeHeader()
    {
        return $this->trackingCodeHeader;
    }

    /**
     * @param string $trackingCode
     */
    public function setTrackingCode(string $trackingCode)
    {
        if (!is_string($trackingCode) || strlen($trackingCode) > 32 || strlen($trackingCode) < 1) {
            throw new \InvalidArgumentException('El codigo debe ser un string con longitud entre 1 y 32');
        }

        $this->trackingCode = $trackingCode;
    }

    /**
     * @param int $length
     *
     * @return string
     */
    private function generateCode(int $length = 8): string
    {
        return substr(bin2hex(random_bytes((int) ceil($length / 2))), 0, $length);
    }
}