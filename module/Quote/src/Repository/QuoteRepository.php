<?php
namespace Quote\Repository;

use Doctrine\ORM\EntityRepository;
use Quote\Entity\Quote;

/**
 * This is the custom repository class for Quote entity.
 */
class QuoteRepository extends EntityRepository
{
    /**
     * Retrieves all quotes in descending id order.
     * @return Query
     */
    public function findQuotesByUser($userid)
    {

        $entityManager = $this->getEntityManager();

        $queryBuilder = $entityManager->createQueryBuilder();

        $queryBuilder->select('u')
            ->from(Quote::class, 'u')
            ->where('u.user = :userid')
            ->setParameter('userid', $userid)
            ->orderBy('u.id', 'DESC');


        return $queryBuilder->getQuery();
    }

    public function findRandomQuoteByUser($userid)
    {
        $entityManager = $this->getEntityManager();

        $queryBuilder = $entityManager->createQueryBuilder();

        $queryBuilder->select('u')
            ->from(Quote::class, 'u')
            ->where('u.user = :userid')
            ->setParameter('userid', $userid)
            ->setMaxResults(1);

        return $queryBuilder->getQuery();
    }

}
