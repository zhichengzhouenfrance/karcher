<?php

namespace Scourgen\WebBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="BaseArticleRepository")
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
    protected $reference_format;

    /**
     * @ORM\Column(type="string")
     */
    protected $hierarchie;

    /**
     * @ORM\Column(type="string")
     */
    protected $validite;


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

    /**
     * Set reference_format
     *
     * @param string $referenceFormat
     * @return BaseArticle
     */
    public function setReferenceFormat($referenceFormat)
    {
        $this->reference_format = $referenceFormat;

        return $this;
    }

    /**
     * Get reference_format
     *
     * @return string 
     */
    public function getReferenceFormat()
    {
        return $this->reference_format;
    }

    /**
     * Set hierarchie
     *
     * @param string $hierarchie
     * @return BaseArticle
     */
    public function setHierarchie($hierarchie)
    {
        $this->hierarchie = $hierarchie;

        return $this;
    }

    /**
     * Get hierarchie
     *
     * @return string 
     */
    public function getHierarchie()
    {
        return $this->hierarchie;
    }

    /**
     * Set validite
     *
     * @param string $validite
     * @return BaseArticle
     */
    public function setValidite($validite)
    {
        $this->validite = $validite;

        return $this;
    }

    /**
     * Get validite
     *
     * @return string 
     */
    public function getValidite()
    {
        return $this->validite;
    }
}
