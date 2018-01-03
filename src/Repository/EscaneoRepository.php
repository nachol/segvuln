<?php

namespace App\Repository;

use App\Entity\Escaneo;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class EscaneoRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Escaneo::class);
    }

    
    public function findByEstadoVulnerabilidad($estado)
    {
        return $this->createQueryBuilder('e')
            ->join('e.vulnerabilidades', 'v')
            ->where('v.estado = :estado')->setParameter('estado', $estado)
            ->getQuery()->getResult()
            ;
    }
    
}
