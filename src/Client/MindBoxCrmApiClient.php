<?php

namespace App\Client;

use App\Model\CustomersModel;
use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer;
use Symfony\Component\Serializer\Normalizer\JsonSerializableNormalizer;
use Symfony\Component\Serializer\Serializer;


/**
 * Class MindBoxCrmApiClient
 * @package App\Client
 */
class MindBoxCrmApiClient extends Client
{
    /**
     * @param string $operationName
     * @param CustomersModel $customersModel
     * @param $customerIp
     * @throws Exception
     */
    public function postOperation(string $operationName, CustomersModel $customersModel, $customerIp)
    {
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
        $serializer = new Serializer(
            [new GetSetMethodNormalizer(), new JsonSerializableNormalizer()],
            [new JsonEncoder()]
        );
        $customer = $serializer->serialize($customersModel, 'json');
        try {
            $promise = $this->requestAsync(
                'POST',
                getenv('MINDBOX_ASYNC_ROUTE'),
                [
                    'handler' => $handler,
                    'query' => [
                        'endpointId' => getenv('MINDBOX_ENDPOINT_ID'),
                        'operation' => $operationName,
                    ],
                    'body' => $customer,
                    'headers' => [
                        'X-Customer-IP' => $customerIp,
                    ],

                ]
            );

            $promise->then(
                function ($successResponse) {
                    $response = json_decode($successResponse->getBody(), true);
                    //Выводить html - плохое решение, но с callable в php и асинхронностью по другому никак
                    if ('Success' === $response['status']) {
                        print_r(
                            "<div class='alert alert-success' role = 'alert' >{$response['status']}</div >"
                        );
                        return;
                    } elseif ('ValidationError' === $response['status']) {
                        foreach ($response['validationMessages'] as $validationMessage) {
                            print_r(
                                "<div class='alert alert-danger' role = 'alert' >
                            {$validationMessage['message']}</div >"
                            );
                        }
                    }
                },
                function ($failResponse) {
                    throw new Exception($failResponse->getBody());
                }
            );
        } catch (\Exception $exception) {
            throw new Exception($exception->getMessage());
        }

    }
}