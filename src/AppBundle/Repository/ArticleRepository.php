<?php

namespace AppBundle\Repository;

use AppBundle\Entity\Article;

/**
 * ArticleRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ArticleRepository extends AbstractRepository
{
    public function search($term = null, $order = 'asc', $limit = Article::LIMIT, $offset = 0)
    {
        $qb = $this->createQueryBuilder('a')
            ->select('a')
            ->orderBy('a.title', $order);

        if ($term) {
            $qb
                ->where('a.title LIKE ?1')
                ->setParameter('1', '%' . $term . '%');
        }

        return $this->paginate($qb, $limit, $offset);
    }
}