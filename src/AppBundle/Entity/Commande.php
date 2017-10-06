<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\Client;
use AppBundle\Entity\CommandeLigne;
use AppBundle\Entity\Employe;
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
     * @var \DateTime
     *
     * @ORM\Column(name="dateDeCommande", type="datetime", nullable=false)
     */
    protected $dateDeCommande;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateExpedition", type="datetime",nullable=true)
     */
    protected $dateExpedition;

    /**
     * @var Client
     *
     * @ORM\ManyToOne(targetEntity="Client",cascade={"persist"})
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_client", referencedColumnName="id")
     * })
     */
    protected $client;

    /**
     * @var \CommandeLigne
     *
     * @ORM\OneToMany(targetEntity="CommandeLigne", mappedBy="commande")
     */
    protected $commandeLignes;
    
 

        /**
     * @var Employe
     *
     * @ORM\ManyToOne(targetEntity="Employe",cascade={"persist"})
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_employe", referencedColumnName="id")
     * })
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

    function getEmploye() {
        return $this->employe;
    }

    function getStatut() {
        return $this->statut;
    }

    function setId($id) {
        $this->id = $id;
    }
    
    function getCommandeLignes() {
        return $this->commandeLignes;
    }

    function setCommandeLignes($commandeLignes) {
        $this->commandeLignes = $commandeLignes;
    }
        
    function setDateDeCommande($dateDeCommande) {
        $this->dateDeCommande = $dateDeCommande;
    }

    function setDateExpedition($dateExpedition) {
        $this->dateExpedition = $dateExpedition;
    }

    function setClient(Client $client) {
        $this->client = $client;
    }

    function setEmploye($employe) {
        $this->employe = $employe;
    }

    function setStatut($statut) {
        $this->statut = $statut;
    }
    function __construct($numero, \DateTime $dateDeCommande, Client $client, $statut) {
        $this->numero = $numero;
        $this->dateDeCommande = $dateDeCommande;
        $this->client = $client;
        $this->statut = $statut;
    }
}
