<?php

namespace App\Controller;

use App\Entity\AssociativeExperience;
use App\Entity\CurriculumVitae;
use App\Entity\EducationalExperience;
use App\Entity\Entreprise;
use App\Entity\JobOffer;
use App\Entity\ProfessionalExperience;
use App\Form\AddcertificatType;
use App\Form\AssociativeExperienceType;
use App\Form\CvType;
use App\Form\EduExpType;
use App\Form\ProExperienceType;
use App\Repository\AssociativeExperienceRepository;
use App\Repository\EducationalExperienceRepository;
use App\Repository\EntrepriseRepository;
use App\Repository\JobOfferRepository;
use App\Repository\ProfessionalExperienceRepository;
use App\Repository\StudentRepository;
use Doctrine\ORM\EntityManagerInterface;
use phpDocumentor\Reflection\Types\Array_;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\CurriculumVitaeRepository;
use Doctrine\ORM\Mapping\Id;
use Doctrine\Persistence\ManagerRegistry;


use function PHPUnit\Framework\throwException;

#[Route('/user', name: 'app_user')]
class UserController extends AbstractController
{
    #[Route('/profile', name: 'profile')]
    public function profile(Request $request): Response
    {
        $user = $this->getUser();
//        $student=$StuRepo->findOneBy(['user' => $user->getId()]);

        return $this->render('user/profile.html.twig');
    }

    #[Route('/cv', name: 'cv')]
    public function viewprofile(Request $request,
                                CurriculumVitaeRepository $cvRepo,
                                StudentRepository $StuRepo
                                ): Response
    {
        $user = $this->getUser();
        $student=$StuRepo->findOneBy(['user' => $user->getId()]);
        $cv=$cvRepo->findOneBy(['user' => $user->getId()]);
        $Edu=$cv->getEducationalExperiences();
        $Asso=$cv->getAssociativeExperiences();
        $Pro=$cv->getProfessionalExperiences();


        return $this->render('user/showcv.html.twig', [
            'student'=>$student,
            'user'=>$user,
            'cv'=> $cv,
            'edu' => $Edu,
            'pro' => $Pro,
            'asso' => $Asso
        ]);
    }


    #[Route('/addcv', name: 'add_cv')]
    public function cv(Request $request, EntityManagerInterface $em): Response
    {
        $cv = new CurriculumVitae();
        $form = $this->createForm(CvType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $form->getData();
            $cv->setLinkedinAccount($form->get('linkedinAccount')->getData());
            $certificat =  array(array($form['Nomcertificats']->getData(),$form['Descriptionducertifs']->getData()));
            $cv->setCertificates($certificat);
            $cv->setUser($this->getUser());

            $em->persist($cv);
            $em->flush();
        }
        return $this->render('user/index.html.twig', [
            'form' => $form->createView(), 'controller_name' => 'UserController',
        ]);
    }

    #[Route('/cv/addcertif', name: 'addcertificat')]
    public function addcertif(Request $request, CurriculumVitaeRepository $cvRepo, EntityManagerInterface $em): Response
    {
        $form = $this->createForm(AddcertificatType::class);
        $form->handleRequest($request);
        $user = $this->getUser();
        $cv=$cvRepo->findOneBy(['user' => $user->getId()]);
        if ($form->isSubmitted() && $form->isValid()) {
            $certificat =  array($form['NomCertificat']->getData(),$form['Description']->getData());
            $cv->updateCertificates($certificat); //Correct the function update 
            $em->persist($cv);
            $em->flush();

            return $this->redirectToRoute('app_useraddassoexp');
        }
    return $this->render('user/Addcertif.html.twig', [
        'form' => $form->createView(),
        'controller_name' => 'UserController',
    ]);
    }
    #[Route('/cv/addassoexp', name: 'addassoexp')]
    public function addassoexp(Request $request, CurriculumVitaeRepository $cvRepo, EntityManagerInterface $em): Response
    {
        $form = $this->createForm(AssociativeExperienceType::class);
        $form->handleRequest($request);
        $user = $this->getUser();
        $cv=$cvRepo->findOneBy(['user' => $user->getId()]);
        if ($form->isSubmitted() && $form->isValid()) {
            $ExpAsso=new AssociativeExperience();
            $ExpAsso->setDescription($form['description']->getData());
            $ExpAsso->setOrganization($form['organization']->getData());
            $ExpAsso->setPeriod(array($form['startDate']->getData()->format('d/m/Y'),$form['endDate']->getData()->format('d/m/Y')));
            $ExpAsso->setCurriculumVitae($cv);
            $em->persist($ExpAsso);
            $em->flush();

            return $this->redirectToRoute('app_userprofile');
        }
        return $this->render('user/AddAssoExp.html.twig', [
            'form' => $form->createView(),
            'controller_name' => 'Associative experience controller',
        ]);
    }

    #[Route('/cv/addproexp', name: 'addproexp')]
    public function addproexp(Request $request, CurriculumVitaeRepository $cvRepo, EntityManagerInterface $em): Response
    {
        $form = $this->createForm(ProExperienceType::class);
        $form->handleRequest($request);
        $user = $this->getUser();
        $cv=$cvRepo->findOneBy(['user' => $user->getId()]);
        if ($form->isSubmitted() && $form->isValid()) {
            $ExpPro= new ProfessionalExperience();
            $ExpPro->setType($form['type']->getData());
            $ExpPro->setPoste($form['poste']->getData());
            $ExpPro->setDescription($form['description']->getData());
            $ExpPro->setEntreprise($form['entreprise']->getData());
            $ExpPro->setPeriod(array($form['startDate']->getData()->format('d/m/Y'),$form['endDate']->getData()->format('d/m/Y')));
            $ExpPro->setCurriculumVitae($cv);
            $em->persist($ExpPro);
            $em->flush();

            return $this->redirectToRoute('app_userprofile');
        }
        return $this->render('user/AddProExp.html.twig', [
            'form' => $form->createView(),
            'controller_name' => 'Professional experience controller',
        ]);
    }
    #[Route('/cv/addeduexp', name: 'Addeduexp')]
    public function addeduexp(Request $request, CurriculumVitaeRepository $cvRepo, EntityManagerInterface $em): Response
    {
        $form = $this->createForm(EduExpType::class);
        $form->handleRequest($request);
        $user = $this->getUser();
        $cv=$cvRepo->findOneBy(['user' => $user->getId()]);
        if ($form->isSubmitted() && $form->isValid()) {
            $ExpEdu= new EducationalExperience();
            $ExpEdu->setUniversity($form['university']->getData());
            $ExpEdu->setDescription($form['description']->getData());
            $ExpEdu->setPeriod(array($form['startDate']->getData()->format('d/m/Y'),$form['endDate']->getData()->format('d/m/Y')));
            $ExpEdu->setCurriclumVitae($cv);
            $em->persist($ExpEdu);
            $em->flush();

            return $this->redirectToRoute('app_userprofile');
        }
        return $this->render('user/AddEduExp.html.twig', [
            'form' => $form->createView(),
            'controller_name' => 'Educational experience controller',
        ]);
    }


    public function joinofferandentreprise(EntrepriseRepository $entRepo, JobOfferRepository $jobRepo):array
    {
        $e=$entRepo->findAll();
        $j=$jobRepo->findAll();

        $res=[];

        for($i=0; $i<count($e) ; $i++)
        {
            $ent=new entreprise();
            $ent= $e[$i];
            $offer=$ent->getJobOffers();
            $aux=array_merge($ent,$offer);
            array_push($res,$aux);
        }
        return $res;
    }

    #[Route('/catalogue', name: 'profile')]
    public function showcatalogue(Request $request, EntrepriseRepository $entRepo, JobOfferRepository $jobRepo): Response
    {

        return $this->render('user/catalogue.html.twig',
            [
                'offers' => $jobRepo->joinentreprise(),
            ]);
    }
    #[Route('/catalogue/{id}', name: 'offer')]
    public function offer(JobOffer $jobOffer): Response
    {
        $ent=$jobOffer->getEntreprise();

        return $this->render('user/offer.html.twig',
            [
                'offer' => $jobOffer,
                'ent'=> $ent,
            ]);
    }
}