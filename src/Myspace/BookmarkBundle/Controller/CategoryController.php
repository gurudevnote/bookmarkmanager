<?php
namespace Myspace\BookmarkBundle\Controller;

use FOS\RestBundle\Controller\Annotations\QueryParam;
use FOS\RestBundle\Request\ParamFetcher;
use Myspace\BookmarkBundle\Entity\Category;

use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Controller\FOSRestController;
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
     * @QueryParam(name="keyword", default="", nullable=true, strict=false, description="input keyword for searching category")
     */
    public function getCategoriesAction(ParamFetcher $fetcher)
    {
        $keyword = $fetcher->get('keyword');
        $context = SerializationContext::create()->setGroups(array('list'));
        $cats = $this->getDoctrine()
            ->getRepository('MyspaceBookmarkBundle:Category')
            ->searchCategoryByName($keyword);
        foreach ($cats as &$cat) {
            $cat->setTotalbm(count($cat->getBookmarks()));
        }

        $view = $this->view($cats, 200);
        $view->setSerializationContext($context);
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