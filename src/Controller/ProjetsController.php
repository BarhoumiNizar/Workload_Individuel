<?php

namespace App\Controller;

use App\Entity\Projets;
use App\Entity\AffectationRessources;
use App\Form\ProjetForm;
use App\Repository\ProjetsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/projets")
 */
class ProjetsController extends AbstractController
{
    /**
     * @Route("/", name="projets_index", methods={"GET"})
     */
    public function index(ProjetsRepository $projetsRepository): Response
    {
        return $this->render('projets/index.html.twig', [
            'projets' => $projetsRepository->findAll(),
            'activation'=>'Projets',
            'classe'=>''
        ]);
    }

    /**
     * @Route("/Add", name="projets_new", methods={"GET","POST"})
     */
    public function Add(Request $request,ProjetsRepository $projetsRepository): Response
    {
        $projet = new Projets();
        $form = $this->createForm(ProjetForm::class, $projet);
        $form->handleRequest($request);

        if ($request->isMethod('POST')) {
            $project=$projet->getNomProjet();
            // verifier si le projet saisie existe ou non
               $verifProject=$projetsRepository->findBy(['nomProjet'=>$project]);
                if(!empty($verifProject))
                {
                    $this->addFlash('verificationProjet', 'Le Projet '.$project.' existe déja');
                }
                else
                {
            $entityManager = $this->getDoctrine()->getManager();
            $competences=$request->get('competence');
            $projet->setCompetence($competences);
            $entityManager->persist($projet);

            $entityManager->flush();

            return $this->redirectToRoute('projets_index');
                }
        }

        return $this->render('projets/Ajout.html.twig', [
            'projet' => $projet,
            'form' => $form->createView(),
            'activation'=>'Projets',
            'classe'=>'Ajout'
        ]);
    }

    /**
     * @Route("/{id}/edit", name="projets_edit", methods={"GET","POST"})
     */
    public function Modifier(Request $request, Projets $projet): Response
    {
        $form = $this->createForm(ProjetForm::class, $projet);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('projets_index');
        }

        return $this->render('projets/edit.html.twig', [
            'projet' => $projet,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/Supprimer", name="projets_Supprimet_desactiver", methods={"GET","POST"})
     */
    public function delete(Request $request, ProjetsRepository $projet): Response
    {
        $projets=$projet->findALL();
        if ($request->isMethod('POST')) 
        {
            $idProjet=$request->get('projet');
            // la valeur de bouton sélectionner
            $btn=$request->get('btn');
            $cnx=$this->getDoctrine()->getManager();
            // si le bouton est supprimer
            if($btn=='Supprimer')
            {
                //echo '<h1>'.$idProjet.'</h1>';
                // si le bouton sélectionner est supprimer il faut modifier le foreign key dans la table affectation_ressources
                $q = $cnx->createQueryBuilder()
                ->update(AffectationRessources::class, 'af')
                ->set('af.Projet', '?1')
                ->where('af.Projet = ?2')
                ->setParameter(1, null)
                ->setParameter(2, $idProjet)
                ->getQuery();
               $p = $q->execute();
                // Remove
                $project = $projet->find($idProjet);
                $cnx->remove($project);
                $cnx->flush();
            }
            else if($btn=='Désactiver')
            {
               // Désactiver le projet selectionner
               $q = $cnx->createQueryBuilder()
               ->update(Projets::class, 'p')
               ->set('p.etat', '?1')
               ->where('p.id = ?2')
               ->setParameter(1, 'Désactiver')
               ->setParameter(2, $idProjet)
               ->getQuery();
               $p = $q->execute();
             }
            
             return $this->redirectToRoute('projets_index');
        }
        return $this->render('projets/supprimer.html.twig',array('projets'=>$projets,
                                                                'activation'=>'Projets',
                                                                'classe'=>'Supprimer'));

       
    }
}
