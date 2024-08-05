<?php

namespace App\Repository;

use App\ClassRequest\RequestPagination;
use App\Entity\Departamento;
use App\Entity\Municipio;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query\Expr;
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

  public function listAsPagination(RequestPagination $pag): array
  {

      $offset = $pag->getOffset();
      $limit = $pag->getLimit();
      $sort = $pag->getSort();
      $order = $pag->getOrder();
      $search = $pag->getSearch();

      $builder =  $this->createQueryBuilder('m')
      ->select('m.id, m.name name_municipio, d.id id_departamento, d.name name_departamento,p.id id_pais, p.name name_pais')
      ->leftJoin('m.departamento', 'd')
      ->leftJoin('d.pais', 'p')
      ->andWhere('m.status = true')
      ->andWhere('d.status = true')
      ->andWhere('p.status = true');

      ($offset !== null && $limit !== null) && $builder->setFirstResult($offset)
          ->setMaxResults($limit);

      ($offset !== null && $limit !== null && $sort !== null && $order !== null) && $builder->setFirstResult($offset)
          ->setMaxResults($limit)
          ->orderBy($sort, $order);

      if ($search !== null) {
          $expr = new Expr();
          $orX = $expr->orX();
          foreach (['id', 'name'] as $field) {
              $orX->add($expr->like('m.' . $field, ':search'));
          }
          $builder->andWhere($orX)
              ->setParameter('search', '%' . $search . '%');
      }

      return  $builder->getQuery()
          ->getArrayResult();
  }
  public function countUsers(): int
  {
      $builder = $this->createQueryBuilder('m')
          ->select('count(m.id)')
          ->leftJoin('m.departamento', 'd')
          ->leftJoin('d.pais', 'p')
          ->andWhere('m.status = true')
          ->andWhere('d.status = true')
          ->andWhere('p.status = true');
      return (int) $builder->getQuery()->getSingleScalarResult();
  }


}
