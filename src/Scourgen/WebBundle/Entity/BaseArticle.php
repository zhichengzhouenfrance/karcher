<?php

namespace Scourgen\WebBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="BaseArrticleRepository")
 * @ORM\Table(name="base_article",indexes={@ORM\Index(name="reference_idx", columns={"reference"})})
 */
class BaseArticle{

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;


    /**
     * @ORM\Column(type="string")
     */
    protected $reference;

    /**
     * @ORM\Column(type="string")
     */
    protected $libelle;


    /**
     * @ORM\Column(type="decimal", scale=2)
     */
    protected $puht;




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
     * Set reference
     *
     * @param string $reference
     * @return BaseArticle
     */
    public function setReference($reference)
    {
        $this->reference = $reference;

        return $this;
    }

    /**
     * Get reference
     *
     * @return string 
     */
    public function getReference()
    {
        return $this->reference;
    }

    /**
     * Set libelle
     *
     * @param string $libelle
     * @return BaseArticle
     */
    public function setLibelle($libelle)
    {
        $this->libelle = $libelle;

        return $this;
    }

    /**
     * Get libelle
     *
     * @return string 
     */
    public function getLibelle()
    {
        return $this->libelle;
    }

    /**
     * Set puht
     *
     * @param string $puht
     * @return BaseArticle
     */
    public function setPuht($puht)
    {
        $this->puht = $puht;

        return $this;
    }

    /**
     * Get puht
     *
     * @return string 
     */
    public function getPuht()
    {
        return $this->puht;
    }
}
