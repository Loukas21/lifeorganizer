<?php
namespace Hobby\Repository;

use Doctrine\ORM\EntityRepository;
use Hobby\Entity\Hobby;

/**
 * This is the custom repository class for Hobby entity.
 */
class HobbyRepository extends EntityRepository
{
    /**
     * Retrieves all quotes in descending id order.
     * @return Query
     */
    public function findAuthoritiesByUser($userid)
    {

        $entityManager = $this->getEntityManager();

        $queryBuilder = $entityManager->createQueryBuilder();

        $queryBuilder->select('u')
            ->from(Hobby::class, 'u')
            ->where('u.user = :userid')
            ->setParameter('userid', $userid)
            ->orderBy('u.id', 'DESC');


        return $queryBuilder->getQuery();
    }

}
