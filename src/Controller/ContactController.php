<?php

namespace App\Controller;

use App\Entity\Demande;
use App\Form\DemandeType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;

class ContactController extends AbstractController
{
    /*#[Route('/contact', name: 'app_contact')]
    public function index(): Response
    {
        return $this->render('contact/index.html.twig', [
            'controller_name' => 'ContactController',
        ]);
    }*/

    #[Route('/contact', name: 'app_contact')]
    public function new(): Response {
        $demande = new Demande();
        /*$demande->setObjet('demande test');
        $demande->setDetailDemande('detail de ma demande');
        $demande->setEmailDemandeur('afa@mail.me');*/

        $form = $this->createForm(DemandeType::class, $demande);

        return $this->renderForm('contact/index.html.twig', [
            'form' => $form
        ]);
    }


}
