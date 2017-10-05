<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\Article;
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
     * @var Article
     *
     * @ORM\ManyToOne(targetEntity="Article",cascade={"persist"})
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_article", referencedColumnName="id")
     * })
     */
    protected $articles;

    /**
     * @var Commande
     *
     * @ORM\ManyToOne(targetEntity="Commande",cascade={"persist"})
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_commande", referencedColumnName="id")
     * })
     */
    protected $commande;
    
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
    
    function __construct($commande,$quantite, Article $articles) {
        $this->quantite = $quantite;
        $this->articles = $articles;
        $this->commande=$commande;
    }
   
}
