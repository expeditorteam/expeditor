<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace expeditorBundle\Commande;

/**
 * Description of Commande
 *
 * @author rremond2017
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
     * @ORM\Column(name="dateDeCommande", type="date", length=255, nullable=false)
     */
    private $dateDeCommande;
    
            /**
     * @var date
     *
     * @ORM\Column(name="dateExpedition", type="date", length=255, nullable=false)
     */
    private $dateExpedition;
    
     /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=255, nullable=false)
     */
    private $nom;
    
}
