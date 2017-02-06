<?php
/**
 * Created by PhpStorm.
 * User: hnguyenhuu
 * Date: 2/6/17
 * Time: 5:47 PM
 */

namespace Myspace\BookmarkBundle\Controller;


use FOS\RestBundle\Controller\Annotations\Route;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Yaml\Yaml;
use Symfony\Component\Finder\Finder;

class QuestionController extends Controller
{
    /**
     * @ApiDoc(description="get list questions of symfony and php")
     * @Route("/questions")
     */
    public function getQuestionsAction() {
        $vendor = $this->get('kernel')->getRootDir() . '/../vendor/';
        $finder = new Finder();
        $finder->name('*.yml')->sortByName();
        $questions = [];
        foreach ($finder->in($vendor . 'certificationy/symfony-pack/data/') as $file) {
            $questions[] = Yaml::parse(file_get_contents($file));
        }

        foreach ($finder->in($vendor . 'certificationy/php-pack/data/') as $file) {
            $questions[] = Yaml::parse(file_get_contents($file));
        }
        return $questions;
    }

}