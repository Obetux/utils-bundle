<?php

namespace Qubit\Bundle\UtilsBundle\Annotations;
use Qubit\Bundle\UtilsBundle\Context\Context;
use Qubit\Bundle\UtilsBundle\Exception\ContextNotAuthorizedException;
use Qubit\Bundle\UtilsBundle\Exception\ContextNotInitializedException;

/**
 *
 * @Annotation
 * @Target({"METHOD","CLASS"})
 *
 */
class ContextCheck
{
    const TYPE_INIT = "INIT";
    const TYPE_AUTH = "AUTH";
    /**
     * @Required
     * @Enum({ContextCheck::TYPE_INIT, ContextCheck::TYPE_AUTH})
     */
    private $type;

    public function __construct(array $values)
    {
        $this->type = (array_key_exists('type', $values)) ? $values['type'] : ContextCheck::TYPE_INIT;
    }

    /**
     * Verifica las condiciones del Contexto segun la anotacion definida
     *
     * @throws ContextNotInitializedException
     * @throws \Exception
     */
    public function check()
    {
        $context = Context::getInstance();
//        $context->setInitialized(true);
//        $context->setDeviceId('asdasd');
//        $context->setUserId('112');
        if (!$context->isInitialized()) {
            throw new ContextNotInitializedException();
        }

        if ($this->type === ContextCheck::TYPE_AUTH) {
            if (!$context->isAuth()){
                throw new ContextNotAuthorizedException();
            }
        }
    }
}