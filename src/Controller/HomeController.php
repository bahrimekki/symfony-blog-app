<?php

namespace App\Controller;

use App\Entity\Poste;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\RouterInterface;

class HomeController extends AbstractController
{
    private $router;
    public function __construct(RouterInterface $router){
        $this->router=$router;
    }
    /**
     * @Route("/home", name="home")
     */
    public function index(AuthenticationUtils $authenticationUtils): Response
    {
        $repo=$this->getDoctrine()->getRepository(Poste::class);
        $lastUsername = $authenticationUtils->getLastUsername();
        if(!$lastUsername){
            return new RedirectResponse(
                $this->router->generate("app_login")
            );
        };
        $postesforuser=[];
        $allpostes=$repo->findAll();
        $length=count($allpostes);
        for ($i=0; $i < $length ; $i++) { 
            $newpost=$allpostes[$i]->getAuthor()->getEmail();

            if($newpost==$lastUsername){$postesforuser[]=$allpostes[$i];}
            
        }
        //  dd($postesforuser);

        return $this->render('home/index.html.twig', ['postesforuser'=>$postesforuser]);
    }

    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout()
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
   
    /**
     * @Route("/poste/{id}", name="poste_page")
     */
    public function showPoste($id): Response
    {
        $repo=$this->getDoctrine()->getRepository(Poste::class);
        $poste=$repo->find($id);
        // dd($poste);
        if(!$poste){
            return new RedirectResponse(
                $this->router->generate("land_page")
            );
        };
        //dd($postes);
        return $this->render('poste_page/index.html.twig',['poste'=>$poste]);
    }
}
