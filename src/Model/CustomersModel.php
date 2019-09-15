<?php


namespace App\Model;

use Doctrine\Common\Collections\ArrayCollection;

class CustomersModel
{
    //group for json root node
    /**
     * @return CustomerModel
     */
    public function getCustomer(): CustomerModel
    {
        return $this->customer;
    }

    /**
     * @param ArrayCollection|CustomerModel $customer
     */
    public function setCustomer(CustomerModel $customer): void
    {
        $this->customer = $customer;
    }
    /**
     * @var CustomerModel
     */
    private $customer;
}