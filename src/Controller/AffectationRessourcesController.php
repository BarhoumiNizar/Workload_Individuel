<?php

namespace App\Controller;

use App\Entity\AffectationRessources;
use App\Form\AffectationRessourcesType;
use App\Repository\AffectationRessourcesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ProjetsRepository;
use App\Repository\RessourcesRepository;
/**
 * @Route("/affectation/ressources")
 */
class AffectationRessourcesController extends AbstractController
{
    /**
     * @Route("/", name="affectation_ressources_index", methods={"GET"})
     */
    public function index(AffectationRessourcesRepository $affectationRessourcesRepository): Response
    {
        return $this->render('affectation_ressources/index.html.twig', [
            'affectation_ressources' => $affectationRessourcesRepository->findAll(),
        ]);
    }

    /**
     * @Route("/Ajout", name="affectation_ressources_new", methods={"GET","POST"})
     */
    public function new(Request $request,AffectationRessourcesRepository $affectationRessourcesRepository,ProjetsRepository $projetRepository,RessourcesRepository $ressourceRepository): Response
    {
          
     $affectationRessources = $affectationRessourcesRepository->findAll();
     $ressourcesALL=$ressourceRepository->findAll();
     $projets=$projetRepository->findAll();

    
        $form = $this->createForm(AffectationRessourcesType::class);
        $form->handleRequest($request);

        if ($request->isMethod('POST')) {
            $forms=$request->get('affectation_ressources');
            $ressource=$forms['Ressource'];
            $projetForm=$request->get('projet');
            $moisForm=$request->get('Mois');
               $pourcentages=$request->get('pourcentage');
           
            // vérifier si le ressource à un projet ou non
            $verif=$affectationRessourcesRepository->findOneBy(['Ressource'=>$ressource]);
           
            if(!empty($verif))
            {
                  $affectationRessource = $affectationRessourcesRepository->find($verif->getId());
                 
               $mois_Affectation=$verif->getMois();// tab des mois de BD
               $pourcentage_Affectation=$verif->getPourcentage();// tab des Pourcentage de BD
               $projet_Affectation=$verif->getProjet();// tab des Projet de BD
              for($i=0,$j=0,$p=0;$i<count($moisForm),$j<count($pourcentages),$p<count($projetForm);$i++,$j++,$p++){
                    array_push($mois_Affectation,$moisForm[$i]);
                    array_push($pourcentage_Affectation,$pourcentages[$j]);
                    array_push($projet_Affectation,$projetForm[$p]);
               }
              
                $affectationRessource->setProjet($projet_Affectation);
                $affectationRessource->setMois($mois_Affectation);
                $affectationRessource->setPourcentage($pourcentage_Affectation);
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($affectationRessource);
                $entityManager->flush();
            }
            // Si non
            else // si le ressource et le projet on une affectation
            {
               
                  $affectationRessource = new AffectationRessources();
                //$project=$projetRepository->find($projet);
                $ressources=$ressourceRepository->find($ressource);
                
                $affectationRessource->setProjet($projetForm);
                $affectationRessource->setRessource($ressources);
                $affectationRessource->setMois($moisForm);
                $affectationRessource->setPourcentage($pourcentages);
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($affectationRessource);
                $entityManager->flush();
            }
            $this->addFlash('affectation', 'L’affectation est effectuer avec sucées');

            return $this->redirectToRoute('affectation_ressources_new');
        }

        return $this->render('affectation_ressources/Ajout.html.twig', [
            'affectationRessources'=>$affectationRessources,
            'projets'=>$projets,
            'form' => $form->createView(),
            'activation'=>'Affectation',
            'classe'=>'Affectation d’une ressource'
        ]);
    }

    /**
     * @Route("/{id}", name="affectation_ressources_show", methods={"GET"})
     */
    public function show(AffectationRessources $affectationRessource): Response
    {
        return $this->render('affectation_ressources/show.html.twig', [
            'affectation_ressource' => $affectationRessource,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="affectation_ressources_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, AffectationRessources $affectationRessource): Response
    {
        $form = $this->createForm(AffectationRessourcesType::class, $affectationRessource);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('affectation_ressources_index');
        }

        return $this->render('affectation_ressources/edit.html.twig', [
            'affectation_ressource' => $affectationRessource,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="affectation_ressources_delete", methods={"DELETE"})
     */
    public function delete(Request $request, AffectationRessources $affectationRessource): Response
    {
        if ($this->isCsrfTokenValid('delete'.$affectationRessource->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($affectationRessource);
            $entityManager->flush();
        }

        return $this->redirectToRoute('affectation_ressources_index');
    }
}
