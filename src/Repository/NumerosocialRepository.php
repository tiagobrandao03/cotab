<?php

namespace App\Repository;

use App\Entity\Numerosocial;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Numerosocial>
 *
 * @method Numerosocial|null find($id, $lockMode = null, $lockVersion = null)
 * @method Numerosocial|null findOneBy(array $criteria, array $orderBy = null)
 * @method Numerosocial[]    findAll()
 * @method Numerosocial[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NumerosocialRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Numerosocial::class);
    }

//    /**
//     * @return Numerosocial[] Returns an array of Numerosocial objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('n')
//            ->andWhere('n.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('n.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Numerosocial
//    {
//        return $this->createQueryBuilder('n')
//            ->andWhere('n.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
