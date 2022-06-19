<?php
namespace Language\Repository;

use Doctrine\ORM\EntityRepository;
use Language\Entity\Language;

/**
 * This is the custom repository class for Quote entity.
 */
class LanguageRepository extends EntityRepository
{
    /**
     * Retrieves all quotes in descending id order.
     * @return Query
     */
    public function findLanguagesByUser($userid)
    {

        $entityManager = $this->getEntityManager();

        $queryBuilder = $entityManager->createQueryBuilder();

        $queryBuilder->select('u')
            ->from(Language::class, 'u')
            ->where('u.user = :userid')
            ->setParameter('userid', $userid)
            ->orderBy('u.id', 'DESC');


        return $queryBuilder->getQuery();
    }

}
