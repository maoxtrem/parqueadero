<?php

namespace App\Repository;

use App\Entity\Departamento;
use App\Entity\Pais;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Departamento>
 */
class DepartamentoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Departamento::class);
    }
    public function save(Departamento $entity,$flush = true): void
    {
        $this->getEntityManager()->persist($entity);
        $flush && $this->getEntityManager()->flush();
    }

    public function remove(Departamento $entity,$flush = true): void
    {
        $this->getEntityManager()->remove($entity);
        $flush && $this->getEntityManager()->flush();
    }

    public function active_or_inactive(Departamento $entity,$flush = true): void
    {
        $entity->active();
        $this->getEntityManager()->persist($entity);
        $flush && $this->getEntityManager()->flush();
    }

    public function get_format_combo_select(Pais $pais): array
    {
        return  $this->createQueryBuilder('d')
            ->select('d.id,d.name')
            ->andWhere('d.pais = :pais')
            ->andWhere('d.status = true')
            ->setParameter('pais', $pais)
            ->getQuery()
            ->getArrayResult();
    }

    public function list_crud(): array
    {
        return  $this->createQueryBuilder('d')
            ->select('d.id, d.name name_departamento, p.id id_pais, p.name name_pais')
            ->leftJoin('d.pais', 'p')
            ->andWhere('d.status = true')
            ->andWhere('p.status = true')
            ->getQuery()
            ->getArrayResult();
    }
}
