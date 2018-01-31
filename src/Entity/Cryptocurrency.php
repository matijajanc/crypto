<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CryptocurrencyRepository")
 */
class Cryptocurrency
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(name="tokens", type="decimal", scale=3)
     */
    private $tokens;

    /**
     * @ORM\Column(name="invested_money", type="decimal", scale=2)
     */
    private $investedMoney;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return float
     */
    public function getTokens()
    {
        return $this->tokens;
    }

    /**
     * @param float $tokens
     */
    public function setTokens($tokens)
    {
        $this->tokens = $tokens;
    }

    /**
     * @return float
     */
    public function getInvestedMoney()
    {
        return $this->investedMoney;
    }

    /**
     * @param float $investedMoney
     */
    public function setInvestedMoney($investedMoney)
    {
        $this->investedMoney = $investedMoney;
    }
}
