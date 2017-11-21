<?php
// src/NH/PlatformBundle/Repository/CategoryRepository.php
namespace NH\PlatformBundle\Repository;

use Doctrine\ORM\EntityRepository;

class CategoryRepository extends EntityRepository
{
    public function getLikeQueryBuilder($pattern)
    {
        return $this
            ->createQueryBuilder('c')
            ->where('c.name LIKE :pattern')
            ->setParameter('pattern', $pattern)
            ;
    }
}