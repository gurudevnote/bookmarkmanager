<?php

namespace Myspace\BookmarkBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Category
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Category
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
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="slug", type="string", length=255, nullable=true)
     */
    private $slug;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created", type="datetime", nullable=true)
     */
    private $created;
	
	/**
     * @ORM\OneToMany(targetEntity="Category", mappedBy="parent")
     */
    protected $children;

    /**
	* @ORM\ManyToOne(targetEntity="Category", inversedBy="children")
	* @ORM\JoinColumn(name="parent_id", referencedColumnName="id", nullable=true)
	*/
    private $parent;
	
	/**
	* @ORM\OneToMany(targetEntity="Bookmark", mappedBy="category")
	*/
	private $bookmarks;
	
	public function __construct()
	{
		$this->bookmarks = new ArrayCollection();
		$this->children = new ArrayCollection();
	}

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Category
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

	public function getParent()
	{
		return $this->parent;
	}
	
	public function getChildren() {
        return $this->children;
    }
	
	public function getBookmarks()
	{
		return $this->bookmarks;
	}
	
	// always use this to setup a new parent/child relationship
    public function addChild(Category $child) {
       $this->children[] = $child;
       $child->setParent($this);
    }
	
	public function setParent($parent)
	{
		$this->parent = $parent;
		return $this;
	}
	
    /**
     * Set slug
     *
     * @param string $slug
     * @return Category
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get slug
     *
     * @return string 
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     * @return Category
     */
    public function setCreated($created)
    {
        $this->created = $created;

        return $this;
    }

    /**
     * Get created
     *
     * @return \DateTime 
     */
    public function getCreated()
    {
        return $this->created;
    }
}
