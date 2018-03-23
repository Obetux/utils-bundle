<?php
/**
 * Created by PhpStorm.
 * User: cleyer
 * Date: 04/12/2017
 * Time: 16:59
 */

namespace Qubit\Bundle\UtilsBundle\Factory;

use Redis;
use Symfony\Component\Cache\Simple\AbstractCache;
use Symfony\Component\Cache\Simple\FilesystemCache;
use Symfony\Component\Cache\Simple\MemcachedCache;
use Symfony\Component\Cache\Simple\NullCache;
use Symfony\Component\Cache\Simple\RedisCache;
use Symfony\Component\Stopwatch\Stopwatch;

/**
 * Class CacheManagerFactory
 * @package App\Service
 */
class CacheManagerFactory
{
    const REDIS_CACHE = 'redis';
    const MEMCACHED_CACHE = 'memcached';
    const FILESYSTEM_CACHE = 'filesystem';
    const NULL_CACHE = 'null';
    /**
     * @var
     */
    private $type;
    private $dsn;

    private $stopwatch;

    /**
     * CacheManagerFactory constructor.
     * @param string $type
     * @param string $dsn
     * @param Stopwatch $stopwatch
     */
    public function __construct(string $type, string $dsn, Stopwatch $stopwatch)
    {
        $this->type = $type;
        $this->dsn = $dsn;
        $this->stopwatch = $stopwatch;
    }

    /**
     * @param string $namespace
     *
     * @return AbstractCache
     * @throws \ErrorEception
     */
    public function cacheManager(string $namespace = "app")
    {
        if ($this->stopwatch) {
            $this->stopwatch->start('CacheManagerFactory::cacheManager');
        }
//        self::$type = 'redis';
//        self::$dsn = 'redis://127.0.0.1:6379';
// dsn Memcached  - 'memcached://user:pass@localhost?weight=33'
        try {
            if (($this->type === $this::REDIS_CACHE) && (!empty($this->dsn)) && (extension_loaded('redis'))) {
                $options = [Redis::OPT_SERIALIZER => Redis::SERIALIZER_PHP];
                $redis = RedisCache::createConnection($this->dsn, $options);
                $cache = new RedisCache($redis, $namespace);
            } elseif (($this->type === $this::MEMCACHED_CACHE) && (!empty($this->dsn))
                && (extension_loaded('memcached')) && (MemcachedCache::isSupported())) {
                $memcached = MemcachedCache::createConnection($this->dsn);
                $cache = new MemcachedCache($memcached);
            } elseif (($this->type === $this::FILESYSTEM_CACHE)) {
                $cache = new FilesystemCache($namespace);
            } elseif (($this->type === $this::NULL_CACHE)) {
                $cache = new NullCache();
            } else {
                $cache = new FilesystemCache($namespace);
//                $cache = new NullCache();
            }
        } catch (\Exception $exep) {
            // En caso de que falle la creación del sistema de Cache, por default uso el FilesystemCache
            $cache = new FilesystemCache($namespace);
//            $cache = new NullCache();
        }
        if ($this->stopwatch) {
            $this->stopwatch->stop('CacheManagerFactory::cacheManager');
        }
        return $cache;
    }
}