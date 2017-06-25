<?php

namespace AppBundle\Entity\Product;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

//use \Symfony\Component\Security\Core\Validator\Constraints as Assert;

/**
 * Product
 *
 * @ORM\Table(name="product")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\Product\ProductRepository")
 */
class Product {

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
     * 
     * @Assert\NotBlank
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="sku", type="string", length=32, unique=true)
     * 
     * @Assert\NotBlank
     */
    private $sku;

    /**
     * @var int
     *
     * @ORM\Column(name="price", type="integer")
     * 
     * @Assert\NotBlank
     * 
     */
    private $price;

    /**
     * @var int
     *
     * @ORM\Column(name="quantity", type="integer")
     * 
     * @Assert\NotBlank
     */
    private $quantity;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\ManyToOne(targetEntity="Category", inversedBy="products")
     */
    private $category;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User")
     */
    private $user;

    /**
     * @ORM\OneToMany(targetEntity="ImageProduct",mappedBy="product")
     */
    private $imageProducts;

    public function __toString() {
        return $this->getName() . " " . $this->getPrice() . " " . $this->getQuantity() . " " . $this->getId() . " " . $this->getImageProducts();
    }

    /*     * *************************************************************************************** */
    /*     * *************************************************************************************** */
    /*     * *************************************************************************************** */
    /*     * *************************************************************************************** */

  
    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->imageProducts = new \Doctrine\Common\Collections\ArrayCollection();
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
     *
     * @return Product
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
     * Set sku
     *
     * @param string $sku
     *
     * @return Product
     */
    public function setSku($sku)
    {
        $this->sku = $sku;

        return $this;
    }

    /**
     * Get sku
     *
     * @return string
     */
    public function getSku()
    {
        return $this->sku;
    }

    /**
     * Set price
     *
     * @param integer $price
     *
     * @return Product
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return integer
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set quantity
     *
     * @param integer $quantity
     *
     * @return Product
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;

        return $this;
    }

    /**
     * Get quantity
     *
     * @return integer
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Product
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
     * Set category
     *
     * @param \AppBundle\Entity\Product\Category $category
     *
     * @return Product
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
     * @return Product
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

    /**
     * Add imageProduct
     *
     * @param \AppBundle\Entity\Product\ImageProduct $imageProduct
     *
     * @return Product
     */
    public function addImageProduct(\AppBundle\Entity\Product\ImageProduct $imageProduct)
    {
        $this->imageProducts[] = $imageProduct;

        return $this;
    }

    /**
     * Remove imageProduct
     *
     * @param \AppBundle\Entity\Product\ImageProduct $imageProduct
     */
    public function removeImageProduct(\AppBundle\Entity\Product\ImageProduct $imageProduct)
    {
        $this->imageProducts->removeElement($imageProduct);
    }

    /**
     * Get imageProducts
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getImageProducts()
    {
        return $this->imageProducts;
    }
}
