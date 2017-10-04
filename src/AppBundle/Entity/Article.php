<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Description of Article
 *
 * @author rremond2017
 * @ORM\Table(name="articles")
 * @ORM\Entity
 */
 class Article {

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=255, nullable=false)
     */
    private $nom;

    /**
     * @var integer
     *
     * @ORM\Column(name="stock", type="integer", nullable=false)
     */
    private $stock;

    /**
     * @var integer
     *
     * @ORM\Column(name="poids", type="integer", nullable=false)
     */
    private $poids;

    function getId() {
        return $this->id;
    }

    function getNom() {
        return $this->nom;
    }

    function getStock() {
        return $this->stock;
    }

    function getPoids() {
        return $this->poids;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setNom($nom) {
        $this->nom = $nom;
    }

    function setStock($stock) {
        $this->stock = $stock;
    }

    function setPoids($poids) {
        $this->poids = $poids;
    }
    function __construct($nom=null, $stock=null, $poids=null) {
        $this->nom = $nom;
        $this->stock = $stock;
        $this->poids = $poids;
    }
}
