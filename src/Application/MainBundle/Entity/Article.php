<?php

namespace Application\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\Translatable\Translatable;

/**
 * Application\MainBundle\Entity\Article
 *
 * @ORM\Table(name="article")
 * @ORM\Entity(repositoryClass="Application\MainBundle\Entity\ArticleRepository")
 * @Gedmo\TranslationEntity(class="Application\MainBundle\Entity\ArticleTranslation")
 */
class Article implements Translatable
{
    use ORMBehaviors\Blameable\Blameable;
    use ORMBehaviors\Timestampable\Timestampable;
    use ORMBehaviors\SoftDeletable\SoftDeletable;
    
    /**
     * @Gedmo\Locale
     */
    private $locale;
    
    public function setTranslatableLocale($locale)
    {
        $this->locale = $locale;
    }
    
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(name="title", type="string", length=255)
     * @Gedmo\Translatable
     */
    private $title;

    /**
     * @ORM\Column(name="content", type="text")
     * @Gedmo\Translatable
     */
    private $content;

    /**
     * @ORM\ManyToMany(targetEntity="Author", mappedBy="articles", cascade={"persist"})
     */
    private $authors;

    /**
     * @ORM\OneToMany(targetEntity="ArticleTranslation", mappedBy="object", cascade={"persist"})
     */
    private $translations;
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->authors = new \Doctrine\Common\Collections\ArrayCollection();
        $this->translations = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set title
     *
     * @param string $title
     * @return Article
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
     * Set content
     *
     * @param string $content
     * @return Article
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content
     *
     * @return string 
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Add authors
     *
     * @param \Application\MainBundle\Entity\Author $authors
     * @return Article
     */
    public function addAuthor(\Application\MainBundle\Entity\Author $authors)
    {
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

    /**
     * Add translations
     *
     * @param \Application\MainBundle\Entity\ArticleTranslation $translations
     * @return Article
     */
    public function addTranslation(\Application\MainBundle\Entity\ArticleTranslation $translations)
    {
        $this->translations[] = $translations;

        return $this;
    }

    /**
     * Remove translations
     *
     * @param \Application\MainBundle\Entity\ArticleTranslation $translations
     */
    public function removeTranslation(\Application\MainBundle\Entity\ArticleTranslation $translations)
    {
        $this->translations->removeElement($translations);
    }

    /**
     * Get translations
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getTranslations()
    {
        return $this->translations;
    }
}
