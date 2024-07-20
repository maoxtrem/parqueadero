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

    public function save(Pais $pais): void
    {
        $this->getEntityManager()->persist($pais);
        $this->getEntityManager()->flush();
    }
    public function remove(Pais $pais): void
    {
        $this->getEntityManager()->remove($pais);
        $this->getEntityManager()->flush();
    }


    public function findAll(): array
    {
        return  $this->createQueryBuilder('p')
            ->select('p.id,p.name')
            ->getQuery()
            ->getArrayResult();
    }
    public function list_crud(): array
    {
        return  $this->createQueryBuilder('p')
            ->select('p.id,p.name name_nombre')
            ->andWhere('p.delet = false')
            ->getQuery()
            ->getArrayResult();
    }
}
