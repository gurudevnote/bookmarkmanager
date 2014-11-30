<?php
// src\Myspace\BookmarkBundle\Entity\ImportFile.php
namespace Myspace\BookmarkBundle\Entity;

class ImportFile
{
	protected $file;
	
	public function getFile(){
		return $this->file;
	}

	public function setFile($file){
		$this->file = $file;
	}
}