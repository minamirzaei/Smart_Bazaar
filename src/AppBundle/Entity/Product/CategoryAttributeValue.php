<?php

namespace AppBundle\Entity\Product;

use Doctrine\ORM\Mapping as ORM;

/**
 * CategoryAttributeValue
 *
 * @ORM\Table(name="product_category_attribute_value")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\Product\CategoryAttributeValueRepository")
 */
class CategoryAttributeValue {

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
     * Many attribute have One Category.
     * @ORM\ManyToOne(targetEntity="CategoryAttribute")
     */
    private $attribute;

    /**
     * Many attribute have One Product.
     * @ORM\ManyToOne(targetEntity="Product")
     */
    private $product;

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
     * @return CategoryAttributeValue
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
     * Set attribute
     *
     * @param \AppBundle\Entity\Product\CategoryAttribute $attribute
     *
     * @return CategoryAttributeValue
     */
    public function setAttribute(\AppBundle\Entity\Product\CategoryAttribute $attribute = null)
    {
        $this->attribute = $attribute;

        return $this;
    }

    /**
     * Get attribute
     *
     * @return \AppBundle\Entity\Product\CategoryAttribute
     */
    public function getAttribute()
    {
        return $this->attribute;
    }

    /**
     * Set product
     *
     * @param \AppBundle\Entity\Product\Product $product
     *
     * @return CategoryAttributeValue
     */
    public function setProduct(\AppBundle\Entity\Product\Product $product = null)
    {
        $this->product = $product;

        return $this;
    }

    /**
     * Get product
     *
     * @return \AppBundle\Entity\Product\Product
     */
    public function getProduct()
    {
        return $this->product;
    }
}
