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

    public function searchBookmarkByCategoryNameOrBookmarkInformationWithMultipleKeywords($keywords){
        $query = $this->createQueryBuilder('bookmark')
            ->join('bookmark.category', 'category')
            ->select('bookmark');
        if(count($keywords) > 0) {
            $params = [];
            $expressions = [];
            $index = 0;
            foreach ($keywords as $keyword) {
                $keywordLike = 'keyword' . $index;
                $orExpression = [];
                $orExpression[] = $this->likeTemplate('bookmark.title', $keywordLike);
                $orExpression[] = $this->likeTemplate('bookmark.url', $keywordLike);
                $orExpression[] = $this->likeTemplate('category.name', $keywordLike);
                $expressions[] = join(' OR ', $orExpression);
                $params[$keywordLike] = '%' . $keyword . "%";
                $index++;
            }
            $query->where($query->expr()->andX()->addMultiple($expressions));
            $query->setParameters($params);
        }

        return $query->getQuery()->getResult();
    }

    private function likeTemplate($field, $param){
        return sprintf('%s like :%s', $field, $param);
    }
}