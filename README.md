<p align="center">
    <a href="https://symfony.com" target="_blank">
        <img width=500 height=200 src="https://stcloudfront.qubit.tv/assets/public/qubit/qubit-ar/prod/images/logo-qubit-azul.svg">
    </a>
</p>

Qubit UtilsBundle is a [Symfony][1] bundle with a set of functionalities.

Installation
------------
* Get [composer][2]
* Edit your composer.json the following lines, with this we are telling composer that looks for packages in our [satis][3] server:

```json
"repositories": [
        {
            "type": "composer",
            "url": "https://repo-manager.qubit.tv/"
        },
    ],
```

* Require the lastest [tag][4] of the bundle

```bash
    composer require qubit/utils-bundle
```

* Update composer

```bash
   composer update
```

Cache Factory
------------
Provee una factory para la utilización de Cache basado en la interface de [PSR-17 Simple Cache][5].
La misma devuelve una instancia de **AbstractCache**. Posee implementación y soporte para Redis, Memcached, Filesystem y Null Cache.

* Ejemplo de declaración de servicio "App\Cache\UserCache" con namespace "app.user" mediante Redis
```yaml
    App\Service\CacheManagerFactory:
        class: Qubit\Bundle\UtilsBundle\Factory\CacheManagerFactory
        public: true
        arguments:
            - 'redis'
            - 'redis://127.0.0.1:6379'

    App\Cache\UserCache:
        factory:   'App\Service\CacheManagerFactory:cacheManager'
        arguments: ['app.user']
```

Custom Exception
------------
Define en Qubit\Bundle\UtilsBundle\Exception\CustomException una excepción de la cual heredar para la definición y manejo de errores
```php
class TestException extends CustomException
{
    protected $code = 1670;
    protected $message = "Test mensaje";
    protected $statusCode = "404";
}
```

[1]: https://symfony.com/
[2]: https://getcomposer.org/
[3]: https://github.com/composer/satis
[4]: http://git.qubit.tv:8888/Qubit/UtilsBundle/tags/
[5]: http://www.php-fig.org/psr/psr-16/
