<?php

namespace App\Repository;

use App\Entity\ProjectSupporter;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ProjectSupporter>
 *
 * @method ProjectSupporter|null find($id, $lockMode = null, $lockVersion = null)
 * @method ProjectSupporter|null findOneBy(array $criteria, array $orderBy = null)
 * @method ProjectSupporter[]    findAll()
 * @method ProjectSupporter[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProjectSupporterRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ProjectSupporter::class);
    }

//    /**
//     * @return ProjectSupporter[] Returns an array of ProjectSupporter objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('p.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?ProjectSupporter
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
