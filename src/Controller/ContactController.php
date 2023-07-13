<?php

namespace App\Controller;

use App\Entity\Demande;
use App\Form\DemandeType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;

class ContactController extends AbstractController
{
    #[Route('/index', name: 'app_index')]
    public function index(): Response
    {
        return $this->render('contact/index.html.twig', [
            'controller_name' => 'ContactController',
        ]);
    }

    #[Route('/contact', name: 'app_contact')]
    public function new(Request $request, ManagerRegistry $doctrine, MailerInterface $mailer): Response {
        
        $demande = new Demande();
        /*$demande->setNom('DUPONT');
        $demande->setPrenom('Jean');
        $demande->setObjet('demande test');
        $demande->setDetailDemande('detail de ma demande');
        $demande->setEmailDemandeur('afa@mail.me');*/

        $form = $this->createForm(DemandeType::class, $demande);

        $form->handleRequest($request);
        if( $form->isSubmitted() && $form->isValid() ) {
            $demande = $form->getData();

            $nom = $demande->getNom();
            $prenom = $demande->getPrenom();
            $demandeur = $demande->getEmailDemandeur();
            $objet = $demande->getObjet();
            $detail = $demande->getDetailDemande();

            // save in bdd
            $em = $doctrine->getManager(); 
            $em->persist($demande);
            $em->flush();

            // creation email
            $email = (new TemplatedEmail())
                ->from($demandeur)
                ->to(new Address('contact@example.fr', 'mailtrap'))
                ->subject('Demande envoyée depuis formulaire : '.$objet)
                ->htmlTemplate('emails/contact.html.twig')
                ->context([
                    'identite' => $prenom.' '.strtoupper($nom),
                    'objet' => $objet,
                    'demande' => $detail,
                    'email_demandeur' => $demandeur
                ]);
            //dump($email);
            // send email
            $mailer->send($email);

            return $this->redirectToRoute('demande_success');
        }

        return $this->renderForm('contact/contact.html.twig', [
            'form' => $form
        ]);
    }

    #[Route('/contact/send_ok', name: 'demande_success')]
    public function success(): Response {

        return $this->render('contact/success.html.twig', [
            'message' => 'Votre demande a bien été envoyée !'
        ]);
    }





}
