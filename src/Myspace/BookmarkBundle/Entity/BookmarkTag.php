<?php

namespace Myspace\BookmarkBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;


/**
 * BookmarkTag
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class BookmarkTag
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="Bookmark", inversedBy="bookmarktag")
     * @ORM\JoinColumn(name="bookmarkid", referencedColumnName="id")
     * */
    protected $bookmark;
    /**
     * @ORM\ManyToOne(targetEntity="Tag", inversedBy="bookmarktag")
     * @ORM\JoinColumn(name="tagid", referencedColumnName="id")
     * */
    protected $tag;
	
	public function getId()
	{
		return $this->id;
	}
	
	public function getTag()
	{
		return $this->tag;
	}
	
	public function getBookmark()
	{
		return $this->bookmark;
	}
}
