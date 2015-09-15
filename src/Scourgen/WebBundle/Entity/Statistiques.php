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
    protected $rechercheDate;

    /**
     * @ORM\Column(type="integer")
     */
    protected $rechercheNombre;



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
}
