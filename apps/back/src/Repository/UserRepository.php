<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\Persistence\ManagerRegistry;

class UserRepository extends ServiceEntityRepository
{

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    /**
     * @throws NonUniqueResultException
     */
    public function findByEmail(string $email)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.email= :email')
            ->setParameter('email', $email)
            ->getQuery()->getOneOrNullResult();
    }

    /**
     * @throws NonUniqueResultException
     */
    public function findByUsername(string $username)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.username= :username')
            ->setParameter('username', $username)
            ->getQuery()->getOneOrNullResult();
    }

    public function add(User $user, bool $flush = false): void
    {
        $this->_em->persist($user);
        if ($flush) {
            $this->_em->flush();
        }
    }
}
