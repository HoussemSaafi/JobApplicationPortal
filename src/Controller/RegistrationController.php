<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Student;
use App\Form\RegistrationType;
use App\Service\FileUploader;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class RegistrationController extends AbstractController
{
    #[Route('/registration', name: 'app_registration')]
    public function index(Request $request, EntityManagerInterface $em, UserPasswordHasherInterface $userPasswordHasher,FileUploader $fileUploader): Response
    {
        $user=new User();
        $student=new Student();
        $form = $this->createForm(RegistrationType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {


            $user->setRoles(['ROLE_ADMIN']);
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('password')->getData()
                ));
                
            if ($form['img']->getData()) {
                /** @var UploadedFile $Profileimg */
                $Profileimg = $form->get('img')->getData();
                $ProfileimgName = $fileUploader->upload($Profileimg);
                $student->setImg($ProfileimgName);
            } else {
                $student->setImg("default.jpg");
            }

            $user -> setEmail($form->get('email')->getData());
            $em->persist($user);
            $em->flush();

            $student -> setFirstName($form->get('firstName')->getData());
            $student -> setLastName($form->get('lastName')->getData());
            $student -> setAddress($form->get('address')->getData());
            $student -> setJe($form->get('je')->getData());
            $student ->setUser($user);
            $em->persist($student);
            $em->flush();

            return $this->redirectToRoute('app_login');
        }

        return $this->render('registration/index.html.twig', [
            'form' => $form->createView(),'controller_name' => 'RegistrationController'
        ]);
    }
}
