<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Description of Commande
 *
 * @author rremond2017
 * @ORM\Table(name="commandes")
 * @ORM\Entity
 */
class Commande {

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="numero", type="string", length=255, nullable=false)
     */
    protected $numero;
    
    /**
     * @var date
     *
     * @ORM\Column(name="dateDeCommande", type="datetime", nullable=false)
     */
    protected $dateDeCommande;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateExpedition", type="datetime")
     */
    protected $dateExpedition;

    /**
     * @var \Client
     *
     * @ORM\ManyToOne(targetEntity="Client")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_client", referencedColumnName="id")
     * })
     */
    protected $client;

    /**
     * @var Collection
     *
     * @ORM\OneToMany(targetEntity="CommandeLigne", mappedBy="group")
     * )
     */
    protected $commandeLignes;

        /**
     * @var \Employe
     *
     * @ORM\OneToOne(targetEntity="Employe")
     * )
     */
    protected $employe;

    /**
     * @var string
     *
     * @ORM\Column(name="statut", type="string", length=255, nullable=false)
     */
    protected $statut;

    function getId() {
        return $this->id;
    }
    function getNumero() {
        return $this->numero;
    }

    function setNumero($numero) {
        $this->numero = $numero;
    }
        
    function getDateDeCommande() {
        return $this->dateDeCommande;
    }

    function getDateExpedition() {
        return $this->dateExpedition;
    }

    function getClient() {
        return $this->client;
    }

    function getArticles() {
        return $this->articles;
    }

    function getEmploye() {
        return $this->employe;
    }

    function getStatut() {
        return $this->statut;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setDateDeCommande($dateDeCommande) {
        $this->dateDeCommande = $dateDeCommande;
    }

    function setDateExpedition($dateExpedition) {
        $this->dateExpedition = $dateExpedition;
    }

    function setClient(\Client $client) {
        $this->client = $client;
    }

    function setArticles($articles) {
        $this->articles = $articles;
    }

    function setEmploye($employe) {
        $this->employe = $employe;
    }

    function setStatut($statut) {
        $this->statut = $statut;
    }
    function __construct($numero, date $dateDeCommande, $client, $articles, $statut) {
        $this->numero = $numero;
        $this->dateDeCommande = $dateDeCommande;
        $this->client = $client;
        $this->articles = $articles;
        $this->statut = $statut;
    }

}
