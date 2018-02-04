<?php

namespace App\Service\Wallet;

use App\Entity\Cryptocurrency;
use App\Service\Wallet\Mapper\WalletMapper;
use Doctrine\ORM\EntityManagerInterface;

class WalletService
{
    /**
     * @var EntityManagerInterface
     */
    protected $em;

    /**
     * @var WalletMapper
     */
    protected $mapper;

    /**
     * WalletService constructor.
     * @param EntityManagerInterface $em
     * @param WalletMapper $mapper
     */
    public function __construct(EntityManagerInterface $em, WalletMapper $mapper)
    {
        $this->em = $em;
        $this->mapper = $mapper;
    }

    /**
     * Get Wallet Balances
     * @return array
     */
    public function getBalances()
    {
        return $this->mapper->remapBalances($this->em->getRepository(Cryptocurrency::class)->findAll());
    }
}
