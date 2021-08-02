<?php

namespace App\Repository;

use App\Entity\ShortUrl;
use App\Model\ShortUrlRequest;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ShortUrl|null find($id, $lockMode = null, $lockVersion = null)
 * @method ShortUrl|null findOneBy(array $criteria, array $orderBy = null)
 * @method ShortUrl[]    findAll()
 * @method ShortUrl[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ShortUrlRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ShortUrl::class);
    }

    public function create(ShortUrl $shortUrl): void
    {
        $this->_em->persist($shortUrl);
        $this->_em->flush();
    }

    public function update(ShortUrl $shortUrl): void
    {
        $this->_em->persist($shortUrl);
        $this->_em->flush();
    }

    public function listPaginated(int $firstResult = 0, int $maxResult = 10): \Generator
    {
        $qb = $this->createQueryBuilder('su')->setFirstResult($firstResult)->setMaxResults($maxResult);

        $paginator  = new Paginator($qb, false);

        foreach ($paginator as $item) {
            yield $item;
        }
    }

    // /**
    //  * @return ShortUrl[] Returns an array of ShortUrl objects
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
    public function findOneBySomeField($value): ?ShortUrl
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
