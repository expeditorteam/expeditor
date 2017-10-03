<?php

namespace ExpeditorBundle\Entity;

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
    private $id;

    /**
     * @var date
     *
     * @ORM\Column(name="dateDeCommande", type="datetime", nullable=false)
     */
    private $dateDeCommande;

    /**
     * @var date
     *
     * @ORM\Column(name="dateExpedition", type="datetime")
     */
    private $dateExpedition;

    /**
     * @var \Client
     *
     * @ORM\ManyToOne(targetEntity="Client")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_client", referencedColumnName="id")
     * })
     */
    private $client;

    /**
     * @var \Article
     *
     * @ORM\ManyToMany(targetEntity="Article")
     * @ORM\JoinTable(name="commande_has_article",
     *      joinColumns={@ORM\JoinColumn(name="commande_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="article_id", referencedColumnName="id")}
     * )
     */
    private $articles;

        /**
     * @var \Employe
     *
     * @ORM\ManyToMany(targetEntity="Employe")
     * @ORM\JoinTable(name="commande_has_employe",
     *      joinColumns={@ORM\JoinColumn(name="commande_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="employe_id", referencedColumnName="id")}
     * )
     */
    private $employe;

    /**
     * @var string
     *
     * @ORM\Column(name="statut", type="string", length=255, nullable=false)
     */
    private $statut;

    function getId() {
        return $this->id;
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

    function setArticles(\Articles $articles) {
        $this->articles = $articles;
    }

    function setEmploye(\Employe $employe) {
        $this->employe = $employe;
    }

    function setStatut($statut) {
        $this->statut = $statut;
    }

}
