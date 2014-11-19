<?php

namespace Myspace\BookmarkBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Myspace\BookmarkBundle\Entity\Bookmark;
use Myspace\BookmarkBundle\Entity\Category;
use Myspace\BookmarkBundle\Entity\Tag;
use Myspace\BookmarkBundle\Entity\Comment;
use Myspace\BookmarkBundle\Entity\Contact;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        //test entity
		
		$catparent = $this->getDoctrine()
				->getRepository('MyspaceBookmarkBundle:Category')
				->find(1);
		
		//var_dump($catparent->getChildren());exit;
		foreach($catparent->getChildren() as $it)
		{
			echo $it->getName()."<br/>";
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
		
		//return $this->render('MyspaceBookmarkBundle:Default:index.html.twig', array('name' => $name));
    }
	
	public function importAction(Request $request)
	{
		$contact = new Contact();
		$contact->setEmail("huuhuy@gmail.com");
		$contact->setName("Contact form");
		$contact->setTask('Write a blog post');
		$contact->setDueDate(new \DateTime('tomorrow'));
		$contact->setDescription('simple form description');
		$form = $this->createFormBuilder($contact)
				->add('subject','text')
				->add('email', 'email')
				->add('name','text')
				->add('description','textarea')
				->add('title', 'text')
				->add('task', 'text')
				->add('file','file')
				->add('dueDate', 'date')
				->add('save', 'submit', array('label' => 'Create Post'))
				->getForm();			
		return $this->render("MyspaceBookmarkBundle:Default:import.html.twig", array("form"=>$form->createView(),));
		
	}
}
