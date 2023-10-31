<?php

namespace App\Repository;

use App\Entity\EntityAbstract;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<EntityAbstract>
 *
 * @method EntityAbstract|null find($id, $lockMode = null, $lockVersion = null)
 * @method EntityAbstract|null findOneBy(array $criteria, array $orderBy = null)
 * @method EntityAbstract[]    findAll()
 * @method EntityAbstract[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EntityAbstractRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EntityAbstract::class);
    }

//    /**
//     * @return EntityAbstract[] Returns an array of EntityAbstract objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('e.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?EntityAbstract
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
