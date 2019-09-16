<?php


namespace App\Service;

use App\Client\MindBoxCrmApiClient;
use App\Model\CustomersModel;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * Class MindBoxService
 * @package App\Service
 */
class MindBoxService
{
    /**
     * @var MindBoxCrmApiClient
     */
    private $client;
    /**
     * @var RequestStack
     */
    private $requestStack;

    /**
     * MindBoxService constructor.
     * @param MindBoxCrmApiClient $client
     * @param RequestStack $requestStack
     */
    public function __construct(MindBoxCrmApiClient $client, RequestStack $requestStack)
    {
        $this->client = $client;
        $this->requestStack = $requestStack;
    }

    /**
     * @param CustomersModel $customersModel
     * @throws \Exception
     */
    public function asyncRegister(CustomersModel $customersModel)
    {
        try {
            return $this->client->postOperation(
                'register',
                $customersModel,
                $this->requestStack->getCurrentRequest()->getClientIp()
            );
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

}