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

    public function save(Pais $entity,$flush = true): void
    {
        $this->getEntityManager()->persist($entity);
        $flush && $this->getEntityManager()->flush();
    }

    public function remove(Pais $entity,$flush = true): void
    {
        $this->getEntityManager()->remove($entity);
        $flush && $this->getEntityManager()->flush();
    }

    public function active_or_inactive(Pais $entity,$flush = true): void
    {
        $entity->active();
        $this->getEntityManager()->persist($entity);
        $flush && $this->getEntityManager()->flush();
    }


    public function get_format_combo_select(): array
    {
        return  $this->createQueryBuilder('p')
            ->select('p.id,p.name')
            ->andWhere('p.status = true')
            ->getQuery()
            ->getArrayResult();
    }

    public function list_crud(): array
    {
        return  $this->createQueryBuilder('p')
            ->select('p.id,p.name name_pais')
            ->andWhere('p.status = true')
            ->getQuery()
            ->getArrayResult();
    }
}
