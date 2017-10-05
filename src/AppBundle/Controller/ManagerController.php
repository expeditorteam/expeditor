<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\Query\ResultSetMapping;

class ManagerController extends Controller {

    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request) {
        //$rawSql = "SELECT * FROM commandes AS c WHERE c.employe_id=employe.id AND c.dateExpedition LIKE '2017-10-05%'";
//        $qb->select('c')
//                ->from('Commande', 'c')
//                ->where('c.employe_id = employe.getId()')
//                ->andWhere("c.dateExpedition LIKE '2017-10-05'")
//                ->orderBy('u.name', 'ASC');
        $em = $this->getDoctrine()->getManager();
        $repoEmploye = $em->getRepository('AppBundle:Employe');
        //$repoCommande = $em->getRepository('AppBundle:Commande');
        $employes = $repoEmploye->findAll();
        $listeNbCommande = array();
        
        foreach ($employes as $employe) {
            
            $em = $this->getDoctrine()->getManager()->getConnection();

            $query="SELECT count(*) FROM commandes WHERE id_employe=:id AND CAST(dateExpedition AS DATE) LIKE CAST(NOW() AS DATE)";
            $stmt = $em->prepare($query); 
            $stmt->bindValue("id", $employe->getId());
            $stmt->execute();
            $commandesEmploye = $stmt->fetchColumn(0);
            
            $listeNbCommande[] =$commandesEmploye ;
            dump($commandesEmploye);
        }
        

        // replace this example code with whatever you need
        return $this->render('AppBundle::Manager/index.html.twig',
                [
                    'listeNbCommande' => $listeNbCommande,
                    'employes' => $employes
                ]
        );
    }

    /**
     * @Route("/", name="homepage")
     */
    public function articlesAction(Request $request) {
        // replace this example code with whatever you need
        return $this->render('AppBundle::Manager/articles.html.twig', [
                    'base_dir' => realpath($this->getParameter('kernel.project_dir')) . DIRECTORY_SEPARATOR,
        ]);
    }

    /*
      use Symfony\Bundle\FrameworkBundle\Controller\Controller;

      class DefaultController extends Controller
      {
      public function indexAction()
      {
      //  return $this->render('ExpeditorBundle:Default:index.html.twig');
      }
      }
     */

    public function listeAction() {

        // récupération de l'entity manager à partir du service Doctrine
        $em = $this->getDoctrine()->getManager();

        // récupération du repository de manager:
        $repo = $em->getRepository('AppBundle:Manager');

        $managers = $repo->findAll();

        return $this->render('AppBundle:Manager:liste.html.twig', ['managers' => $managers]
        );
    }

    /**
     * 
     * @param Request $request
     * @return type
     * @deprecated since 21/06/2017
     */
    public function addAction(Request $request) {

        $em = $this->getDoctrine()->getManager();

        $manager = new Manager();

        $form = $this->createFormBuilder($manager)
                ->add('nom')
                ->add('prenom')
                ->add('email')
                ->add('password')
                ->add('enregistrer', SubmitType::class)
                ->getForm();

        // Valorisation des attributs de l'objet manager
        // avec les champs du formulaire
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            // Sauvegarde du manager si le formulaire est valide
            $em->persist($manager);

            $em->flush();
        }

        // intégration de bootstrap avec la modification du fichier config.yml : 
        // form_themes: ['bootstrap_3_layout.html.twig']

        return $this->render('AppBundle:Manager:add.html.twig', ['form' => $form->createView()]);
    }

    public function editAction(Request $request, Manager $manager = null) {

        $em = $this->getDoctrine()->getManager();

        // $manager est demandé en parametre du contrôleur à la place de la variable 
        // $id demandée dans la route du fait que $id soit la PK
        if ($manager == null) {
            $manager = new Manager();
        }

        // Création de la classe formBuilder, ajout des champs (attributs de l'objet lié au formulaire), 
        // et retour d'une instance d'une classe Form Symfony
        $form = $this->createFormBuilder($manager)
                ->add('nom')
                ->add('prenom')
                ->add('email')
                ->add('password')
                ->add('enregistrer', SubmitType::class)
                ->getForm();

        // Valorisation des attributs de l'objet manager
        // avec les champs du formulaire
        $form->handleRequest($request);

        dump($manager);

        if ($form->isSubmitted() && $form->isValid()) {
            // Sauvegarde du manager si le formulaire est valide
            $em->persist($manager);

            $em->flush();

            return $this->redirectToRoute('eni_managerlistepage');
        }

        return $this->render('AppBundle:Manager:add.html.twig', ['form' => $form->createView()]);
    }

}
