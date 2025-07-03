<?php

namespace App\Repository;

use App\Entity\Ativoemp;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Ativoemp>
 *
 * @method Ativoemp|null find($id, $lockMode = null, $lockVersion = null)
 * @method Ativoemp|null findOneBy(array $criteria, array $orderBy = null)
 * @method Ativoemp[]    findAll()
 * @method Ativoemp[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AtivoempRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Ativoemp::class);
    }
    public function add(Ativoemp $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);
        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
    //public function findAtivoByEmployee(int $employeeId): array{
    //        return $this->createQueryBuilder('a')
    //            ->andWhere('a.employee = :employeeId')
    //            ->setParameter('employeeId', $employeeId)
    //            ->orderBy('a.id', 'ASC')
    //            ->setMaxResults(10)
    //           ->getQuery()
    //           ->getResult()
    //        ;
    //    }

    //public function findAllAtivo():array{
    //        return $this->createQueryBuilder('a')
    //            ->select('a.id,a.decimoemp,a.acidentadoemp,
    //            a.feriasemp,a.diastrabemp,a.faltasemp,a.ativoemp,a.atemployee')
    //            ->setQuery()
    //            ->getResult();
    //    }
    //public function add(Ativoemp $entity, bool $flush = false):void{
    //        $this->getEntityManager()->persist($entity);
    //        if($flush){
    //            $this->getEntityManager()->flush();
    //        }
    //    }
//    /**
//     * @return Ativoemp[] Returns an array of Ativoemp objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('a.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Ativoemp
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
