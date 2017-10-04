<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ArticleController extends Controller {

    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request) {
        // replace this example code with whatever you need
        return $this->render('AppBundle::Article/index.html.twig', [
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

        // r�cup�ration de l'entity manager � partir du service Doctrine
        $em = $this->getDoctrine()->getManager();

        // r�cup�ration du repository de Article:
        $repo = $em->getRepository('AppBundle:Article');

        $articles = $repo->findAll();

        return $this->render('AppBundle:Article:liste.html.twig', ['articles' => $articles]
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

        $article = new Article();

        $form = $this->createFormBuilder($article)
                ->add('nom')
                ->add('stock')
                ->add('poids')
                ->add('enregistrer', SubmitType::class)
                ->getForm();

        // Valorisation des attributs de l'objet article
        // avec les champs du formulaire
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            // Sauvegarde de l'article si le formulaire est valide
            $em->persist($article);

            $em->flush();
        }

        // int�gration de bootstrap avec la modification du fichier config.yml : 
        // form_themes: ['bootstrap_3_layout.html.twig']

        return $this->render('AppBundle:Article:add.html.twig', ['form' => $form->createView()]);
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

        $repository = $em->getRepository('AppBundle:Article');
        // r�cup�ration d'une instance de classe article
        $article = $repository->find($id);

        $form = $this->createFormBuilder($article)
                ->add('nom')
                ->add('stock')
                ->add('poids')
                ->add('enregistrer', SubmitType::class)
                ->getForm();

        // Valorisation des attributs de l'objet article
        // avec les champs du formulaire
        $form->handleRequest($request);

        dump($article);

        if ($form->isSubmitted() && $form->isValid()) {
            // Sauvegarde de l'employ� si le formulaire est valide
            $em->persist($article);

            $em->flush();
        }

        return $this->render('AppBundle:Article:add.html.twig', ['form' => $form->createView()]);
    }

    public function editAction(Request $request, Article $article = null) {

        $em = $this->getDoctrine()->getManager();

        // $article est demand� en parametre du contr�leur � la place de la variable 
        // $id demand�e dans la route du fait que $id soit la PK
        if ($article == null) {
            $article = new Article();
        }

        // Cr�ation de la classe formBuilder, ajout des champs (attributs de l'objet li� au formulaire), 
        // et retour d'une instance d'une classe Form Symfony
        $form = $this->createFormBuilder($article)
                ->add('nom')
                ->add('stock')
                ->add('poids')
                ->add('enregistrer', SubmitType::class)
                ->getForm();


        // Valorisation des attributs de l'objet Article
        // avec les champs du formulaire
        $form->handleRequest($request);

        dump($article);

        if ($form->isSubmitted() && $form->isValid()) {
            // Sauvegarde de l'article si le formulaire est valide
            $em->persist($article);

            $em->flush();

            return $this->redirectToRoute('expeditor_articlelistepage');
        }

        return $this->render('AppBundle:Article:add.html.twig', ['form' => $form->createView()]);
    }

}
