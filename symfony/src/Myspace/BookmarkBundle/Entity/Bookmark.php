<?php

namespace Myspace\BookmarkBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use JMS\Serializer\Annotation\Groups;

/**
 * Bookmark
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Bookmark
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
	 * @Groups({"list"})
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="url", type="string", length=300)
	 * @Groups({"list"})
     */
    private $url;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=300,nullable=true)
	 * @Groups({"list"})
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="slug", type="string", length=300,nullable=true)
	 * @Groups({"list"})
     */
    private $slug;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=500,nullable=true)
	 * @Groups({"list"})
     */
    private $description;
	
	/**
     * @var string
     * @Groups({"list"})
     * @ORM\Column(name="icon", type="string", length=500,nullable=true)
     */
    private $icon;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created", type="datetime",nullable=true)
	 * @Groups({"list"})
     */
    private $created;
	
    /**
	 * @ORM\ManyToMany(targetEntity="Tag", inversedBy="bookmarks")
     * @ORM\JoinTable(
	 *		name="bookmark_tag",
	 *		joinColumns={@ORM\JoinColumn(name="bookmark_id",referencedColumnName="id")},
	 *		inverseJoinColumns={@ORM\JoinColumn(name="tag_id", referencedColumnName="id")}
	 * )
     */
    private $tags;
	
	/**	
     * @ORM\OneToMany(targetEntity="BookmarkTag" , mappedBy="bookmark" , cascade={"all"} , orphanRemoval=true)
     * */
    protected $bookmarktags;
	
	public function getBookmarktags()
	{
		return $this->bookmarktags;
	}

	/**
	* @ORM\ManyToOne(targetEntity="Category", inversedBy="bookmarks")
	* @ORM\JoinColumn(name="catid", referencedColumnName="id")
	*/
	protected $category;

	/**
	* @ORM\OneToMany(targetEntity="Comment", mappedBy="bookmark")
	*/
	private $comments;
	
	public function __construct()
	{
		$this->comments = new ArrayCollection();
		$this->tags = new ArrayCollection();
	}
	
	
	public function getTags()
	{
		return $this->tags;
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
     * Set url
     *
     * @param string $url
     * @return Bookmark
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get url
     *
     * @return string 
     */
    public function getUrl()
    {
        return $this->url;
    }
	
	/**
     * Set category
     *
     * @param string $category
     * @return Bookmark
     */
    public function setCategory($category)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return Category 
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Set title
     *
     * @param string $title
     * @return Bookmark
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }
	
	/**
     * Set icon
     *
     * @param string $icon
     * @return Bookmark
     */
    public function setIcon($icon)
    {
        $this->icon = $icon;

        return $this;
    }

    /**
     * Get icon
     *
     * @return string 
     */
    public function getIcon()
    {
        return $this->icon;
    }

    /**
     * Set slug
     *
     * @param string $slug
     * @return Bookmark
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
     * Set description
     *
     * @param string $description
     * @return Bookmark
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     * @return Bookmark
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
