<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Article;
use AppBundle\Entity\Client;
use AppBundle\Entity\Commande;
use AppBundle\Entity\CommandeLigne;


class ImportController extends Controller {

    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request) {

          $data = array();
       
          
        $fileName = 'C:/wamp64/www/Git/expeditor/web/uploads/import/commande.csv';
        // Using service for converting CSV to PHP Array
        $data = $this->convert($fileName);

        foreach ($data as $uneCommande) {
            $this->AddCommandeArray($uneCommande);
        }
        
        
        return $this->render('AppBundle::Default/index.html.twig');
    }
    
    
    public function AddCommandeArray($commandeArray){
          $em = $this->getDoctrine()->getManager();
        $repoCommande = $em->getRepository('AppBundle:Commande');
        
        if (count($repoCommande->findBy(array('numero' => $commandeArray["Numéro de commande"])))==0) {
        
        
        
            $repoClient = $em->getRepository('AppBundle:Client');
            $clientRes=$repoClient->findBy(array('nom' => $commandeArray["Nom client"]));
            if (count($clientRes)==0) {
                $this->AddClient($commandeArray["Nom client"], $commandeArray["Adresse"]);
                $clientRes=$repoClient->findBy(array('nom' => $commandeArray["Nom client"])); 
            }    
        
            // dump($commandeArray["Date de Commande"]);
       
            $this->AddCommande($commandeArray["Numéro de commande"], $commandeArray["Date de Commande"], $clientRes[0], "En attente");
        
        $commande=$repoCommande->findBy(array('numero' => $commandeArray["Numéro de commande"]))[0];
            
    $repoArticle = $em->getRepository('AppBundle:Article');
            $articlesArray=explode("; ",$commandeArray["Articles commandés (Quantité)"]);
              dump($articlesArray);
            foreach ($articlesArray as $articleTxt) {
                $articleArray=explode(" (",$articleTxt);
                dump($articleArray);
                
                if (count($repoArticle->findBy(array('nom' => $articleArray[0])))==0) {
                    $this->AddArticle( $articleArray[0], 10000, 200);
                }
                $article=$repoArticle->findOneBy(array('nom' =>$articleArray[0]));
                $this->AddCommandeLigneArray($commande,substr($articleArray[1],0,-1),$article);
            }
            
            
            
            
            //$repoArticle->findBy(array('nom' => "Carte mère"))[0]
        }
    }
     public function AddCommandeLigneArray($commande,$quantite, $articles){
           $em = $this->getDoctrine()->getManager();
        $repoCommandeLigne = $em->getRepository('AppBundle:CommandeLigne');        
        if (count($repoCommandeLigne->findBy(array('commande' => $commande,'articles' => $articles)))==0) {
            $this->AddCommandeLigne($commande,$quantite, $articles);
        }
    }
    
    
        private function AddClient($nom,$adresse) {
        $em = $this->getDoctrine()->getManager();
        $client = new Client($nom, $adresse);
        $em->persist($client);
        $em->flush();
    }
    
    private function AddArticle($nom, $stock, $poids) {
        $em = $this->getDoctrine()->getManager();
        $article = new Article($nom, $stock, $poids);
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
        $commande = new Commande($numero, new \DateTime($dateDeCommande), $client, $statut);
        if($employe!=null)
            $commande->setEmploye($employe);
        $em->persist($commande);
        $em->flush();
    }
    
        public function convert($filename, $delimiter = ',') 
    {
        if(!file_exists($filename) || !is_readable($filename)) {
            return FALSE;
        }
        
        $header = NULL;
        $data = array();
        if (($handle = fopen($filename, 'r')) !== FALSE) {
            while (($row = fgetcsv($handle, 1000, $delimiter)) !== FALSE) {
                if(!$header) {
                    $header = $row;
                } else {
                    $data[] = array_combine($header, $row);
                }
            }
            fclose($handle);
        }
        return $data;
    }
}
