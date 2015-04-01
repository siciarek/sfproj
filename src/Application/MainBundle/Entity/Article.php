<?php

namespace Application\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;

/**
 * Article
 */
class Article
{
    use ORMBehaviors\Blameable\Blameable;
    use ORMBehaviors\Timestampable\Timestampable;
    use ORMBehaviors\SoftDeletable\SoftDeletable;
    use ORMBehaviors\Translatable\Translatable;

    public function __toString() {
         return strval($this->id ? : '-');
    }
    /**
     * @var integer
     */
    private $id;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $authors;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->authors = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Add authors
     *
     * @param \Application\MainBundle\Entity\Author $authors
     * @return Article
     */
    public function addAuthor(\Application\MainBundle\Entity\Author $authors)
    {
        $authors->addArticle($this);
        $this->authors[] = $authors;

        return $this;
    }

    /**
     * Remove authors
     *
     * @param \Application\MainBundle\Entity\Author $authors
     */
    public function removeAuthor(\Application\MainBundle\Entity\Author $authors)
    {
        $authors->removeArticle($this);
        $this->authors->removeElement($authors);
    }

    /**
     * Get authors
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getAuthors()
    {
        return $this->authors;
    }
}
