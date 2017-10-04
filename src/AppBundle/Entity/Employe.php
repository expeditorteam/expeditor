<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Description of Employe
 *
 * @author rremond2017
 * @ORM\Table(name="employes")
 * @ORM\Entity
 */
class Employe extends \AppBundle\Entity\Utilisateur {

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

}
