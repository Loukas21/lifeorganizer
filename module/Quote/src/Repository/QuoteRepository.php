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
    public function findAllQuotes()
    {
        $entityManager = $this->getEntityManager();

        $queryBuilder = $entityManager->createQueryBuilder();

        $queryBuilder->select('u')
            ->from(Quote::class, 'u')
            ->orderBy('u.id', 'DESC');

        return $queryBuilder->getQuery();
    }
}
