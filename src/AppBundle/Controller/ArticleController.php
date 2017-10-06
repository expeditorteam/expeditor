<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Article;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;

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

    public function listeAction(Request $request) {

        // $request = $this->getRequest();

        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository('AppBundle:Article');
        $id = $request->query->get('delete');


        if ($id != null) {
            try {
                $articleAsupprimer = $repo->findById($id);
                if ($articleAsupprimer != null) {
                    $em = $this->getDoctrine()->getManager();
                    $em->remove($articleAsupprimer[0]);
                    $em->flush();
                }
                return $this->redirectToRoute('expeditor_manager_articles_list');
            } catch (\Doctrine\DBAL\Exception\ForeignKeyConstraintViolationException $e) {
                return new \Symfony\Component\HttpFoundation\Response('Erreur');
            }
        }

        $logger = $this->get('logger');


        $article = new Article();

        $form = $this->createFormBuilder($article)
                ->add('id', HiddenType::class)
                ->add('nom')
                ->add('stock')
                ->add('poids')
                ->add('prix')
                ->add('enregistrer', SubmitType::class)
                ->getForm();

        // Valorisation des attributs de l'objet article
        // avec les champs du formulaire
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $logger->err('id: ' + $article->getId());

            // si pas d'id, pas d'article en BDD 
            if ($article->getId() == null) {
                $em->persist($article);
                $em->flush();

                //donc on vide formulaire pour ajouter article avec New id
                unset($article);
                unset($form);

                $article = new Article();
                $form = $this->createFormBuilder($article)
                        ->add('id', HiddenType::class)
                        ->add('nom')
                        ->add('stock')
                        ->add('poids')
                        ->add('enregistrer', SubmitType::class)
                        ->getForm();
            } else {

                $logger->err('pas null: ');

                $em->merge($article);
                $em->flush();

                unset($article);
                unset($form);

                $article = new Article();
                $form = $this->createFormBuilder($article)
                        ->add('id', HiddenType::class)
                        ->add('nom')
                        ->add('stock')
                        ->add('poids')
                        ->add('enregistrer', SubmitType::class)
                        ->getForm();
            }
        }
        echo("\n");

        // récupération du repository de Article:
        $repositoryArticle = $em->getRepository('AppBundle:Article');
        $articles = $repositoryArticle->findAll();

        return $this->render('AppBundle:Article:liste.html.twig', ['articles' => $articles, 'form' => $form->createView()]
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

        // intÃ©gration de bootstrap avec la modification du fichier config.yml : 
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
        $id = document . getElementById('riri') . onclick;

        $repository = $em->getRepository('AppBundle:Article');
        // rÃ©cupÃ©ration d'une instance de classe article
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
            // Sauvegarde de l'employÃ© si le formulaire est valide
            $em->persist($article);

            $em->flush();
        }

        return $this->render('AppBundle:Article:add.html.twig', ['form' => $form->createView()]);
    }

    public function deleteAction(Article $article) {
        
    }

    public function editAction(Request $request, Article $article = null) {

        $em = $this->getDoctrine()->getManager();

        // $article est demandÃ© en parametre du contrÃ´leur Ã  la place de la variable 
        // $id demandÃ©e dans la route du fait que $id soit la PK
        if ($article == null) {
            $article = new Article();
        }

        // CrÃ©ation de la classe formBuilder, ajout des champs (attributs de l'objet liÃ© au formulaire), 
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

    public function viderformAction() {
        $article = new Article();
        $form = $this->createFormBuilder($article)
                ->add('id', HiddenType::class)
                ->add('nom')
                ->add('stock')
                ->add('poids')
                ->add('enregistrer', SubmitType::class)
                ->getForm();
    }

}
