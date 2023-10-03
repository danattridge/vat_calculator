<?php
// src/Controller/PageController.php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class PageController extends AbstractController
{
    #[Route('/',name:'home')]
    public function index(): Response
    {
        $title = 'Welcome to my VAT Calculator app';
        return $this->render('pages/home.html.twig', [
            'title' => $title,
        ]);
    }

    #[Route('/about',name:'about')]
    public function about(): Response
    {
        $title = 'About';
        return $this->render('pages/about.html.twig', [
            'title' => $title,
        ]);
    }
}