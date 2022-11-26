<?php
namespace Authority\Repository;

use Doctrine\ORM\EntityRepository;
use Authority\Entity\Authority;

/**
 * This is the custom repository class for Authority entity.
 */
class AuthorityRepository extends EntityRepository
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
            ->from(Authority::class, 'u')
            ->where('u.user = :userid')
            ->setParameter('userid', $userid)
            ->orderBy('u.id', 'DESC');


        return $queryBuilder->getQuery();
    }

}
