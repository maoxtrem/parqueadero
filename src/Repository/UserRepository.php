<?php

namespace App\Repository;

use App\ClassRequest\RequestPagination;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query\Expr;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

/**
 * @extends ServiceEntityRepository<User>
 */
class UserRepository extends ServiceEntityRepository
{
    public function __construct(
        ManagerRegistry $registry,
        private TokenStorageInterface $tokenStorage
    ) {
        parent::__construct($registry, User::class);
    }



    public function save(User $user, $flush = true): User
    {
        $this->getEntityManager()->persist($user);
        $flush && $this->getEntityManager()->flush();
        return $user;
    }


    public function listAsPagination(RequestPagination $pag): array
    {

        $offset = $pag->getOffset();
        $limit = $pag->getLimit();
        $sort = $pag->getSort();
        $order = $pag->getOrder();
        $search = $pag->getSearch();

        $builder =  $this->createQueryBuilder('u')
            ->select('u.id,u.username');

        ($offset !== null && $limit !== null) && $builder->setFirstResult($offset)
            ->setMaxResults($limit);

        ($offset !== null && $limit !== null && $sort !== null && $order !== null) && $builder->setFirstResult($offset)
            ->setMaxResults($limit)
            ->orderBy('u.' . $sort, $order);

        if ($search !== null) {
            $expr = new Expr();
            $orX = $expr->orX();
            foreach (['id', 'username'] as $field) {
                $orX->add($expr->like('u.' . $field, ':search'));
            }
            $builder->andWhere($orX)
                ->setParameter('search', '%' . $search . '%');
        }


        $builder->andWhere('u.id != :user')
            ->setParameter('user', $this->getUser());

        return  $builder->getQuery()
            ->getArrayResult();
    }

    public function userAll(): array
    {
        $builder =  $this->createQueryBuilder('u')
            ->select('u.id');
        return  $builder->getQuery()
            ->getArrayResult();
    }


    protected function getUser(): ?UserInterface
    {
        $token = $this->tokenStorage->getToken();
        if (null !== $token && $token->getUser() instanceof UserInterface) {
            return $token->getUser();
        }
        return null;
    }
}
