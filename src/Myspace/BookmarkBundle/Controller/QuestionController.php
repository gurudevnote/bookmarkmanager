<?php
/**
 * Created by PhpStorm.
 * User: hnguyenhuu
 * Date: 2/6/17
 * Time: 5:47 PM
 */

namespace Myspace\BookmarkBundle\Controller;


use FOS\RestBundle\Controller\FOSRestController;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Symfony\Component\Yaml\Yaml;
use Symfony\Component\Finder\Finder;

class QuestionController extends FOSRestController
{
    /**
     * @ApiDoc(description="get list questions of symfony and php")
     */
    public function getQuestionsAction() {
        $vendor = $this->get('kernel')->getRootDir() . '/../vendor/';
        $finder = new Finder();
        $finder->name('*.yml')->sortByName();
        $arrayDir = [
            $vendor . 'certificationy/symfony-pack/data/',
            $vendor . 'certificationy/php-pack/data/'
        ];
        $questions = [];
        foreach ($finder->in($arrayDir) as $file) {
            $questions[] = Yaml::parse(file_get_contents($file));
        }
        return $questions;
    }

}