<?php

namespace Scourgen\WebBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="StatistiquesRepository")
 * @ORM\Table(name="statistiques")
 */
class Statistiques{


    /**
     * @ORM\Id
     * @ORM\Column(type="string")
     */
    protected $id;

    /**
     * @ORM\Column(type="string")
     */
    protected $rechercheDate;

    /**
     * @ORM\Column(type="integer")
     */
    protected $rechercheNombre;


    /**
     * @ORM\Column(type="string")
     */
    protected $identifiant;

    /**
     * @ORM\Column(type="string")
     */
    protected $date;


    /**
     * Set rechercheDate
     *
     * @param string $rechercheDate
     * @return Statistiques
     */
    public function setRechercheDate($rechercheDate)
    {
        $this->rechercheDate = $rechercheDate;
    
        return $this;
    }

    /**
     * Get rechercheDate
     *
     * @return string 
     */
    public function getRechercheDate()
    {
        return $this->rechercheDate;
    }

    /**
     * Set rechercheNombre
     *
     * @param integer $rechercheNombre
     * @return Statistiques
     */
    public function setRechercheNombre($rechercheNombre)
    {
        $this->rechercheNombre = $rechercheNombre;
    
        return $this;
    }

    /**
     * Get rechercheNombre
     *
     * @return integer 
     */
    public function getRechercheNombre()
    {
        return $this->rechercheNombre;
    }

    /**
     * Set id
     *
     * @param string $id
     * @return Statistiques
     */
    public function setId($id)
    {
        $this->id = $id;
    
        return $this;
    }

    /**
     * Get id
     *
     * @return string 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set identifiant
     *
     * @param string $identifiant
     * @return Statistiques
     */
    public function setIdentifiant($identifiant)
    {
        $this->identifiant = $identifiant;
    
        return $this;
    }

    /**
     * Get identifiant
     *
     * @return string 
     */
    public function getIdentifiant()
    {
        return $this->identifiant;
    }

    /**
     * Set date
     *
     * @param string $date
     * @return Statistiques
     */
    public function setDate($date)
    {
        $this->date = $date;
    
        return $this;
    }

    /**
     * Get date
     *
     * @return string 
     */
    public function getDate()
    {
        return $this->date;
    }
}
