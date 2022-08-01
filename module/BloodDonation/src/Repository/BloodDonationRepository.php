<?php
namespace BloodDonation\Repository;

use Doctrine\ORM\EntityRepository;
use BloodDonation\Entity\BloodDonation;

/**
 * This is the custom repository class for Quote entity.
 */
class BloodDonationRepository extends EntityRepository
{
    /**
     * Retrieves all quotes in descending id order.
     * @return Query
     */
    public function findBloodDonationsByUser($userid)
    {

        $entityManager = $this->getEntityManager();

        $queryBuilder = $entityManager->createQueryBuilder();

        $queryBuilder->select('u')
            ->from(BloodDonation::class, 'u')
            ->where('u.user = :userid')
            ->setParameter('userid', $userid)
            ->orderBy('u.id', 'DESC');

        return $queryBuilder->getQuery();
    }

}
