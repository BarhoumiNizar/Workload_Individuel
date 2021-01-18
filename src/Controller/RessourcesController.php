<?php

namespace App\Controller;

use App\Entity\Ressources;
use App\Form\RessourcesForm;
use App\Entity\AffectationCompetences;
use App\Form\AffectationCompetenceForm;
use App\Repository\RessourcesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\AffectationRessourcesRepository;
/**
 * @Route("/ressources")
 */
class RessourcesController extends AbstractController
{
    /**
     * @Route("/", name="ressources_index", methods={"GET"})
     */
    public function index(RessourcesRepository $ressourcesRepository): Response
    {
        return $this->render('ressources/index.html.twig', [
            'ressources' => $ressourcesRepository->findAll(),
            'activation'=>'Ressources',
            'classe'=>'Afficher'
        ]);
    }
    
    /**
     * @Route("/Add", name="ressources_new", methods={"GET","POST"})
     */
    public function Add(Request $request,RessourcesRepository $ressourcesRepository): Response
    {
        $niveaux=null;
        $competences=null;
        $idressource=null;
        $ressource = new Ressources();
        $form = $this->createForm(RessourcesForm::class, $ressource);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            //Si la combinaison nom & prénom et compétence existe déjà dans BD
           $verif=$ressourcesRepository->findBy(['nom_prenom'=>$ressource->getNomPrenom(),'competences'=>$ressource->getCompetences()]);
           
           if(!empty($verif))
           {
            $this->addFlash('verificationRessource', 'Ressource '.$ressource->getNomPrenom().' existe déja');
           }
           else{
           
            $entityManager = $this->getDoctrine()->getManager();
            // Pour récupérer les compétences sélectionner
            $competences=$request->get('competence');
            $ressource->setCompetences($competences);
            $entityManager->persist($ressource);
            $entityManager->flush();
           $idressource=$ressource->getId();
            
             return $this->render('ressources/Ajouter.html.twig', [
                'ressource' => $ressource,
                'form' => $form->createView(),
                'idressource' => $idressource,
                'competences' => $competences,
                'niveaux' => 'ok',
                'activation'=>'Ressources',
                'classe'=>'Ajout Niveaux Compétence'
            ]);

           // return $this->redirectToRoute('ressources_index');
           }
        }

        return $this->render('ressources/Ajouter.html.twig', [
            'ressource' => $ressource,
            'form' => $form->createView(),
            'niveaux' => $niveaux,
            'competences' => $competences,
            'activation'=>'Ressources',
            'classe'=>'Ajout'
        ]);
    }

 
    /**
     * @Route("/delete", name="ressources_delete", methods={"GET","POST"})
     */
    public function Suppression(Request $request, RessourcesRepository $ressource,AffectationRessourcesRepository $affectationRepository): Response
    {  
        $ressources=$ressource->findAll();  
       if($request->get('ressource')!=null){
        $cnx=$this->getDoctrine()->getManager();
            $id_ressource=$request->get('ressource');
            // Toutes les affectations liées à la ressource  seront  effacées
            $affectationRessources = $affectationRepository->findBy(['Ressource'=>$id_ressource]);
            foreach($affectationRessources  as $cle){
                $affectation=$affectationRepository->find($cle->getId());
                $cnx->remove($affectation); 

            }
           // echo '<h1>'.count($affectationRessources).'</h1>';
            //echo '<hr>';
            $ressource = $ressource->find($id_ressource);
            //var_dump($ressource);
            $cnx->remove($ressource);
            $cnx->flush();
        return $this->redirectToRoute('ressources_delete');
       }
       return $this->render('ressources/delete.html.twig',[
           'ressources'=>$ressources,'activation'=>'Ressources','classe'=>'Delete']);

    }

    //	Affectation d’une compétence 

      // Get template Affectation
         /**
     * @Route("/AffecterCompétence", name="ressources_Affecter", methods={"GET"})
     */
    public function Affecter(RessourcesRepository $ressourcesRepository): Response
    {
        return $this->render('ressources/index.html.twig', [
            'ressources' => $ressourcesRepository->findAll(),
            'activation'=>'Ressources',
            'classe'=>'Affectation'
        ]);
    }

    /**
     * @Route("/AffecterCompetence/{id}", name="ressources_AffecterCompetence", methods={"GET","POST"})
     */
    public function AffecterCompetence(Request $request, Ressources $ressource): Response
    {
        $form = $this->createForm(RessourcesForm::class, $ressource);
        $form->handleRequest($request);
        $niveaux=null;
        $competences=null;
        $idressource=null;
        if ($form->isSubmitted()) {
            $competences=$request->get('competence');
            // Autres Compétences
            $autre=$request->get('autre_competence');
            if(!empty($autre)){
            $autres=explode(' ',$autre);
             //echo 'Nb Cmpt= '.count($autres);
             //var_dump($autres);
             for($i=0;$i<count($autres);$i++){
               array_push($competences,$autres[$i]);
              }
            }
            //var_dump($competences);
           // Add nouveau compétence
           $ressource->setCompetences($competences);
            $this->getDoctrine()->getManager()->flush();
            /*******Ajout Autres Niveaux de compétences****** */ 
             return $this->render('ressources/AffectationCompetence.html.twig', [
                'ressource' => $ressource,
                'form' => $form->createView(),
                'niveaux' => 'ok',
                'competences' => $competences,
                'activation'=>'Ressources',
                'classe'=>'Affecter Niveaux Compétence'
            ]);
            /*********Fin Ajout Autre niveaux********* */
        }

        return $this->render('ressources/AffectationCompetence.html.twig', [
            'ressource' => $ressource,
            'form' => $form->createView(),
            'niveaux' => $niveaux,
            'competences' => $competences,
            'activation'=>'Ressources',
            'classe'=>'Affecter Compétence'
        ]);
    }


     /**
     * @Route("/Affectation", name="ressources_Affectation", methods={"GET","POST"})
     */
    public function AffectationCompetence(Request $request)
    {

        $affectationCompetence = new AffectationCompetences();
        $form = $this->createForm(AffectationCompetenceForm::class, $affectationCompetence);
        $form->handleRequest($request);
        if($form->isSubmitted()){
            $ressource=$affectationCompetence->getRessource()->getId();
            // vérification si le ressource à des compétences ou non
               // si oui on va faire update
            // si le ressource n'a pas des compétences on va 
           /* $cnx=$this->getDoctrine()->getManager();
            $cnx->persist($affectationCompetence);
            $cnx->flush();*/
        }
        return $this->render('ressources/affectation.html.twig',[
            'form'=>$form->createView(),
            'activation'=>'Ressources',
            'classe'=>'Affectation']);
  
    }


    // Add Niveaux
      /**
     * @Route("/Niveaux", name="ressources_niveaux", methods={"POST"})
     */
    public function Niveaux(Request $request,RessourcesRepository $ressourcesRepository): Response
    {
        $niveaux=$request->get('niveaux');
        $idressource=$request->get('idressource');
        $ressource=$ressourcesRepository->find($idressource);
        $ressource->setNiveau($niveaux);
        $cnx=$this->getDoctrine()->getManager();
        $cnx->persist($ressource);
        $cnx->flush();
       /* var_dump($niveaux);
       for($i=0;$i<count($niveaux);$i++){
        echo '<h1>Resource : '.$niveaux[$i].'</h1>';
        }*/
        
        return $this->redirectToRoute('ressources_index');
    }

    
}
