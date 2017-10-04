<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Description of CommandeLigne
 *
 * @author rremond2017
 * @ORM\Table(name="commandeLignes")
 * @ORM\Entity
 */
class CommandeLigne {

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $id;

    /**
     * @var integer
     *
     * @ORM\Column(name="quantite", type="integer", nullable=false)
     */
    protected $quantite;    
    
    /**
     * @var \Article
     *
     * @ORM\ManyToMany(targetEntity="Article")
     * @ORM\JoinTable(name="commande_line_has_article",
     *      joinColumns={@ORM\JoinColumn(name="commande_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="article_id", referencedColumnName="id")}
     * )
     */
    protected $articles;


    function getId() {
        return $this->id;
    }
    
    function getArticles() {
        return $this->articles;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setArticles($articles) {
        $this->articles = $articles;
    }
    function getQuantite() {
        return $this->quantite;
    }

    function setQuantite($quantite) {
        $this->quantite = $quantite;
    }
    
    function __construct($quantite, \Article $articles) {
        $this->quantite = $quantite;
        $this->articles = $articles;
    }
   
}
