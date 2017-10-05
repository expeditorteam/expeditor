<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as BaseUser;
/**
 * Description of Employe
 *
 * @author rremond2017
 * @ORM\Table(name="employes")
 * @ORM\Entity
 */
class Employe extends BaseUser {

        /**
     * @var integer
     *
     * @ORM\Id
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="prenom", type="string", length=255, nullable=true)
     */
    protected $prenom;

    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=255, nullable=true)
     */
    protected $nom;

    function getId() {
        return $this->id;
    }

    function getPrenom() {
        return $this->prenom;
    }

    function getNom() {
        return $this->nom;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setPrenom($prenom) {
        $this->prenom = $prenom;
    }

    function setNom($nom) {
        $this->nom = $nom;
    }
    /**
     * @var \Commande
     *
     * @ORM\ManyToMany(targetEntity="Commande")
     * @ORM\JoinTable(name="employe_has_commande",
     *      joinColumns={@ORM\JoinColumn(name="employe_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="commande_id", referencedColumnName="id")}
     * )
     */
    protected $Commandes;

    function getCommandes() {
        return $this->Commandes;
    }

    function setCommandes($Commandes) {
        $this->Commandes = $Commandes;
    }
    function __construct() {
         parent::__construct();
        $this->prenom = "";
        $this->nom = "";
        $this->username="";
        $this->email="inconnu@boite.fr";
        $this->password="Pa\$\$w0rd";
    }
}
