<?php

namespace AppBundle\Entity\Product;

use Doctrine\ORM\Mapping as ORM;

/**
 * ImageProduct
 *
 * @ORM\Table(name="product_image_product")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\Product\ImageProductRepository")
 */
class ImageProduct {

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
     * @ORM\Column(name="ext", type="string", length=255)
     */
    private $ext;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=255)
     */
    private $type;

    /**
     * @ORM\ManyToOne(targetEntity="Product", inversedBy="imageProducts")
     */
    private $product;

    /*     * *************************************************************************************** */
    /*     * *************************************************************************************** */
    /*     * *************************************************************************************** */
    /*     * *************************************************************************************** */





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
     * Set ext
     *
     * @param string $ext
     *
     * @return ImageProduct
     */
    public function setExt($ext)
    {
        $this->ext = $ext;

        return $this;
    }

    /**
     * Get ext
     *
     * @return string
     */
    public function getExt()
    {
        return $this->ext;
    }

    /**
     * Set type
     *
     * @param string $type
     *
     * @return ImageProduct
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set product
     *
     * @param \AppBundle\Entity\Product\Product $product
     *
     * @return ImageProduct
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
