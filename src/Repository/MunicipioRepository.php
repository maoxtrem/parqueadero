<?php

namespace App\Repository;

use App\Entity\Departamento;
use App\Entity\Municipio;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Municipio>
 */
class MunicipioRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Municipio::class);
    }

    public function save(Municipio $entity,$flush = true): void
    {
        $this->getEntityManager()->persist($entity);
        $flush && $this->getEntityManager()->flush();
    }

    public function remove(Municipio $entity,$flush = true): void
    {
        $this->getEntityManager()->remove($entity);
        $flush && $this->getEntityManager()->flush();
    }

    public function active_or_inactive(Municipio $entity,$flush = true): void
    {
        $entity->active();
        $this->getEntityManager()->persist($entity);
        $flush && $this->getEntityManager()->flush();
    }

  public function get_format_combo_select(Departamento $departamento) : array {
    return $this->createQueryBuilder('m')
    ->select('m.id,m.name')
    ->andWhere('m.departamento = :departamento')
    ->setParameter('departamento',$departamento)
    ->getQuery()->getArrayResult()
    ;
  }

  public function list_crud(): array
  {
      return  $this->createQueryBuilder('m')
          ->select('m.id, m.name name_municipio, d.id id_departamento, d.name name_departamento')
          ->leftJoin('m.departamento', 'd')
          ->andWhere('m.status = true')
          ->andWhere('d.status = true')
          ->getQuery()
          ->getArrayResult();
  }
}
