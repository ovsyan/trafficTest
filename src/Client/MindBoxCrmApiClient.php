<?php

namespace App\Client;

use App\Model\CustomersModel;
use GuzzleHttp\Client;
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
     */
    public function postOperation(string $operationName, CustomersModel $customersModel, $customerIp)
    {
        $serializer = new Serializer(
            [new GetSetMethodNormalizer(), new JsonSerializableNormalizer()],
            [new JsonEncoder()]
        );
        $customer = $serializer->serialize($customersModel, 'json');
        $promise = $this->postAsync(
            getenv('MINDBOX_ASYNC_ROUTE'),
            [
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

        $promise->wait();
        $promise->then(
            function ($response) {
                return $response();
            }
        );
    }
}