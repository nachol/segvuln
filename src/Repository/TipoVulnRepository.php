<?php

namespace App\Repository;

use App\Entity\TipoVuln;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class TipoVulnRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, TipoVuln::class);
    }

    
    public function findByNessusID($value)
    {
        return $this->createQueryBuilder('t')
            ->where('t.idNessus = :value')->setParameter('value', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(1)
            ->getQuery()
            ->getResult()
        ;
    }
    
}
