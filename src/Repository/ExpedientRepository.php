<?php

namespace App\Repository;

use App\Entity\Expedient;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Expedient|null find($id, $lockMode = null, $lockVersion = null)
 * @method Expedient|null findOneBy(array $criteria, array $orderBy = null)
 * @method Expedient[]    findAll()
 * @method Expedient[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ExpedientRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Expedient::class);
    }

    // /**
    //  * @return Expedient[] Returns an array of Expedient objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('e.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Expedient
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
