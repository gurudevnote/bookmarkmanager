<?php

namespace Myspace\BookmarkBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use JMS\Serializer\Annotation\Groups;

/**
 * Category
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Myspace\BookmarkBundle\Repository\CategoryRepository")
 */
class Category
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
	 * @Groups({"list", "details"})
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
	 * @Groups({"list", "details"})
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="slug", type="string", length=255, nullable=true)
	 * @Groups({"list", "details"})
     */
    private $slug;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created", type="datetimetz", nullable=true)
	 * @Groups({"list", "details"})
     */
    private $created;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="last_modified", type="datetimetz", nullable=true)
     * @Groups({"list", "details"})
     */
    private $lastModified;
	
	/**
     * @ORM\OneToMany(targetEntity="Category", mappedBy="parent")
	 * @Groups({"details"})
     */
    protected $children;

    /**
	* @ORM\ManyToOne(targetEntity="Category", inversedBy="children")
	* @ORM\JoinColumn(name="parent_id", referencedColumnName="id", nullable=true)
	* @Groups({"details"})
	*/
    private $parent;
	
	/**
	* @ORM\OneToMany(targetEntity="Bookmark", mappedBy="category")
	* @Groups({"details"})
	*/
	private $bookmarks;
	
	/**
	* @Groups({"list"})
	*/
	private $totalbm;
	
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
	
	public function getTotalbm()
	{
		return $this->totalbm;
	}
	
	public function setTotalbm($total)
	{
		$this->totalbm = $total;
		return $this;
	}

    /**
     * @return mixed
     */
    public function getLastModified()
    {
        return $this->lastModified;
    }

    /**
     * @param mixed $lastModified
     */
    public function setLastModified($lastModified)
    {
        $this->lastModified = $lastModified;
    }
}
