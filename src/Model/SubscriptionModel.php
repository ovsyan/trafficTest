<?php

namespace App\Model;

use Symfony\Component\Serializer\Annotation\SerializedName;

class SubscriptionModel
{
    /**
    * @var string
    */
    private $pointOfContact;
    /**
     * @var string
     */
    private $topic;
    /**
     * @var boolean
     * @SerializedName("isSubsribed")
     */
    private $isSubscribed;
    /**
     * @var boolean
     */
    private $valueByDefault;

    /**
     * @return string
     */
    public function getPointOfContact()
    {
        return $this->pointOfContact;
    }

    /**
     * @param string $pointOfContact
     */
    public function setPointOfContact(string $pointOfContact): void
    {
        $this->pointOfContact = $pointOfContact;
    }

    /**
     * @return string
     */
    public function getTopic()
    {
        return $this->topic;
    }

    /**
     * @param string $topic
     */
    public function setTopic(string $topic): void
    {
        $this->topic = $topic;
    }

    /**
     * @return bool
     */
    public function isSubscribed()
    {
        return $this->isSubscribed;
    }

    /**
     * @param bool $isSubscribed
     */
    public function setIsSubscribed(bool $isSubscribed): void
    {
        $this->isSubscribed = $isSubscribed;
    }

    /**
     * @return bool
     */
    public function isValueByDefault()
    {
        return $this->valueByDefault;
    }

    /**
     * @param bool $valueByDefault
     */
    public function setValueByDefault(bool $valueByDefault): void
    {
        $this->valueByDefault = $valueByDefault;
    }

}