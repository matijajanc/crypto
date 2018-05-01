<?php

namespace App\Repository;

use App\Entity\Cryptocurrency;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class CryptocurrencyRepository extends ServiceEntityRepository
{
    /**
     * CryptocurrencyRepository constructor.
     * @param RegistryInterface $registry
     */
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Cryptocurrency::class);
    }

    /**
     * Get Total Invested Money Into Cryptocurrencies
     * @return float
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function getTotalInvestedMoney(): float
    {
        $qb = $this->createQueryBuilder('c')
            ->select('SUM(c.investedMoney) AS money')
            ->getQuery()
            ->getOneOrNullResult();

        if (!is_null($qb['money'])) {
            if (!empty(getenv('INVESTED_MONEY')) && ((float) getenv('INVESTED_MONEY') > 0)) {
                return (float)getenv('INVESTED_MONEY');
            }
            return $qb['money'];
        }
        return 0;
    }
}
