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
		$form = $this->createFormBuilder($contact)
				//->add('subject','subject')
				//->add('email', 'email')
				//->add('name','name')
				//->add('description','description')
				//->add('title', 'title')
				->add('save', 'submit', array('label' => 'Create Post'))
				->getForm();
				
		// create a task and give it some dummy data for this example
		$task = new Contact();
		$task->setTask('Write a blog post');
		$task->setDueDate(new \DateTime('tomorrow'));
		$form = $this->createFormBuilder($task)
		->add('task', 'text')
		->add('dueDate', 'date')
		->add('save', 'submit', array('label' => 'Create Post'))
		->getForm();			
		return $this->render("MyspaceBookmarkBundle:Default:import.html.twig", array("form"=>$form->createView(),));
	}
}
