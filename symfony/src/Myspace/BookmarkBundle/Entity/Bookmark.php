<?php

namespace Myspace\BookmarkBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;


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
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="url", type="string", length=300)
     */
    private $url;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=300)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="slug", type="string", length=300)
     */
    private $slug;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=500)
     */
    private $description;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created", type="datetime")
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
	* @ORM\ManyToOne(targetEntity="Category", inversedBy="bookmarks")
	* @ORM\JoinColumn(name="category_id", referencedColumnName="id")
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
