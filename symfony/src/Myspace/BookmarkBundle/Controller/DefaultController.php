<?php

namespace Myspace\BookmarkBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Myspace\BookmarkBundle\Entity\Bookmark;
use Myspace\BookmarkBundle\Entity\Category;
use Myspace\BookmarkBundle\Entity\Tag;
use Myspace\BookmarkBundle\Entity\Comment;
use Myspace\BookmarkBundle\Entity\ImportFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\DomCrawler\Crawler;

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
	
	public function tagAction($tagid)
	{
		$tag = $this->getDoctrine()
				->getRepository('MyspaceBookmarkBundle:Tag')
				->findOneById($tagid);
		//var_dump($tag);exit;
		return $this->render('MyspaceBookmarkBundle:Default:tag.html.twig', array('tag' => $tag));
	}
	
	public function bookmarkAction($bookmarkid)
	{
		$bookmark = $this->getDoctrine()
				->getRepository('MyspaceBookmarkBundle:Bookmark')
				->findOneById($bookmarkid);
		//var_dump($bookmark[0]->getTags());exit;
		return $this->render('MyspaceBookmarkBundle:Default:bookmark.html.twig', array('bookmark' => $bookmark));
	}
	
	public function categoryAction($catid)
	{
		$bookmarks = $this->getDoctrine()
				->getRepository('MyspaceBookmarkBundle:Bookmark')
				->findByCategory($catid);
		return $this->render('MyspaceBookmarkBundle:Default:bookmarksbbycategory.html.twig', array('bookmarks' => $bookmarks));
	}
	
	public function indexAction()
    {
        //test entity
		
		$cats = $this->getDoctrine()
				->getRepository('MyspaceBookmarkBundle:Category')
				->findAll();
		$tags = $this->getDoctrine()
				->getRepository('MyspaceBookmarkBundle:Tag')
				->findAll();
		$array = array($cats, $tags);
		/*
		//var_dump($catparent->getChildren());exit;
		if($catparent!=null)
		{
			foreach($catparent->getChildren() as $it)
			{
				echo $it->getName()."<br/>";
			}
		}
		exit;
		
		$category = new Category();
		$category->setName("course");
		$category->setParent($catparent);
		$em = $this->getDoctrine()->getManager();
		$em->persist($category);
		//$em->persist($product);
		$em->flush();		
		
		$catparent1 = $this->getDoctrine()
				->getRepository('MyspaceBookmarkBundle:Category')
				->find(2);
		//var_dump($catparent1);exit;
		
		//
		*/
		
		//return $this->render('MyspaceBookmarkBundle:Default:index.html.twig', array('array' => $array));
		//$json = $this->encodeUserDataToJson($cats);
		//$array = json_encode($array);
		//return $this->render('MyspaceBookmarkBundle:Default:index.json.twig', array('array' => $json));
		
		//$serializer = $this->container->get('serializer');
		//$reports = $serializer->serialize($array, 'json');
		//return new Response($reports); // should be $reports as $doctrineobject is not serialized
		
		return $this->render('MyspaceBookmarkBundle:Default:index.html.twig', array('array' => $array));
    }
	
	public function importAction(Request $request)
	{
		set_time_limit(0);
		$importFile = new ImportFile();

		$form = $this->createFormBuilder($importFile)
				->add('file','file')
				->add('save', 'submit', array('label' => 'Import'))
				->getForm();
		$form->handleRequest($request);
		
		
		//$logger = $this->get('logger');
		//$logger->info('I just got the logger');
		//$logger->error('An error occurred');
		
		/*/
		ob_start();
		var_dump($request);
		$result = ob_get_clean();
		$logger->error($result);
		$logger->error(json_encode($request));
		//var_dump($request);die;
		/**/
		
		if ($form->isValid()) {
			// perform some action, such as saving the task to the database
			$filePath =  $importFile->getFile();
			
			//truncat all table:
			$entityManager = $this->getDoctrine()->getManager();
			$connection = $entityManager->getConnection();
			$schemaManager = $connection->getSchemaManager();
			$tables = $schemaManager->listTables();
			$query = '';
			$connection->query('SET FOREIGN_KEY_CHECKS=0');
			foreach($tables as $table) {
				$name = $table->getName();
				$query .= 'TRUNCATE ' . $name . ';';
			}
			$connection->executeQuery($query, array(), array());
			$connection->query('SET FOREIGN_KEY_CHECKS=1');
			
			//process file and store to database
			//$uploadFile = new UploadedFile($filePath,"chromebookmark.html");
			//var_dump($uploadFile);exit;
			//echo $filePath;
			$fileContent = file_get_contents($filePath);
			//echo $fileContent;
			$array = explode("\n", $fileContent);
			$newarr = array();
			foreach($array as $line)
			{
				if(strpos($line,"<H3 ADD_DATE")!==false || strpos($line,"<DT><A HREF=") !==false)
				{
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
			$herf = "/HREF=\"([^\"]+)\"/"; ;
			$icon = "/ICON=\"([^\"]+)\"/"; 
			foreach($newarr as $line)
			{
				if(strpos($line,"<H3 ADD_DATE") !==false)
				{
					//folder					
					
					preg_match($text, $line, $texts);
					preg_match($addDate, $line, $addDates);
					preg_match($lastModify, $line, $lastModifies);
					echo $texts[1]."<br/>";//."  {$addDate[1]}  {$lastModifies[1]} <br/>";
					
					$category = new Category();
					$category->setName($texts[1]);
					$em = $this->getDoctrine()->getManager();
					$em->persist($category);
					$em->flush();
					$currentcatID = $category->getId();
					$currentCategory = $category;
				}
				else if(strpos($line,"<DT><A HREF=") !==false)
				{
					//continue;
					preg_match($text, $line, $texts);
					preg_match($herf, $line, $hrefs);
					preg_match($icon, $line, $icons);
					preg_match($addDate, $line, $addDates);
					
					//echo $texts[1]." {$hrefs[1]} {$icons[1]} {$addDates[1]}<br/>";
					//var_dump($icons);
					echo $hrefs[1]."<br/>";
					$bookmark = new Bookmark();
					$bookmark->setUrl($hrefs[1]);
					if(count($texts) > 0)
					{
						$bookmark->setTitle($texts[1]);
					}
					
					if(count($icons) > 0)
					{
						$bookmark->setIcon($icons[1]);
					}
					$bookmark->setCategory($currentCategory);
					$em = $this->getDoctrine()->getManager();
					$em->persist($bookmark);
					$em->flush();
				}
			}

			//exit;
			//echo $fileContent;exit;
			
			return $this->redirect($this->generateUrl('myspace_bookmark_homepage'));
		}
		else
		{
			return $this->render("MyspaceBookmarkBundle:Default:import.html.twig", array("form"=>$form->createView(),));
		}
		
	}
}
