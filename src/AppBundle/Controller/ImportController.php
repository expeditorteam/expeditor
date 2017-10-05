<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\Query\ResultSetMapping;

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
        
        dump($commandeArray);
       // AddCommande($numero, $commandeArray[0], $client, $statue);
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
    
    private function AddCommandeLigne($quantite, $articles) {
        $em = $this->getDoctrine()->getManager();
        $commandeLigne = new CommandeLigne($quantite, $articles);
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
    
        public function convert($filename, $delimiter = ',') 
    {
        if(!file_exists($filename) || !is_readable($filename)) {
            return FALSE;
        }
        
        $header = NULL;
        $data = array();
        dump("ok 0");
        if (($handle = fopen($filename, 'r')) !== FALSE) {dump("ok 1");
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
