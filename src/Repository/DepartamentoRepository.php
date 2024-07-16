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


    public function findAllByPais(Pais $pais): array
    {
        return  $this->createQueryBuilder('d')
            ->select('d.id,d.name')
            ->andWhere('d.pais = :pais')
            ->setParameter('pais',$pais)
            ->getQuery()
            ->getArrayResult();
    }
}
