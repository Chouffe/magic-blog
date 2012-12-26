<?php

namespace Chouffe\MagicBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Chouffe\MagicBundle\Entity\Album
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Chouffe\MagicBundle\Entity\AlbumRepository")
 */
class Album
{
    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string $title
     *
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
    * @ORM\OneToOne(targetEntity="Chouffe\MagicBundle\Entity\Photo", cascade={"persist"})
    * @ORM\JoinColumn(nullable=true)
    */
    private $cover;   

    /**
    * @ORM\OneToMany(targetEntity="Chouffe\MagicBundle\Entity\Photo", mappedBy="album")
    */
    private $photos;

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
     * Set title
     *
     * @param string $title
     * @return Album
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
     * Set cover
     *
     * @param \Chouffe\MagicBundle\Entity\Photo $cover
     * @return Album
     */
    public function setCover(\Chouffe\MagicBundle\Entity\Photo $cover = null)
    {
        $this->cover = $cover;
    
        return $this;
    }

    /**
     * Get cover
     *
     * @return \Chouffe\MagicBundle\Entity\Photo 
     */
    public function getCover()
    {
        return $this->cover;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->photos = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Add photos
     *
     * @param \Chouffe\MagicBundle\Entity\Photo $photos
     * @return Album
     */
    public function addPhoto(\Chouffe\MagicBundle\Entity\Photo $photos)
    {
        $this->photos[] = $photos;
        $photos->setAlbum($this);
        return $this;
    }

    /**
     * Remove photos
     *
     * @param \Chouffe\MagicBundle\Entity\Photo $photos
     */
    public function removePhoto(\Chouffe\MagicBundle\Entity\Photo $photos)
    {
        $this->photos->removeElement($photos);
    }

    /**
     * Get photos
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getPhotos()
    {
        return $this->photos;
    }
}
