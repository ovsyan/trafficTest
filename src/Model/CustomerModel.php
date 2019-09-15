<?php


namespace App\Model;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;

class CustomerModel
{
    public function __construct()
    {
        $this->subscriptions = new ArrayCollection();
        $this->customFields = new ArrayCollection();
    }

    /**
     * @var int
     */
    protected $id;
    /**
     * @var ArrayCollection|IdModel[]
     * @Groups({"customer"})
     *
     */
    private $ids = [];
    /**
     * @var string
     * @Assert\Regex(
     *     pattern="/(\+?\d[- .]*){7,13}/i",
     *     message="Неверный формат телефонв"
     * )
     */
    protected $mobilePhone;
    /**
     * @var string
     */
    protected $fullName;
    /**
     * @var string
     * @Assert\Email()
     */
    protected $email;
    /**
     * @var string
     */
    protected $password;

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @param string $password
     */
    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    /**
     * @var ArrayCollection|CustomFieldModel[]
     */
    protected $customFields = [];
    /**
     * @var ArrayCollection|SubscriptionModel[]
     */
    protected $subscriptions;

    /**
     * @param $customFieldName
     * @param $value
     */
    public function setCustomField($customFieldName, $value)
    {
        $this->customFields[$customFieldName] = $value;
    }

    /**
     * @param $customFieldName
     * @param $value
     */
    public function addCustomField($customFieldName, $value)
    {
        $this->customFields[$customFieldName] = $value;
    }

    /**
     * @param $customFieldName
     */
    public function deleteCustomField($customFieldName)
    {
        unset($this->customFields[$customFieldName]);
    }

    /**
     * @param $customFieldName
     * @return array
     */
    public function getCustomField($customFieldName)
    {
        return $this->customFields[$customFieldName];
    }

    /**
     * @param ArrayCollection||SubscriptionModel[] $subscriptions
     */
    public function setSubscriptions($subscriptions): void
    {
        $this->subscriptions = $subscriptions;
    }

    /**
     * @return ArrayCollection|SubscriptionModel[]
     */
    public function getSubscriptions()
    {
        return $this->subscriptions;
    }

    /**
     * @param ArrayCollection|SubscriptionModel[] $subscriptions
     * @return $this
     */
    public function addSubscriptions(ArrayCollection $subscriptions): self
    {
        if (!$this->subscriptions->contains($subscriptions)) {
            $this->subscriptions[] = $subscriptions;
        }
        return $this;
    }

    /**
     * @param ArrayCollection|SubscriptionModel[] $subscriptions
     * @return $this
     */
    public function removeSubscriptions(ArrayCollection $subscriptions): self
    {
        if ($this->subscriptions->contains($subscriptions)) {
            $this->subscriptions->removeElement($subscriptions);
        }
        return $this;
    }

    /**
     * @return string
     */
    public function getFullName()
    {
        return $this->fullName;
    }

    /**
     * @param string $fullName
     * @return CustomerModel
     */
    public function setFullName(string $fullName): CustomerModel
    {
        $this->fullName = $fullName;
        return $this;
    }

    /**
     * @return string
     */
    public function getMobilePhone(): ?string
    {
        return $this->mobilePhone;
    }

    /**
     * @param string $mobilePhone
     */
    public function setMobilePhone(string $mobilePhone): void
    {
        $mobilePhone = preg_replace('/[\D]/u', '', $mobilePhone);
        $this->mobilePhone = $mobilePhone;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param $email
     * @return CustomerModel
     */
    public function setEmail($email): CustomerModel
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @param $id
     * @param $value
     */
    public function addId($id, $value)
    {
        $this->ids[$id] = $value;
    }

    /**
     * @param $id
     */
    public function deleteId($key)
    {
        unset($this->ids[$key]);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getIds()
    {
        return $this->ids;
    }

    /**
     * @param ArrayCollection|IdModel[] $ids
     * @return CustomerModel
     */
    public function setIds($ids)
    {
        $this->ids = $ids;
        return $this;
    }

    /**
     * @param int $id
     *
     * @return CustomerModel
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getCustomFields()
    {
        return $this->customFields;
    }

    /**
     * @param $customFields
     * @return $this
     */
    public function setCustomFields($customFields)
    {
        $this->customFields = $customFields;
        return $this;
    }

    /**
     * @return string
     */
    public function getPlainPassword(): ?string
    {
        return $this->password;
    }

    /**
     * @param string $password
     */
    public function setPlainPassword(string $password): void
    {
        $this->password = $password;
    }
}
