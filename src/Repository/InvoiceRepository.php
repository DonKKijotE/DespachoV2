<?php

namespace App\Repository;

use App\Entity\Invoice;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Invoice|null find($id, $lockMode = null, $lockVersion = null)
 * @method Invoice|null findOneBy(array $criteria, array $orderBy = null)
 * @method Invoice[]    findAll()
 * @method Invoice[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class InvoiceRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Invoice::class);
    }


    public function assignCode($year, $workgroup)
          {
              $emConfig = $this->getEntityManager()->getConfiguration();
              $emConfig->addCustomDatetimeFunction('YEAR', 'DoctrineExtensions\Query\Mysql\Year');
              $qb = $this->createQueryBuilder('i');
              $qb->select('i')
                 ->where('YEAR(i.created) = :year')
                 ->andWhere('i.workgroup = :workgroup');
              $qb->setParameter('year', $year)
                 ->setParameter('workgroup', $workgroup);
              $invoices = $qb->getQuery()->getResult();
              $number = count($invoices) + 1;
              return $number."/".date("Y");
          }
}
