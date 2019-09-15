<?php


namespace App\Model;

use Doctrine\Common\Collections\ArrayCollection;

class CustomFieldModel
{
    /**
     * @var string
     */
    private $name;
    /**
     * @var ArrayCollection|string
     */
    private $val;

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return ArrayCollection|string
     */
    public function getVal()
    {
        return $this->val;
    }

    /**
     * @param ArrayCollection|string $val
     */
    public function setVal($val): void
    {
        $this->val = $val;
    }

}