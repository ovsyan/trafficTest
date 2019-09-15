<?php


namespace App\Model;

use Symfony\Component\Validator\Constraints as Assert;

class IdModel
{
    /**
     * @var string
     * @Assert\Regex(
     *     pattern="/\d+/iu",
     *     message="Неверный формат id"
     * )
     */
    private $bitrixId;

    /**
     * @return string
     */
    public function getBitrixId()
    {
        return $this->bitrixId;
    }

    /**
     * @param string $bitrixId
     */
    public function setBitrixId(string $bitrixId): void
    {
        $this->bitrixId = $bitrixId;
    }
}