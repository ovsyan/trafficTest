# Traffic test
## Подготовка к установке и запуску приложения

Скопируйте файл **.env.dist** в **.env** (https://symfony.com/doc/current/configuration/dot-env-changes.html)

в **.env** заполните значение параметров (https://developers.mindbox.ru/docs/%D0%B23)

```.dotenv
MINDBOX_BASE_URL=https://api.mindbox.ru

MINDBOX_ASYNC_ROUTE=/v3/operations/async

MINDBOX_ENDPOINT_ID=YOUR_ENDPOINT_ID

MINDBOX_SECRET=YOUR_SECRET
```
## Установка и запуск приложения
Установите зависимости через composer

``composer install``

запустите приложение

``
php bin/console server:run
``

##Просмотр запросов
Для отладки запроса, есть возможность ознакомиться с ним в [symfony profiler](https://symfony.com/doc/current/profiler.html)
![Alt text](public/img/debug.png?raw=true "debug")

##Разработано с помощью
* [Symfony 4](https://symfony.com)
* [EightPointsGuzzleBundle](https://packagist.org/packages/eightpoints/guzzle-bundle) (included by composer)