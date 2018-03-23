<?php

namespace Qubit\Bundle\UtilsBundle\Decoder;

use FOS\RestBundle\Decoder\DecoderInterface;

/**
 * Decodes JSON data
 *
 */
class QubitJsonDecoder implements DecoderInterface
{
    /**
     * {@inheritdoc}
     */
    public function decode($data)
    {
        $decodedData = @json_decode($data, true);
        // Si no es un Json, lo trato como query string
        if (!$decodedData) {
            parse_str($data, $decodedData);
        }

        return $decodedData;
    }
}
