<?php
/**
 * Created by PhpStorm.
 * User: Claudio
 * Date: 23/11/2017
 * Time: 0:17
 */

namespace Qubit\Bundle\UtilsBundle\Context;

use Qubit\Bundle\UtilsBundle\Utils\Util;

/**
 * Class Context
 * @package App\Classes
 */
class Context implements \JsonSerializable
{
    /**
     * @var
     */
    private static $instance;

    /**
     * @var string
     */
    private $id = '';

    /**
     * @var string
     */
    private $vertical = '';
    /**
     * @var string
     */
    private $service = '';
    /**
     * @var string
     */
    private $region = '';

    /**
     * @var string
     */
    private $userId = '';
    /**
     * @var string
     */
    private $username = '';

    /**
     * @var string
     */
    private $userRoles = '';
    /**
     * @var string
     */
    private $userRegion = '';

    /**
     * @var string
     */
    private $ipAddress = '';

    /**
     * @var string
     */
    private $deviceId = '';

    /**
     * @var string
     */
    private $userAgent = '';


    /**
     * @var bool
     */
    private $initialized = false;

    /**
     * Context constructor.
     */
    public function __construct()
    {
        try {
            $this->id = Util::generateCode();
        } catch (\Exception $e) {
        }
    }

    /**
     * @return Context
     */
    public static function getInstance()
    {
        if (!self::$instance instanceof self) {
            self::$instance = new self;
        }
        return self::$instance;
    }


    /**
     * @param \stdClass $context
     *
     * @return $this
     */
    public function hydrate(\stdClass $context)
    {
        $this->id = property_exists($context, 'id') ? $context->id : '';
        $this->vertical = property_exists($context, 'vertical') ? $context->vertical : '';
        $this->service = property_exists($context, 'service') ? $context->service : '';
        $this->region = property_exists($context, 'region') ? $context->region : '';
        $this->userId = property_exists($context, 'userId') ? $context->userId : '';
        $this->username = property_exists($context, 'username') ? $context->username : '';
        $this->userRoles = property_exists($context, 'userRoles') ? $context->userRoles : '';
        $this->userRegion = property_exists($context, 'userRegion') ? $context->userRegion : '';
        $this->ipAddress = property_exists($context, 'userRegion') ? $context->ipAddress : '';
        $this->deviceId = property_exists($context, 'deviceId') ? $context->deviceId : '';
        $this->userAgent = property_exists($context, 'userAgent') ? $context->userAgent : '';

        $this->initialized = true;

        return $this;
    }
    /**
     * {@inheritdoc}
     */
    public function jsonSerialize()
    {
        $context = [
            'id' => $this->id,
            'vertical' => $this->vertical,
            'service' => $this->service,
            'region' => $this->region,
            'userId' => $this->userId,
            'username' => $this->username,
            'userRoles' => $this->userRoles,
            'userRegion' => $this->userRegion,
            'ipAddress' => $this->ipAddress,
            'deviceId' => $this->deviceId,
            'userAgent' => $this->userAgent,
        ];

        return $context;
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @param string $id
     * @return Context
     */
    public function setId(string $id): Context
    {
        $this->id = $id;
        return $this;
    }


    /**
     * @return mixed
     */
    public function getVertical()
    {
        return $this->vertical;
    }

    /**
     * @param mixed $vertical
     *
     * @return Context
     */
    public function setVertical($vertical)
    {
        $this->vertical = $vertical;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getService()
    {
        return $this->service;
    }

    /**
     * @param mixed $service
     *
     * @return Context
     */
    public function setService($service)
    {
        $this->service = $service;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getRegion()
    {
        return $this->region;
    }

    /**
     * @param mixed $region
     *
     * @return Context
     */
    public function setRegion($region)
    {
        $this->region = $region;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * @param mixed $userId
     *
     * @return Context
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param mixed $username
     *
     * @return Context
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getUserRoles()
    {
        return $this->userRoles;
    }

    /**
     * @param mixed $userRoles
     *
     * @return Context
     */
    public function setUserRoles($userRoles)
    {
        $this->userRoles = $userRoles;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getUserRegion()
    {
        return $this->userRegion;
    }

    /**
     * @param mixed $userRegion
     *
     * @return Context
     */
    public function setUserRegion($userRegion)
    {
        $this->userRegion = $userRegion;

        return $this;
    }

    /**
     * @return string
     */
    public function getIpAddress(): string
    {
        return $this->ipAddress;
    }

    /**
     * @param string $ipAddress
     * @return Context
     */
    public function setIpAddress(string $ipAddress): Context
    {
        $this->ipAddress = $ipAddress;
        return $this;
    }

    /**
     * @return string
     */
    public function getDeviceId(): string
    {
        return $this->deviceId;
    }

    /**
     * @param string $deviceId
     * @return Context
     */
    public function setDeviceId(string $deviceId): Context
    {
        $this->deviceId = $deviceId;
        return $this;
    }

    /**
     * @return string
     */
    public function getUserAgent(): string
    {
        return $this->userAgent;
    }

    /**
     * @param string $userAgent
     * @return Context
     */
    public function setUserAgent(string $userAgent): Context
    {
        $this->userAgent = $userAgent;
        return $this;
    }

    /**
     * @return bool
     */
    public function isInitialized(): bool
    {
        return $this->initialized;
    }

    /**
     * @param bool $initialized
     * @return Context
     */
    public function setInitialized(bool $initialized): Context
    {
        $this->initialized = $initialized;
        return $this;
    }

    /**
     * @return bool
     */
    public function isAuth(): bool
    {
        return $this->initialized && !empty($this->userId) && !empty($this->deviceId);
    }

}