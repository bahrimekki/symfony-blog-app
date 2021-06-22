<?php

namespace App\Controller;
use App\Entity\Poste;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\RouterInterface;

class LandPageController extends AbstractController
{
    private $router;
    public function __construct(RouterInterface $router){
        $this->router=$router;
    }
    /**
     * @Route("/", name="land_page")
     */
    public function index(): Response
    {
        $repo=$this->getDoctrine()->getRepository(Poste::class);
        $postes=$repo->findAll();
        //dd($postes);
        return $this->render('land_page/index.html.twig',['postes'=>$postes]);
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
