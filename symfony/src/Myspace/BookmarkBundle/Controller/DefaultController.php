<?php

namespace Myspace\BookmarkBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('MyspaceBookmarkBundle:Default:index.html.twig', array('name' => $name));
    }
}
