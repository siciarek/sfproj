<?php

namespace Application\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Application\MainBundle\Entity\Article
 *
 * @ORM\Entity
 * @ORM\Table(name="article")
 * @ORM\Entity(repositoryClass="Application\MainBundle\Entity\ArticleRepository")
 */
class Article {

    use ORMBehaviors\Translatable\Translatable;

use ORMBehaviors\Blameable\Blameable;

use ORMBehaviors\Timestampable\Timestampable;

use ORMBehaviors\SoftDeletable\SoftDeletable;

    public function __toString() {
        return $this->getTitle()? : '-';
    }

    public function getTitle() {
        return $this->translate()->getTitle();
    }

    public function getContent() {
        return $this->translate()->getContent();
    }

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToMany(targetEntity="Author", mappedBy="articles", cascade={"persist"})
     */
    private $authors;

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Constructor
     */
    public function __construct() {
        $this->authors = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add authors
     *
     * @param \Application\MainBundle\Entity\Author $authors
     * @return Article
     */
    public function addAuthor(\Application\MainBundle\Entity\Author $authors) {
        $authors->addArticle($this);
        $this->authors[] = $authors;

        return $this;
    }

    /**
     * Remove authors
     *
     * @param \Application\MainBundle\Entity\Author $authors
     */
    public function removeAuthor(\Application\MainBundle\Entity\Author $authors) {
        $authors->removeArticle($this);
        $this->authors->removeElement($authors);
    }

    /**
     * Get authors
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getAuthors() {
        return $this->authors;
    }

}
