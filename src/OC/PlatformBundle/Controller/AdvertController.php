<?php

namespace OC\PlatformBundle\Controller;

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

        $nbPerPage = 10;
        
        if ($page < 1) {
            throw new NotFoundHttpException("Page " . $page . " inexistante.");
        }

        $em = $this->getDoctrine()->getManager();

        $listAdverts = $em->getRepository("OCPlatformBundle:Advert")->getAdverts($page, $nbPerPage);
        
        $nbPages = count($listAdverts) / $nbPerPage;
        
        // Et modifiez le 2nd argument pour injecter notre liste
        return $this->render('OCPlatformBundle:Advert:index.html.twig', array(
                    'listAdverts' => $listAdverts,
            "nbPages" => ceil($nbPages),
            "page" => $page
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
        $listAdvertSkills = $em->getRepository("OCPlatformBundle:AdvertSkill")->findBy(array("advert" => $advert));


        return $this->render('OCPlatformBundle:Advert:view.html.twig', array(
                    'advert' => $advert,
                    'listApplications' => $listApplications,
                    "listAdvertSkills" => $listAdvertSkills
        ));
    }

    public function addAction(Request $request) {

        if ($request->isMethod("POST")) {
            $request->getSession()->getFlashBag()->add("notice", "Annonce bien enregistrée.");

            return $this->redirectToRoute("oc_platform_view", array("id" => $advert->getId()));
        }

        return $this->render("OCPlatformBundle:Advert:add.html.twig");
    }

    public function editAction($id, Request $request) {

        $em = $this->getDoctrine()->getManager();

        $advert = $em->getRepository("OCPlatformBundle:Advert")->find($id);

        if ($advert === null) {
            throw new NotFoundHttpException("L'annonce d'id " . $id . "n'existe pas");
        }


        if ($request->isMethod("POST")) {
            $request->getSession()->getFlashBag()->add("notice", "Annonce bien modifiée.");

            return $this->redirectToRoute("oc_platform_view", array("id" => $advert->getId()));
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
            $advert->removeCategory($category);
        }

        $em->flush();
        return $this->render("OCPlatformBundle:Advert:delete.html.twig");
    }

    public function menuAction($limit) {
        $repo = $this->getDoctrine()->getManager()->getRepository("OCPlatformBundle:Advert");
        $listAdverts = $repo->findBy(array(), array("date" => "desc"), $limit, 0);

        return $this->render("OCPlatformBundle:Advert:menu.html.twig", array("listAdverts" => $listAdverts));
    }

}
