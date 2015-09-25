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
use Nelmio\ApiDocBundle\Annotation\ApiDoc;

class CategoryController extends FOSRestController
{
    /**
     * @View(serializerGroups={"list"})
     * @ApiDoc(
     *  resource=true,
     *  description="get all list of category"
     * )
     */
    public function getCategoriesAction()
    {

        $context = SerializationContext::create()->setGroups(array('list'));
        $cats = $this->getDoctrine()
            ->getRepository('MyspaceBookmarkBundle:Category')
            ->findAll();
        //->findById(22);
        foreach ($cats as &$cat) {
            $cat->setTotalbm(count($cat->getBookmarks()));
        }

        $view = $this->view($cats, 200)//->setFormat("json")
        ;
        $view->setSerializationContext($context);
        //return $this->handleView($view);
        return $view;
    }

    /**
     * @ApiDoc(
     *  resource=true,
     *  description="get category by Id"
     * )
     */
    public function getCategoryAction($id)
    {
        $cat = $this->getDoctrine()
            ->getRepository('MyspaceBookmarkBundle:Category')
            ->findOneById($id);
        $view = $this->view($cat, 200)//->setFormat("json")
        ;
        return $view;
    }
}