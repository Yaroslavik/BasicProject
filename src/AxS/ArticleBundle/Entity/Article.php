<?php
/**
 * Created by PhpStorm.
 * User: alexsholk
 * Date: 13.11.15
 * Time: 16:05
 */

namespace AxS\ArticleBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;
use AxS\CommonBundle\Traits\UploadableTrait;
use AxS\CommonBundle\Interfaces\UploadableInterface;

/**
 * @ORM\Entity()
 * @ORM\Table(name="axs_article")
 * @ORM\HasLifecycleCallbacks()
 */
class Article implements UploadableInterface
{
    use UploadableTrait;

    const
        PREVIEW_LENGTH = 80,
        UPLOAD_DIR = '/uploads/article';


    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=50)
     * @Assert\NotBlank()
     */
    protected $title;

    /**
     * @ORM\Column(type="string", length=50)
     * @Gedmo\Slug(fields={"title"}, updatable=false, separator="-")
     * @Assert\Regex("/^[A-Za-z0-9-_]+$/")
     */
    protected $slug;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    protected $description;

    /**
     * @ORM\Column(type="text")
     */
    protected $content;

    /**
     * @ORM\Column(type="boolean")
     */
    protected $visible = true;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $metaTitle = '';

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    protected $metaDescription = '';

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    protected $metaKeywords = '';

    /**
     * @ORM\Column(type="datetime")
     * @Gedmo\Timestampable(on="create")
     */
    protected $createdAt;

    /**
     * @ORM\Column(type="datetime")
     * @Gedmo\Timestampable(on="update")
     */
    protected $updatedAt;

    /**
     * @ORM\ManyToOne(targetEntity="ArticleCategory", inversedBy="articles")
     * @ORM\JoinColumn(name="category_id", referencedColumnName="id")
     **/
    protected $category;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $filename;

    public function __toString()
    {
        return $this->getTitle() ? : 'Статья';
    }

    public function getFilenameField()
    {
        return 'filename';
    }

    public function getUploadDir()
    {
        return WEB_DIR . self::UPLOAD_DIR;
    }

    public function getPath()
    {
        if ($this->filename) {
            return $this->getUploadDir() . '/' . $this->filename;
        }
    }

    public function getWebPath()
    {
        if ($this->filename) {
            return self::UPLOAD_DIR . '/' . $this->filename;
        }
    }

    public function previewDescription()
    {
        $description = strip_tags(html_entity_decode($this->description));

        if (mb_strlen($description) > self::PREVIEW_LENGTH) {
            $description = mb_substr($description, 0, self::PREVIEW_LENGTH) . '...';
        }

        return $description;
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
     *
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
     * Set slug
     *
     * @param string $slug
     *
     * @return Article
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
     *
     * @return Article
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
     * Set content
     *
     * @param string $content
     *
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
     * Set visible
     *
     * @param boolean $visible
     *
     * @return Article
     */
    public function setVisible($visible)
    {
        $this->visible = $visible;

        return $this;
    }

    /**
     * Get visible
     *
     * @return boolean
     */
    public function getVisible()
    {
        return $this->visible;
    }

    /**
     * Set metaTitle
     *
     * @param string $metaTitle
     *
     * @return Article
     */
    public function setMetaTitle($metaTitle)
    {
        $this->metaTitle = $metaTitle;

        return $this;
    }

    /**
     * Get metaTitle
     *
     * @return string
     */
    public function getMetaTitle()
    {
        return $this->metaTitle;
    }

    /**
     * Set metaDescription
     *
     * @param string $metaDescription
     *
     * @return Article
     */
    public function setMetaDescription($metaDescription)
    {
        $this->metaDescription = $metaDescription;

        return $this;
    }

    /**
     * Get metaDescription
     *
     * @return string
     */
    public function getMetaDescription()
    {
        return $this->metaDescription;
    }

    /**
     * Set metaKeywords
     *
     * @param string $metaKeywords
     *
     * @return Article
     */
    public function setMetaKeywords($metaKeywords)
    {
        $this->metaKeywords = $metaKeywords;

        return $this;
    }

    /**
     * Get metaKeywords
     *
     * @return string
     */
    public function getMetaKeywords()
    {
        return $this->metaKeywords;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Article
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     *
     * @return Article
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Set category
     *
     * @param \AxS\ArticleBundle\Entity\ArticleCategory $category
     *
     * @return Article
     */
    public function setCategory(\AxS\ArticleBundle\Entity\ArticleCategory $category = null)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return \AxS\ArticleBundle\Entity\ArticleCategory
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Set filename
     *
     * @param string $filename
     *
     * @return Article
     */
    public function setFilename($filename)
    {
        $this->filename = $filename;

        return $this;
    }

    /**
     * Get filename
     *
     * @return string
     */
    public function getFilename()
    {
        return $this->filename;
    }
}
