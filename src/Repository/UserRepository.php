<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;
use App\Services\PaginationService;
use App\Services\UpladFilesService;
use Doctrine\ORM\Query\Expr;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * @extends ServiceEntityRepository<User>
 */
class UserRepository extends ServiceEntityRepository implements PasswordUpgraderInterface
{
    public function __construct(
        ManagerRegistry $registry,
        private TokenStorageInterface $tokenStorage,
        private UpladFilesService $upladFilesService 
    ) {
        parent::__construct($registry, User::class);
    }

    /**
     * Used to upgrade (rehash) the user's password automatically over time.
     */

    public function save(User $user): void
    {
        $file = $user->getFotoFile();
        if ($file instanceof UploadedFile) {
            $this->upladFilesService->delete($user->getFoto());
            $this->upladFilesService->uploadFileUser($user);
        }
        $this->getEntityManager()->persist($user);
        $this->getEntityManager()->flush();
    }


    public function upgradePassword(PasswordAuthenticatedUserInterface $user, string $newHashedPassword): void
    {
        if (!$user instanceof User) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', $user::class));
        }

        $user->setPassword($newHashedPassword);
        $this->getEntityManager()->persist($user);
        $this->getEntityManager()->flush();
    }

    public function listAsPagination(PaginationService $pag): array
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
