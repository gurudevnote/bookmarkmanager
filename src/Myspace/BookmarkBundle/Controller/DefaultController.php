<?php
namespace Myspace\BookmarkBundle\Controller;
use Doctrine\DBAL\Connection;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Myspace\BookmarkBundle\Entity\Bookmark;
use Myspace\BookmarkBundle\Entity\Category;
use Myspace\BookmarkBundle\Entity\ImportFile;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class DefaultController extends Controller
{
    public function angularjsAction()
    {
        return $this->render('MyspaceBookmarkBundle:Default:angular.html.twig', array());
    }

    public function iconAction()
    {
        return $this->render('MyspaceBookmarkBundle:Default:icon.html.twig', array());
    }

    /**
     * @Route("/tag/{tagid}", name="tag_detail")
     */
    public function tagAction($tagid)
    {
        $tag = $this->getDoctrine()
            ->getRepository('MyspaceBookmarkBundle:Tag')
            ->findOneById($tagid);
        return $this->render('MyspaceBookmarkBundle:Default:tag.html.twig', array('tag' => $tag));
    }

    /**
     * @Route("/bookmark/{bookmarkid}", name="bookmark_detail")
     */
    public function bookmarkAction($bookmarkid)
    {
        $bookmark = $this->getDoctrine()
            ->getRepository('MyspaceBookmarkBundle:Bookmark')
            ->findOneById($bookmarkid);
        return $this->render('MyspaceBookmarkBundle:Default:bookmark.html.twig', array('bookmark' => $bookmark));
    }

    /**
     * @Route("/category/{catid}", name="category_detail")
     */
    public function categoryAction($catid)
    {
        $bookmarks = $this->getDoctrine()
            ->getRepository('MyspaceBookmarkBundle:Bookmark')
            ->findByCategory($catid);
        return $this->render('MyspaceBookmarkBundle:Default:bookmarksbbycategory.html.twig', array('bookmarks' => $bookmarks));
    }

    /**
     * @Route("/", name="index")
     */
    public function indexAction()
    {
        $cats = $this->getDoctrine()
            ->getRepository('MyspaceBookmarkBundle:Category')
            ->findAll();
        $tags = $this->getDoctrine()
            ->getRepository('MyspaceBookmarkBundle:Tag')
            ->findAll();
        $array = array($cats, $tags);

        return $this->render('MyspaceBookmarkBundle:Default:index.html.twig', array('array' => $array));
    }

    /**
     * @Route("/import", name="import_data")
     */
    public function importAction(Request $request)
    {
        set_time_limit(0);
        $importFile = new ImportFile();

        $form = $this->createFormBuilder($importFile)
            ->add('file', 'file')
            ->add('save', 'submit', array('label' => 'Import'))
            ->getForm();
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            // perform some action, such as saving the task to the database
            $filePath = $importFile->getFile();

            //truncat all table:
            /** @var EntityManager $entityManager */
            $entityManager = $this->getDoctrine()->getManager();
            /** @var Connection $connection */
            $connection = $entityManager->getConnection();
            $schemaManager = $connection->getSchemaManager();
            $tables = $schemaManager->listTables();
            $query = '';
            $connection->query('SET FOREIGN_KEY_CHECKS=0');
            foreach ($tables as $table) {
                $name = $table->getName();
                $query .= 'TRUNCATE ' . $name . ';';
            }
            $connection->executeQuery($query, array(), array());
            $connection->query('SET FOREIGN_KEY_CHECKS=1');

            $fileContent = file_get_contents($filePath);
            $array = explode("\n", $fileContent);
            $newarr = array();
            foreach ($array as $line) {
                if (strpos($line, "<H3 ADD_DATE") !== false || strpos($line, "<DT><A HREF=") !== false) {
                    $newarr[] = $line;
                }
            }

            $currentCategory = null;
            $parentcatID = 0;
            $currentcatID = 0;
            $level = 0;
            $text = "/>([^<]+)</";
            $addDate = "/ADD_DATE=\"(\\d+)\"/";
            $lastModify = "/LAST_MODIFIED=\"(\\d+)\"/";
            $herf = "/HREF=\"([^\"]+)\"/";
            $icon = "/ICON=\"([^\"]+)\"/";
            $flushItemCount = 0;
            foreach ($newarr as $line) {
                $flushItemCount++;
                if (strpos($line, "<H3 ADD_DATE") !== false) {
                    //folder

                    preg_match($text, $line, $texts);
                    preg_match($addDate, $line, $addDates);
                    preg_match($lastModify, $line, $lastModifies);
                    echo $texts[1] . "<br/>";

                    $category = new Category();
                    $category->setName($texts[1]);
                    $category->setCreated($this->getDateTimeFromTimestamp($addDates[1]));
                    $category->setLastModified($this->getDateTimeFromTimestamp($lastModifies[1]));
                    $em->persist($category);

                    $currentCategory = $category;
                } else if (strpos($line, "<DT><A HREF=") !== false) {
                    //continue;
                    preg_match($text, $line, $texts);
                    preg_match($herf, $line, $hrefs);
                    preg_match($icon, $line, $icons);
                    preg_match($addDate, $line, $addDates);

                    echo $hrefs[1] . "<br/>";
                    $bookmark = new Bookmark();
                    $bookmark->setUrl($hrefs[1]);
                    if (count($texts) > 0) {
                        $bookmark->setTitle($texts[1]);
                    }

                    if (count($icons) > 0) {
                        $bookmark->setIcon($icons[1]);
                    }

                    if(count($addDates) > 0) {
                        $date = $this->getDateTimeFromTimestamp($addDates[1]);
                        $bookmark->setCreated($date);
                    }
                    $bookmark->setCategory($currentCategory);                    
                    $em->persist($bookmark);                    
                }
                
                if($flushItemCount % 100 == 0)
                {
                    $em->flush();
                }                               
            }
            
            $em->flush();

            return $this->redirect($this->generateUrl('index'));
        } else {
            return $this->render("MyspaceBookmarkBundle:Default:import.html.twig", array("form" => $form->createView(),));
        }

    }

    /**
     * @param $ts
     * @return \DateTime
     */
    private function getDateTimeFromTimestamp($ts)
    {
        $date = new \DateTime("@$ts");
        return $date;
    }
}
