<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;

/**
 * @extends ServiceEntityRepository<User>
 *
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository implements PasswordUpgraderInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    public function add(User $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(User $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * Used to upgrade (rehash) the user's password automatically over time.
     */
    public function upgradePassword(PasswordAuthenticatedUserInterface $user, string $newHashedPassword): void
    {
        if (!$user instanceof User) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', \get_class($user)));
        }

        $user->setPassword($newHashedPassword);

        $this->add($user, true);
    }

    /**
     * Get all users with a position in DB
     *
     * @return array all users whose position is not null
     */
    public function findAllWithPosition()
    {
        return $this->createQueryBuilder('u')
           ->andWhere('u.position IS NOT NULL')
           ->getQuery()
           ->getResult()
       ;
    }

    public function findPresidentPosition()
    {
        return $this->createQueryBuilder('u')
           ->andWhere('u.position = :president')
           ->setParameter('president', "Président")
           ->getQuery()
           ->getOneOrNullResult()
       ;
    }

    /**
     * Get all Users by search by lastname and firstname
     *
     * @param string|null $search
     * @return array
     */
    public function findAllBySearch(?string $search = null)
    {
        return $this->createQueryBuilder('u')
            ->orderBy("u.lastname", "ASC")
            ->orwhere("u.lastname LIKE :search")
            ->orWhere("u.firstname LIKE :search")
            ->setParameter("search","%$search%")
            ->getQuery()
            ->getResult()
            ;
    }

    /**
     * Searches for users based on specified criteria.
     *
     * @param string|null $searchValue The search value to filter users by (optional).
     * @param string|null $orderBy The column to order by (optional)
     * @param string|null $order The direction to order asc or desc (optional)
     * @param int|null $limit The maximum number of results to return (optional).
     * @param int|null $offset The offset for paginating results (optional).
     *
     * @return array An array containing 'users' (the found users).
     */
    public function searchUsers($search = null, $orderBy = null, $order = "ASC", $limit = null, $offset = null)
    {
        $queryBuilder = $this->createQueryBuilder('u');

        if ($search) {
            $queryBuilder->orwhere("u.lastname LIKE :search")
            ->orWhere("u.firstname LIKE :search")
            ->setParameter("search","%$search%");
        }

        if ($orderBy !== null) {
            $queryBuilder->orderBy('u.'.$orderBy, $order);
        }

        if ($limit) {
            $queryBuilder->setMaxResults($limit);
        }

        if($offset) {
            $queryBuilder->setFirstResult($offset);
        }

        return $queryBuilder->getQuery()->getResult();
    }

   

//    /**
//     * @return User[] Returns an array of User objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('u')
//            ->andWhere('u.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('u.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?User
//    {
//        return $this->createQueryBuilder('u')
//            ->andWhere('u.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
