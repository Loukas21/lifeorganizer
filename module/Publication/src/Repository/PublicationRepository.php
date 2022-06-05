<?php
namespace Publication\Repository;

use Doctrine\ORM\EntityRepository;
use Publication\Entity\Publication;
use Laminas\Http\Exception\RuntimeException;

/**
 * This is the custom repository class for Quote entity.
 */
class PublicationRepository extends EntityRepository
{
    /**
     * Retrieves all publications in descending id order.
     * @return Query
     */
    public function findPublicationsByUser($userid,$types)
    {

        $entityManager = $this->getEntityManager();

        $queryBuilder = $entityManager->createQueryBuilder();

        $queryBuilder->select('u')
            ->from(Publication::class, 'u')
            ->where('u.user = :userid')
            ->setParameter('userid', $userid)
            //->andWhere($queryBuilder->expr()->in('u.type = :types'))
            //->setParameter('types', $types)
            ->orderBy('u.id', 'DESC');


        return $queryBuilder->getQuery();
    }

}
