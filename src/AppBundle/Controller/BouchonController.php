<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Psr\Log\LoggerInterface;
use AppBundle\Entity\Article;
use AppBundle\Entity\Client;
use AppBundle\Entity\Commande;
use AppBundle\Entity\CommandeLigne;
use AppBundle\Entity\Employe;

class BouchonController extends Controller {

    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $repoArticle = $em->getRepository('AppBundle:Article');
        $logger = $this->get('logger');
  //$logger->err('An error occurred');
        
        // Création des Articles :
        
        if (count($repoArticle->findBy(array('nom' => "Carte mère")))==0) {
            $this->AddArticle("Carte mère", 10000, 200,79.69);
        }
        if (count($repoArticle->findBy(array('nom' => "Disque")))==0) {
            $this->AddArticle("Disque", 10000, 600,155.42);
        }
        if (count($repoArticle->findBy(array('nom' => "Carte graphique")))==0) {
            $this->AddArticle("Carte graphique", 10000, 300,345.90);
        }
        if (count($repoArticle->findBy(array('nom' => "Alimentation")))==0) {
            $this->AddArticle("Alimentation", 10000, 1000,62.55);
        }

        // Création des Clients :
        
        $repo = $em->getRepository('AppBundle:Client');
        if (count($repo->findBy(array('nom' => "NTP")))==0) {
            $this->AddClient("NTP", "89 avenue Charles de Gaulle - 44000 NANTES");
        }
        if (count($repo->findBy(array('nom' => "ACE")))==0) {
            $this->AddClient("ACE", "125 Place Saint Pierre - 44470 CARQUEFOU");
        }
        if (count($repo->findBy(array('nom' => "ANG")))==0) {
            $this->AddClient("ANG", "5 rue Lilas - 44100 NANTES");
        }
        if (count($repo->findBy(array('nom' => "BAT")))==0) {
            $this->AddClient("BAT", "12 avenue Pinsons - 49000 ANGERS");
        }
        if (count($repo->findBy(array('nom' => "YOKO")))==0) {
            $this->AddClient("YOKO", "3 rue Droite - 11100 NARBOENNE");
        }
        
        // Création des Employés

        // Pour r�cup�rer le service UserManager du bundle
        $userManager = $this->get('fos_user.user_manager');
        $user = $userManager->findUserByUsername('zee');
        if (is_null($user)) {
            $user = $this->get('fos_user.util.user_manipulator')->create('zee', 'zee', 'zee@example.com', 1, 0);
        }
        $user->setRoles(array('ROLE_SUPER_ADMIN'));
        $userManager->updateUser($user);
        $user2 = $userManager->findUserByUsername('toto');
        if (is_null($user2)) {
            $user2 = $this->get('fos_user.util.user_manipulator')->create('toto', 'toto', 'toto5@example.com', 1, 0);
        }
        $user2->setRoles(array('ROLE_ADMIN'));
        $userManager->updateUser($user2);
        
                $user2 = $userManager->findUserByUsername('Jack');
        if (is_null($user2)) {
            $user2 = $this->get('fos_user.util.user_manipulator')->create('Jack', 'Jack', 'toto4@example.com', 1, 0);
        }
        $user2->setRoles(array('ROLE_ADMIN'));
        $userManager->updateUser($user2);
        
                $user2 = $userManager->findUserByUsername('Bob');
        if (is_null($user2)) {
            $user2 = $this->get('fos_user.util.user_manipulator')->create('Bob', 'Bob', 'toto3@example.com', 1, 0);
        }
        $user2->setRoles(array('ROLE_ADMIN'));
        $userManager->updateUser($user2);
        
                $user2 = $userManager->findUserByUsername('Eric');
        if (is_null($user2)) {
            $user2 = $this->get('fos_user.util.user_manipulator')->create('Eric', 'Eric', 'toto2@example.com', 1, 0);
        }
        $user2->setRoles(array('ROLE_ADMIN'));
        $userManager->updateUser($user2);
        
                $user2 = $userManager->findUserByUsername('Jean');
        if (is_null($user2)) {
            $user2 = $this->get('fos_user.util.user_manipulator')->create('Jean', 'Jean', 'toto1@example.com', 1, 0);
        }
        $user2->setRoles(array('ROLE_ADMIN'));
        $userManager->updateUser($user2);
        
        
            
        // Création des commandes :
  
        $repoCommande = $em->getRepository('AppBundle:Commande');
        
        if (count($repoCommande->findBy(array('numero' => "NC 30")))==0) {

            $client1= new Client("NTP", "89 avenue Charles de Gaulle - 44000 NANTES");
            $this->AddCommande("NC 30",
                  new \DateTime(),
                  $client1,
                    "En Attente",$user2);
        }
        // Création des lignes de cette commande
        $repo = $em->getRepository('AppBundle:CommandeLigne');        
        if (count($repo->findBy(array('id' => "1")))==0) {
            $commande=$repoCommande->findOneBy(array('numero' => "NC 30"));
            $this->AddCommandeLigne($commande,18,$repoArticle->findBy(array('nom' => "Carte mère"))[0]);
        }
        
        
        
        // replace this example code with whatever you need
        return $this->render('AppBundle::Default/index.html.twig');
    }

    private function AddEmploye($prenom, $nom) {
        $em = $this->getDoctrine()->getManager();
        $employe = new Employe($prenom, $nom);
        $em->persist($employe);
        $em->flush();
    }

    private function AddClient($nom,$adresse) {
        $em = $this->getDoctrine()->getManager();
        $client = new Client($nom, $adresse);
        $em->persist($client);
        $em->flush();
    }
    
    private function AddArticle($nom, $stock, $poids,$prix) {
        $em = $this->getDoctrine()->getManager();
        $article = new Article($nom, $stock, $poids,$prix);
        $em->persist($article);
        $em->flush();
    }
    
    private function AddCommandeLigne($commande,$quantite, $articles) {
        $em = $this->getDoctrine()->getManager();
        $commandeLigne = new CommandeLigne($commande,$quantite, $articles);
        $em->persist($commandeLigne);
        $em->flush();
    }
    
    private function AddCommande($numero, $dateDeCommande, Client $client, $statut,$employe=null) {
        $em = $this->getDoctrine()->getManager();
        $commande = new Commande($numero, $dateDeCommande, $client, $statut);
        if($employe!=null)
            $commande->setEmploye($employe);
        $em->persist($commande);
        $em->flush();
    }
    
}
