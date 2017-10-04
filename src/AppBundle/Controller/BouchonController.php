<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        
        
        
        
        // replace this example code with whatever you need
        return $this->render('AppBundle::Default/index.html.twig');
    }
    private function AddArticle(string $nom, int $stock,int $poids){
       $em = $this->getDoctrine()->getManager();
       $article = new Article($nom, $stock, $poids);
       $em->persist($article);
       $em->flush();
    }
    private function AddCommande(date $dateDeCommande, \Client $client, \Article $articles, $statut){
       $em = $this->getDoctrine()->getManager();
       $commande = new Commande($dateDeCommande, $client, $articles, $statut);
       $em->persist($commande);
       $em->flush();
    }
    
}
