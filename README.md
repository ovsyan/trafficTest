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

#### Работа без загушек

Проект использует заглушки для тестирования работы приложения без аутентификационных данных от mindBox.
Чтобы работать с боевыми данными, следует:

* удалить из **config/packages/eight_points_guzzle.yaml** **MockHandler**
```yaml
eight_points_guzzle:
    clients:
        mindbox_crm_client:
            handler: 'GuzzleHttp\Handler\MockHandler' #remove me
```

* Очистить или закомментировать **MockHandler** из **src/Client/MindBoxCrmApiClient.php**

```php

namespace App\Client;
...
class MindBoxCrmApiClient extends Client
...
        $mock = new MockHandler(
            [
                new Response(200, ['Content-Type' => 'application/json'], json_encode(['status' => 'Success'])),
                new Response(
                    200, ['Content-Type' => 'application/json'], json_encode(
                        [
                            'status' => 'ValidationError',
                            'validationMessages' => [
                                [
                                    'message' => 'Потребитель с таким адресом электронной почты уже зарегистрирован',
                                    'location' => '/operation/customer/email',
                                ],
                                [
                                    'message' => 'Потребитель с таким мобильным телефоном уже зарегистрирован',
                                    'location' => '/operation/customer/mobilePhone',
                                ],
                            ],
                        ]
                    )
                ),
            ]
        );

        $handler = HandlerStack::create($mock);
...
//также необходимо убрать handler из запросов клиента
            $promise = $this->requestAsync(
                'POST',
                ...
                [
                    'handler' => $handler,
                    ...
                ]
...
```



##Просмотр запросов

Для отладки запроса, есть возможность ознакомиться с ним в [symfony profiler](https://symfony.com/doc/current/profiler.html)

***не работает с MockHandler***

![Alt text](public/img/debug.png?raw=true "debug") 


##Разработано с помощью

* [Symfony 4](https://symfony.com)
* [EightPointsGuzzleBundle](https://packagist.org/packages/eightpoints/guzzle-bundle) (included by composer)