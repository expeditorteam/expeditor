<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Psr\Log\LoggerInterface;

class BouchonController extends Controller {

    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request,LoggerInterface $logger) {
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository('AppBundle:Article');

        if (count($repo->findBy(array('nom' => "Carte mère")))==0) {
            $this->AddArticle((string)"Carte mère", 10000, 200);
        }
         $logger->info("coucou");

        if (count($repo->findBy(array('nom' => "Disque")))==0) {
            $this->AddArticle((string)"Disque", 10000, 600);
        }
        if (count($repo->findBy(array('nom' => "Carte graphique")))==0) {
            $this->AddArticle((string)"Carte graphique", 10000, 300);
        }
        if (count($repo->findBy(array('nom' => "Alimentation")))==0) {
            $this->AddArticle((string)"Alimentation", 10000, 1000);
        }


        // replace this example code with whatever you need
        return $this->render('AppBundle::Default/index.html.twig');
    }

    private function AddArticle($nom, \integer $stock, \integer $poids) {
        $em = $this->getDoctrine()->getManager();
        $article = new Article($nom, $stock, $poids);
        $em->persist($article);
        $em->flush();
    }

    private function AddCommande(date $dateDeCommande, \Client $client, \Article $articles, $statut) {
        $em = $this->getDoctrine()->getManager();
        $commande = new Commande($dateDeCommande, $client, $articles, $statut);
        $em->persist($commande);
        $em->flush();
    }

}
