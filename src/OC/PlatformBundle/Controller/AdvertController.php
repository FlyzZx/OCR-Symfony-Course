<?php

namespace OC\PlatformBundle\Controller;

use OC\PlatformBundle\Entity\Advert;
use OC\PlatformBundle\Entity\Application;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Description of AdvertController
 *
 * @author nicol
 */
class AdvertController extends Controller {

    public function indexAction($page) {

        if ($page < 1) {
            throw new NotFoundHttpException("Page " . $page . " inexistante.");
        }

        $listAdverts = array(
            array(
                'title' => 'Recherche développpeur Symfony',
                'id' => 1,
                'author' => 'Alexandre',
                'content' => 'Nous recherchons un développeur Symfony débutant sur Lyon. Blabla…',
                'date' => new \Datetime()),
            array(
                'title' => 'Mission de webmaster',
                'id' => 2,
                'author' => 'Hugo',
                'content' => 'Nous recherchons un webmaster capable de maintenir notre site internet. Blabla…',
                'date' => new \Datetime()),
            array(
                'title' => 'Offre de stage webdesigner',
                'id' => 3,
                'author' => 'Mathieu',
                'content' => 'Nous proposons un poste pour webdesigner. Blabla…',
                'date' => new \Datetime())
        );

        // Et modifiez le 2nd argument pour injecter notre liste
        return $this->render('OCPlatformBundle:Advert:index.html.twig', array(
                    'listAdverts' => $listAdverts
        ));
    }

    public function viewAction($id, Request $request) {
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository("OCPlatformBundle:Advert");

        $advert = $repository->find($id);

        if ($advert === null) {
            throw new NotFoundHttpException("L'annonce d'id " . $id . " n'existe pas !");
        }

        $listApplications = $em->getRepository("OCPlatformBundle:Application")->findBy(array("advert" => $advert));

        return $this->render('OCPlatformBundle:Advert:view.html.twig', array(
                    'advert' => $advert,
                    'listApplications' => $listApplications
        ));
    }

    public function addAction(Request $request) {

        $advert = new Advert();
        $advert->setTitle('Recherche développeur Symfony.');
        $advert->setAuthor('Alexandre');
        $advert->setContent("Nous recherchons un développeur Symfony débutant sur Lyon. Blabla…");

        $em = $this->getDoctrine()->getManager();
        
        $listSkills = $em->getRepository("OCPlatformBundle:Skill")->findAll();
        
        foreach($listSkills as $skill) {
            $advertSkill = new \OC\PlatformBundle\Entity\AdvertSkill();
            
            $advertSkill->setAdvert($advert);
            $advertSkill->setSkill($skill);
            $advertSkill->setLevel("Expert");
            $em->persist($advertSkill);
        }
        
        $em->persist($advert);
        $em->flush();

        if ($request->isMethod("POST")) {
            $request->getSession()->getFlashBag()->add("notice", "Annonce bien enregistrée.");

            return $this->redirectToRoute("oc_platform_view", array("id" => 5));
        }

        return $this->render("OCPlatformBundle:Advert:add.html.twig");
    }

    public function editAction($id, Request $request) {

        $em = $this->getDoctrine()->getManager();

        $advert = $em->getRepository("OCPlatformBundle:Advert")->find($id);

        if ($advert === null) {
            throw new NotFoundHttpException("L'annonce d'id " . $id . "n'existe pas");
        }

        $listCategories = $em->getRepository("OCPlatformBundle:Category")->findAll();

        foreach ($listCategories as $category) {
            $advert->addCategory($category);
        }

        $em->flush();

        if ($request->isMethod("POST")) {
            $request->getSession()->getFlashBag()->add("notice", "Annonce bien modifiée.");

            return $this->redirectToRoute("oc_platform_view", array("id" => 5));
        }

        return $this->render('OCPlatformBundle:Advert:edit.html.twig', array(
                    'advert' => $advert
        ));
    }

    public function deleteAction($id) {
        $em = $this->getDoctrine()->getManager();

        $advert = $em->getRepository("OCPlatformBundle:Advert")->find($id);

        if ($advert === null) {
            throw new NotFoundHttpException("L'annonce d'id " . $id . "n'existe pas");
        }

        $listCategories = $em->getRepository("OCPlatformBundle:Category")->findAll();

        foreach ($listCategories as $category) {
            $advert->removeCategoryé($category);
        }

        $em->flush();
        return $this->render("OCPlatformBundle:Advert:delete.html.twig");
    }

    public function menuAction() {
        $listAdverts = array(
            array("id" => 2, "title" => "Recherche développeur Symfony"),
            array("id" => 5, "title" => "Mission de webmaster"),
            array("id" => 9, "title" => "Offre de stage webdesigner")
        );

        return $this->render("OCPlatformBundle:Advert:menu.html.twig", array("listAdverts" => $listAdverts));
    }

}
