<?php

namespace App\Repository;

use App\Entity\PhoneNumbers;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method PhoneNumbers|null find($id, $lockMode = null, $lockVersion = null)
 * @method PhoneNumbers|null findOneBy(array $criteria, array $orderBy = null)
 * @method PhoneNumbers[]    findAll()
 * @method PhoneNumbers[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PhoneNumbersRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, PhoneNumbers::class);
    }

    /*
    public function findBySomething($value)
    {
        return $this->createQueryBuilder('p')
            ->where('p.something = :value')->setParameter('value', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */
}
