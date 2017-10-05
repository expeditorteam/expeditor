<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class EmployeController extends Controller {

    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request) {
        // replace this example code with whatever you need
        return $this->render('AppBundle::Employe/index.html.twig', [
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
      } */

    public function listeAction() {

        
        
        

        return $this->render('AppBundle:Manager:index.html.twig', ['employes' => $employes]
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

            // Sauvegarde de l'employ� si le formulaire est valide
            $em->persist($employe);

            $em->flush();
        }

        // int�gration de bootstrap avec la modification du fichier config.yml : 
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
        // r�cup�ration d'une instance de classe employe
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
            // Sauvegarde de l'employ� si le formulaire est valide
            $em->persist($employe);

            $em->flush();
        }

        return $this->render('AppBundle:Employe:add.html.twig', ['form' => $form->createView()]);
    }

    public function editAction(Request $request, Livre $livre = null) {

        $em = $this->getDoctrine()->getManager();

        // $livre est demand� en parametre du contr�leur � la place de la variable 
        // $id demand�e dans la route du fait que $id soit la PK
        if ($employe == null) {
            $employe = new Employe();
        }

        // Cr�ation de la classe formBuilder, ajout des champs (attributs de l'objet li� au formulaire), 
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

    public function roleAction() {

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
            $user2 = $this->get('fos_user.util.user_manipulator')->create('toto', 'toto', 'toto@example.com', 1, 0);
        }
        $user2->setRoles(array('ROLE_ADMIN'));
        $userManager->updateUser($user2);

        return $this->render('AppBundle:Default:index.html.twig', ['user' => $user]);
    }

}
