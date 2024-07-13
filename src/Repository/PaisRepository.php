<?php

namespace App\Repository;

use App\Entity\Pais;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Pais>
 */
class PaisRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Pais::class);
    }

    public function findAll(): array
    {
        return  $this->createQueryBuilder('p')
            ->select('p.id,p.name')
            ->getQuery()
            ->getArrayResult();
    }
}
