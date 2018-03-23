<?php
/**
 * Created by PhpStorm.
 * User: Claudio
 * Date: 08/10/2017
 * Time: 19:46
 */

namespace Qubit\Bundle\UtilsBundle\Context;

use Firebase\JWT\JWT;
use Qubit\Bundle\UtilsBundle\Context\Context;

/**
 * Class ContextManager
 * @package App\Classes
 */
class ContextManager
{
    /**
     * @var \App\Classes\Context
     */
    private $context;
    /**
     * @var
     */
    private $jwt;

    /**
     * @var string
     */
    private $key = 'UnaClaveReDificil';


    /**
     * Context constructor.
     */
    public function __construct()
    {
//        $this->context = new Context();
        $this->context = Context::getInstance();
        $this->generateJWT();
    }

    /**
     *
     */
    private function generateJWT()
    {

        $iat = time();
        $exp = time() + 720000;            // Adding 2 hours - time in miliseconds;

        $token = array(
            "iat" => $iat,
            "exp" => $exp,
            'context' => $this->context,
        );
        $jwt = JWT::encode($token, $this->key);

        $this->jwt = $jwt;
    }

    /**
     * @return string
     */
    public function getToken(): string
    {
        $this->generateJWT();
        return $this->jwt;
    }

    /**
     * @return Context
     */
    public function getContext(): Context
    {
//        $decoded = JWT::decode($this->context, $this->key, array('HS256'));
        return $this->context;
    }

    /**
     * @param Context $context
     *
     * @return Context
     */
    public function setContext(Context $context)
    {
        $this->context = $context;
        return $this->context;
    }

    /**
     * @param string $context
     */
    public function load(string $context)
    {
        $decoded = JWT::decode($context, $this->key, array('HS256'));
        $this->context->hydrate($decoded->context);
    }
}
