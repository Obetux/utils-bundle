<?php
/**
 * Created by PhpStorm.
 * User: cleyer
 * Date: 05/12/2017
 * Time: 16:23
 */

namespace Qubit\Bundle\UtilsBundle\Utils;

/**
 * Class Util
 * @package Qubit\Bundle\UtilsBundle\Utils
 */
class Util
{

    /**
     * Genera un code. En 500000 iteraciones eventualmente genera colision
     *
     * @param int $length
     * @return string
     * @throws \Exception
     */
    public static function generateCode(int $length = 10): string
    {
        return substr(bin2hex(random_bytes((int) ceil($length / 2))), 0, $length);
    }

    /**
     *
     * Sanitiza las key para usar para Cache
     *
     * @param $key
     *
     * @return mixed
     */
    public static function sanitizeCacheKey($key): string
    {
        $chars = ["{","}","(",")","/","\\","@",":"];
        $key = str_replace($chars, "", $key);

        return $key;
    }


}