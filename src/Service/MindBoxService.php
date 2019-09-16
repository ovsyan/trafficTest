<?php


namespace App\Service;

use App\Client\MindBoxCrmApiClient;
use App\Model\CustomersModel;
use Symfony\Component\HttpFoundation\RequestStack;

class MindBoxService
{
    private $client;
    private $requestStack;

    public function __construct(MindBoxCrmApiClient $client, RequestStack $requestStack)
    {
        $this->client = $client;
        $this->requestStack = $requestStack;
    }


    public function asyncRegister(CustomersModel $customersModel)
    {
        return $this->client->postOperation(
            'register',
            $customersModel,
            $this->requestStack->getCurrentRequest()->getClientIp()
        );
    }

}