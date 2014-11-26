<?php
namespace Myspace\BookmarkBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Myspace\BookmarkBundle\Entity\Bookmark;
use Myspace\BookmarkBundle\Entity\Category;
use Myspace\BookmarkBundle\Entity\Tag;
use Myspace\BookmarkBundle\Entity\Comment;
use Myspace\BookmarkBundle\Entity\Contact;
use Symfony\Component\HttpFoundation\Request;

//use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use JMS\Serializer\SerializationContext;

class BookmarkController extends FOSRestController
{
    /**
     * @View(serializerGroups={"list"})
     */
    public function getBookmarksAction()
    {
        
		$context = SerializationContext::create()->setGroups(array('list'));
		$cats = $this->getDoctrine()
			->getRepository('MyspaceBookmarkBundle:Bookmark')
			->findAll();
			//->findById(22);
        $view = $this->view($cats, 200)
			//->setFormat("json")
        ;
		$view->setSerializationContext($context);
        //return $this->handleView($view);
		return $view;
    }
			
    public function getBookmarkAction($id)
    {        		
		$cat = $this->getDoctrine()
			->getRepository('MyspaceBookmarkBundle:Bookmark')
			->findOneById($id);
        $view = $this->view($cat, 200)
			//->setFormat("json")
        ;
		return $view;
    }	
}