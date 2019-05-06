<?php

namespace App\Repository;

use App\Entity\Expedient;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;
use DoctrineExtensions\Query\Mysql\Year;

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

    public function assignCode($year, $jurisdiction, $workgroup)
      {
          $emConfig = $this->getEntityManager()->getConfiguration();
          $emConfig->addCustomDatetimeFunction('YEAR', 'DoctrineExtensions\Query\Mysql\Year');
          $qb = $this->createQueryBuilder('e');
          $qb->select('e')
             ->where('YEAR(e.created) = :year')
             ->andWhere('e.jurisdiction = :jurisdiction')
             ->andWhere('e.workgroup = :workgroup');
          $qb->setParameter('year', $year)
             ->setParameter('jurisdiction', $jurisdiction)
             ->setParameter('workgroup', $workgroup);
          $expedients = $qb->getQuery()->getResult();
          $number = count($expedients) + 1;
          $juris = array("Civil"=>"C", "Penal"=>"P", "Laboral"=>"L", "Contencioso Administrativo"=>"CA","Administrativo"=>"A");
          return $juris[$jurisdiction].'-'.$number."/".date("Y");
      }



}
