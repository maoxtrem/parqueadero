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

  public function findAllByDepartamento(Departamento $departamento) : array {
    return $this->createQueryBuilder('m')
    ->select('m.id,m.name')
    ->andWhere('m.departamento = :departamento')
    ->setParameter('departamento',$departamento)
    ->getQuery()->getArrayResult()
    ;
  }
}
