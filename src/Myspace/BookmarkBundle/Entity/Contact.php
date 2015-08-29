<?php
// src\Myspace\BookmarkBundle\Entity\Document.php
namespace Myspace\BookmarkBundle\Entity;;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

class Contact
{
	protected $name;
	protected $email;
	protected $title;
	protected $file;
	protected $description;
	protected $subject;
	protected $task;
	protected $dueDate;
	
	public function getName(){
		return $this->name;
	}

	public function setName($name){
		$this->name = $name;
	}

	public function getEmail(){
		return $this->email;
	}

	public function setEmail($email){
		$this->email = $email;
	}

	public function getTitle(){
		return $this->title;
	}

	public function setTitle($title){
		$this->title = $title;
	}
	
	public function getFile(){
		return $this->file;
	}

	public function setFile($file){
		$this->file = $file;
	}

	public function getSubject(){
		return $this->subject;
	}

	public function setSubject($subject)
	{
		$this->subject = $subject;
	}
	
	public function getDescription(){
		return $this->description;
	}

	public function setDescription($description){
		$this->description = $description;
	}	

	public function getTask()
	{
		return $this->task;
	}
	
	public function setTask($task)
	{
		$this->task = $task;
	}
	
	public function getDueDate()
	{
		return $this->dueDate;
	}
	
	public function setDueDate(\DateTime $dueDate = null)
	{
		$this->dueDate = $dueDate;
	}
}