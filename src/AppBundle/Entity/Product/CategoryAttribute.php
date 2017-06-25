<?php

namespace AppBundle\Entity\Product;

use Doctrine\ORM\Mapping as ORM;

/**
 * CategoryAttribute
 *
 * @ORM\Table(name="product_category_attribute")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\Product\CategoryAttributeRepository")
 */
class CategoryAttribute {

    /**
     * @var int
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
     * Many Attribute have One Category.
     * @ORM\ManyToOne(targetEntity="Category", inversedBy="attributes")
     */
    private $category;
    
    
       /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User")
     */
    private $user;
    public function __toString() {
        return $this->getName();
    }

    /*     * ************************************************************************** */
    /*     * ************************************************************************** */
    /*     * ************************************************************************** */
    /*     * ************************************************************************** */

   



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
     *
     * @return CategoryAttribute
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

    /**
     * Set category
     *
     * @param \AppBundle\Entity\Product\Category $category
     *
     * @return CategoryAttribute
     */
    public function setCategory(\AppBundle\Entity\Product\Category $category = null)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return \AppBundle\Entity\Product\Category
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Set user
     *
     * @param \AppBundle\Entity\User $user
     *
     * @return CategoryAttribute
     */
    public function setUser(\AppBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \AppBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }
}
