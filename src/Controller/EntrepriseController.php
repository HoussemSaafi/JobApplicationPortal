<?php

namespace App\Controller;

use App\Entity\JobOffer;
use App\Form\CvType;
use App\Form\JobOfferType;
use App\Repository\EntrepriseRepository;
use App\Service\FileUploader;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/entreprise', name: 'profile_entreprise')]
class EntrepriseController extends AbstractController
{

    #[Route('/', name: 'home_entreprise')]
    public function index(): Response
    {


        return $this->render('entreprise/index.html.twig', [
            'controller_name' => 'EntrepriseController',
        ]);
    }

    #[Route('/profile', name: 'profile_entreprise')]
    public function profile(): Response
    {


        return $this->render('entreprise/index.html.twig',
            [
                'entreprise' => $this->getUser(),
                'controller_name' => 'EntrepriseController',
                ]
        );
    }
    #[Route('/addjob', name: 'addjob')]
    public function addjob(Request $request, EntityManagerInterface $em, EntrepriseRepository $EntRepo, FileUploader $fileUploader): Response
    {
        $job=new JobOffer();
        $form = $this->createForm(JobOfferType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $e=$EntRepo->findOneBy(['user' => $this->getUser()->getId()]);
            $job=$form->getData();
            $job->setEntreprise($e);
            /** @var UploadedFile $catalogue */
            $catalogue = $form->get('catalogue')->getData();
            $CatalogueName = $fileUploader->upload($catalogue);
            $job->setCatalogue($CatalogueName);
            $em->persist($job);
            $em->flush();
        }

        return $this->render('entreprise/addJobOffer.html.twig', [
            'form' => $form->createView(),
            'controller_name' => 'EntrepriseController'
        ]);
    }


}
