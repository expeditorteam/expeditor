<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class EmployeController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('AppBundle::Employe/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
        ]);
    }
/*
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
      //  return $this->render('ExpeditorBundle:Default:index.html.twig');
    }*/


public function listeAction() {

        // récupération de l'entity manager à partir du service Doctrine
        $em = $this->getDoctrine()->getManager();

        // récupération du repository de livre:
        $repo = $em->getRepository('AppBundle:Employe');

        $livres = $repo->findAll();

        return $this->render('AppBundle:Employe:liste.html.twig', ['livres' => $livres]
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

        $employe = new Employe();

        $form = $this->createFormBuilder($employe)
                ->add('nom')
                ->add('prenom')
                ->add('email')
                ->add('password')
                ->add('enregistrer', SubmitType::class)
                ->getForm();

        // Valorisation des attributs de l'objet employe
        // avec les champs du formulaire
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            // Sauvegarde de l'employé si le formulaire est valide
            $em->persist($employe);

            $em->flush();
        }

        // intégration de bootstrap avec la modification du fichier config.yml : 
        // form_themes: ['bootstrap_3_layout.html.twig']
        
        return $this->render('AppBundle:Employe:add.html.twig', ['form' => $form->createView()]);
    }

    /**
     * 
     * @param Request $request
     * @param type $id
     * @return type
     * @deprecated since 21/06/2017
     */
    public function updateAction(Request $request, $id) {

        $em = $this->getDoctrine()->getManager();

        $repository = $em->getRepository('AppBundle:Employe');
        // récupération d'une instance de classe employe
        $employe = $repository->find($id);

        $form = $this->createFormBuilder($employe)
                ->add('nom')
                ->add('prenom')
                ->add('email')
                ->add('password')
                ->add('enregistrer', SubmitType::class)
                ->getForm();

        // Valorisation des attributs de l'objet livre
        // avec les champs du formulaire
        $form->handleRequest($request);

        dump($employe);

        if ($form->isSubmitted() && $form->isValid()) {
            // Sauvegarde de l'employé si le formulaire est valide
            $em->persist($employe);

            $em->flush();
        }

        return $this->render('AppBundle:Employe:add.html.twig', ['form' => $form->createView()]);
    }

    public function editAction(Request $request, Livre $livre = null) {

        $em = $this->getDoctrine()->getManager();

        // $livre est demandé en parametre du contrôleur à la place de la variable 
        // $id demandée dans la route du fait que $id soit la PK
        if ($employe == null) {
            $employe = new Employe();
        }
        
        // Création de la classe formBuilder, ajout des champs (attributs de l'objet lié au formulaire), 
        // et retour d'une instance d'une classe Form Symfony
        $form = $this->createFormBuilder($employe)
                ->add('nom')
                ->add('prenom')
                ->add('email')
                ->add('password')
                ->add('enregistrer', SubmitType::class)
                ->getForm();


        // Valorisation des attributs de l'objet livre
        // avec les champs du formulaire
        $form->handleRequest($request);

        dump($employe);

        if ($form->isSubmitted() && $form->isValid()) {
            // Sauvegarde du livre si le formulaire est valide
            $em->persist($employe);

            $em->flush();

            return $this->redirectToRoute('expeditor_employelistepage');
        }

        return $this->render('AppBundle:Employe:add.html.twig', ['form' => $form->createView()]);
        
        
    }
    
    public function roleAction(){
        // Dans un contrôleur :

        // Pour récupérer le service UserManager du bundle
        $userManager = $this->get('fos_user.user_manager');

        // Pour charger un utilisateur
        $user = $userManager->findUserBy(array('username' => 'toto'));
        $user2 = $userManager->findUserBy(array('username' => 'zee'));

        // Pour changer le role
        $roleEmploye = array('ROLE_ADMIN');
        $roleManager = array('ROLE_SUPER_ADMIN');

        $user->setRoles($roleEmploye);
        $user2->setRoles($roleManager);
        
//
//        // Pour modifier un utilisateur
//        $user->setEmail('cetemail@nexiste.pas');
//        $userManager->updateUser($user); // Pas besoin de faire un flush avec l'EntityManager, cette méthode le fait toute seule !
//
//        // Pour supprimer un utilisateur
//        $userManager->deleteUser($user);
//
//        // Pour récupérer la liste de tous les utilisateurs
//        $users = $userManager->findUsers();
    }
}