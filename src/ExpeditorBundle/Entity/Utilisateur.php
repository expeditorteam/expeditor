<?php
namespace expeditorBundle\Utilisateur;

use Doctrine\ORM\Mapping as ORM;

/**
 * Description of Employe
 *
 * @author rremond2017
 * @ORM\Table(name="personne", uniqueConstraints={@ORM\UniqueConstraint(name="email", columns={"email"})})
 * @ORM\Entity
 */
class Utilisateur
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;
  

        /**
     * @var string
     *
     * @ORM\Column(name="prenom", type="string", length=255, nullable=false)
     */
    private $prenom;

    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=255, nullable=false)
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255, nullable=false)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=128, nullable=false)
     */
    private $password;

    /**
     * @var string
     *
     * @ORM\Column(name="latitude", type="string", length=10, nullable=true)
     */
    private $profil;

  function getId() {
        return $this->id;
    }

    function getPrenom() {
        return $this->prenom;
    }

    function getNom() {
        return $this->nom;
    }

    function getEmail() {
        return $this->email;
    }

    function getPassword() {
        return $this->password;
    }

    function getProfil() {
        return $this->profil;
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

    function setEmail($email) {
        $this->email = $email;
    }

    function setPassword($password) {
        $this->password = $password;
    }

    function setProfil($profil) {
        $this->profil = $profil;
    }

    
}
