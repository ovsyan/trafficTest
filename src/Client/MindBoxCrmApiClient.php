<?php

namespace App\Client;

use App\Model\CustomerModel;
use App\Model\CustomersModel;
use GuzzleHttp\Client;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer;
use Symfony\Component\Serializer\Normalizer\JsonSerializableNormalizer;
use Symfony\Component\Serializer\Serializer;


class MindBoxCrmApiClient extends Client
{

    public function postOperation(string $operationName, CustomersModel $customersModel)
    {
//        $serializer = new Serializer([new GetSetMethodNormalizer()], [new JsonEncoder()]);
        $serializer = new Serializer([new GetSetMethodNormalizer(),new JsonSerializableNormalizer()], [new JsonEncoder()]);
        $customer = $serializer->serialize($customersModel, 'json');
        $promise = $this->postAsync(getenv('MINDBOX_ASYNC_ROUTE'), [
            'query' => [
                'endpointId' => getenv('MINDBOX_ENDPOINT_ID'),
                'operation' => $operationName
            ],
            'body' => $customer
        ]);

        $response = $promise->wait();
        $promise->then(function ($response) {
            var_dump($response->getHeader('Content-Type'));
            return $response->getStatusCode();
        });
    }
}