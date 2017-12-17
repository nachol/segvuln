<?php

namespace App\Repository;

use App\Entity\Vulnerabilidad;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class VulnerabilidadRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Vulnerabilidad::class);
    }

    
    public function findActivas($criticidad)
    {

        $qb = $this->createQueryBuilder('v')
        ->join('v.tipo', 't', 'WITH', 'v.tipo = t.id')
        ->andWhere('v.estado = 1')
        ->andWhere('t.criticidad = :criticidad')
        ->setParameter('criticidad', $criticidad);

        return $qb->getQuery()->getResult();
        
    }

    public function findByFecha($criticidad, $fecha)
    {

        $qb = $this->createQueryBuilder('v')
        ->join('v.tipo', 't', 'WITH', 'v.tipo = t.id')
        ->andWhere('v.estado = 1')
        ->andWhere('t.criticidad = :criticidad')
        ->andWhere('v.fechaCreacion >= :fecha')
        ->setParameters(['criticidad' => $criticidad, 'fecha' => $fecha]);

        return $qb->getQuery()->getResult();
        
    }
    
}
