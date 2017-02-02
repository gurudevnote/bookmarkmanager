<?php
namespace Myspace\BookmarkBundle\Repository;
use Doctrine\ORM\EntityRepository;
/**
 * Created by PhpStorm.
 * User: hnguyenhuu
 * Date: 2/2/17
 * Time: 6:08 PM
 */
class CategoryRepository extends EntityRepository
{
    public function searchCategoryByName($categoryName){
        $query = $this->createQueryBuilder('category')
            ->where('category.name like :categoryName')
            ->setParameter('categoryName',  '%'. $categoryName .'%');
        return $query->getQuery()->getResult();
    }
}