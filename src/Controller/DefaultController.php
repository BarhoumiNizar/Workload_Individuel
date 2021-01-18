<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="default",methods={"GET","POST"})
     */
    public function login(Request $request): Response
    {
        if($request->isMethod('POST')){
         $email=$request->get('email');
         $mdp=$request->get('mdp');
         if($email==='tunisiawebdev@gmail.com' and $mdp==='admin')
         {
            
             return $this->redirectToRoute('projets_index');
         }
         else{
            $this->addFlash('error', 'Login/Password Incorrect');
         }
       }
        return $this->render('login.html.twig');
    }
}
