<?php

namespace App\Repository;

use App\Entity\Breed;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Breed>
 *
 * @method Breed|null find($id, $lockMode = null, $lockVersion = null)
 * @method Breed|null findOneBy(array $criteria, array $orderBy = null)
 * @method Breed[]    findAll()
 * @method Breed[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BreedRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Breed::class);
    }

    public function findByType(string $type): array
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.type = :type')
            ->setParameter('type', $type)
            ->getQuery()
            ->getResult();
    }

}
