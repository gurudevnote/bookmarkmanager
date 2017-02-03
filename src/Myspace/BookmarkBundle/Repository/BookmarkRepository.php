<?php
/**
 * Created by PhpStorm.
 * User: hnguyenhuu
 * Date: 2/3/17
 * Time: 4:56 PM
 */

namespace Myspace\BookmarkBundle\Repository;


use Doctrine\ORM\EntityRepository;

class BookmarkRepository extends EntityRepository
{
    public function searchBookmarkByCategoryNameOrBookmarkInformation($keyword){
        $query = $this->createQueryBuilder('bookmark')
            ->join('bookmark.category', 'category')
            ->where('bookmark.title like :keyword')
            ->orWhere('bookmark.url like :keyword')
            ->orWhere('category.name like :keyword')
            ->setParameter('keyword', '%' . $keyword . '%')
            ->select('bookmark');
        return $query->getQuery()->getResult();
    }
}