<?php

namespace App\Repository;

use App\Entity\Sector;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Sector|null find($id, $lockMode = null, $lockVersion = null)
 * @method Sector|null findOneBy(array $criteria, array $orderBy = null)
 * @method Sector[]    findAll()
 * @method Sector[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SectorRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Sector::class);
    }

    public function findByTermStrict(string $term)
    {
        $queryBuilder = $this->createQueryBuilder('c');
        $queryBuilder->where('c.name = :term');

        $queryBuilder->setParameter('term', $term);
        $queryBuilder->orderBy('c.id', 'ASC');

        $query = $queryBuilder->getQuery();

        return $query->getResult();
    }

    public function findByTerm(string $term)
    {
        $queryBuilder = $this->createQueryBuilder('c');

        $queryBuilder->where(
            $queryBuilder->expr()->orX(
                $queryBuilder->expr()->like('c.name' , ':term'),
            )
        )
        ->setParameter('term', '%'.$term.'%')
        ->orderBy('c.id', 'ASC');

        return $queryBuilder->getQuery()->getResult();
    }

    // /**
    //  * @return Sector[] Returns an array of Sector objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Sector
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
