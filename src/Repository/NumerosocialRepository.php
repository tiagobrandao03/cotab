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
    public function findNumerosSociaisByEmployee(int $employeeId): array
    {
        return $this->createQueryBuilder('n')
            ->andWhere('n.employee = :employeeId')
            ->setParameter('employeeId', $employeeId)
            ->getQuery()
            ->getResult();
    }
    public function findAllNumerosocial(): array
    {
        return $this->createQueryBuilder('n')
            ->select('n.id, n.nome_filho, n.cpf_filho')
            ->getQuery()
            ->getResult();
    }
    public function addNumerosSociais(Numerosocial $numerosSociais): static
    {
        if (!$this->numerosSociais->contains($numerosSociais)) {
            $this->numerosSociais->add($numerosSociais);
            $numerosSociais->setEmployee($this);
        }

        return $this;
    }

    public function removeNumerosSociais(Numerosocial $numerosSociais): static
    {
        if ($this->numerosSociais->removeElement($numerosSociais)) {
            // set the owning side to null (unless already changed)
            if ($numerosSociais->getEmployee() === $this) {
                $numerosSociais->setEmployee(null);
            }
        }

        return $this;
    }
    public function add(Numerosocial $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
//    /**public function add(Numerosocial $entity, bool $flush = false): void
//    {
//        $this->getEntityManager()->persist($entity);
//
//        if ($flush) {
//            $this->getEntityManager()->flush();
//        }
//    }
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
