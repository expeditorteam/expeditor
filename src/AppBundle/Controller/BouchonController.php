<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Psr\Log\LoggerInterface;
use AppBundle\Entity\Article;
use AppBundle\Entity\Client;
use AppBundle\Entity\Commande;

class BouchonController extends Controller {

    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository('AppBundle:Article');
        $logger = $this->get('logger');
  //$logger->err('An error occurred');
        
        // Création des Articles :
        
        if (count($repo->findBy(array('nom' => "Carte mère")))==0) {
            $this->AddArticle("Carte mère", 10000, 200);
        }
        if (count($repo->findBy(array('nom' => "Disque")))==0) {
            $this->AddArticle("Disque", 10000, 600);
        }
        if (count($repo->findBy(array('nom' => "Carte graphique")))==0) {
            $this->AddArticle("Carte graphique", 10000, 300);
        }
        if (count($repo->findBy(array('nom' => "Alimentation")))==0) {
            $this->AddArticle("Alimentation", 10000, 1000);
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
        
        // Création des commandes :
        
        $repo = $em->getRepository('AppBundle:Commande');
        
        if (count($repo->findBy(array('numero' => "NC 30")))==0) {
            
            $client1= new Client("NTP", "89 avenue Charles de Gaulle - 44000 NANTES");
            $this->AddCommande("NC 30",
                    date("Y-m-d H:i:s"),
                  $client1,
        [new Article("Alimentation", 10000, 1000)],
                    "En Attente");
        }
        
        
        
        
        // replace this example code with whatever you need
        return $this->render('AppBundle::Default/index.html.twig');
    }

    private function AddArticle($nom, $stock, $poids) {
        $em = $this->getDoctrine()->getManager();
        $article = new Article($nom, $stock, $poids);
        $em->persist($article);
        $em->flush();
    }

    private function AddClient($nom,$adresse) {
        $em = $this->getDoctrine()->getManager();
        $client = new Client($nom, $adresse);
        $em->persist($client);
        $em->flush();
    }
    private function AddCommande($numero, $dateDeCommande, Client $client, Article $articles, $statut) {
        $em = $this->getDoctrine()->getManager();
        $commande = new Commande($numero, $dateDeCommande, $client, $articles, $statut);
        $em->persist($commande);
        $em->flush();
    }
}
