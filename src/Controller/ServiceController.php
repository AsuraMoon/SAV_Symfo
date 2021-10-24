<?php

namespace App\Controller;

use App\Service\Mailer;
use App\Entity\SAV;
use Symfony\Component\Mime\Email;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ServiceController extends AbstractController
{
    public function generateToken(){
        return rtrim(strtr(base64_encode(random_bytes( 32 )),'+/','-_'),'=');
    }
    
    /**
     * @Route("/", name="index")
     */
    public function create(Request $request, EntityManagerInterface $manager, Mailer $mailer)
    {
        dump($request);
        $sav = new SAV();

        $form = $this->createFormBuilder($sav)
                    ->add('fName', TextType::class, [
                        'attr'=> [
                            'placeholder' => 'Prénom'
                        ]
                    ])
                    ->add('lName',TextType::class, [
                        'attr'=> [
                            'placeholder' => 'Nom'
                        ]
                    ])
                    ->add('mail',EmailType::class, [
                        'attr'=> [
                            'placeholder' => 'xxx@xxx.fr'
                        ]
                    ])
                    ->add('phone',TextType::class, [
                        'attr'=> [
                            'placeholder' => '+33 (1) / 01 23 45 67 89'
                        ]
                    ])
                    ->add('categories', ChoiceType::class,[
                        'placeholder' => 'Choisir une catégories',
                        'choices' => [
                            'Informatique' => 'Informatique',
                            'Gros Electroménager'=>'Gros Electroménager',
                            'Electroménager'=>'Electroménager',
                            'Maison'=>'Maison',
                            'Divers'=>'Divers',
                        ]
                    ])
                    ->add('numProduct',TextType::class, [
                        'attr'=> [
                            'placeholder' => '1B3d5f7h9J'
                        ]
                    ])
                    ->add('date',DateType::class,[
                        'widget' => 'single_text',
                    ])
                    ->add('dayMoment',ChoiceType::class, [
                        'placeholder' => 'Choisir un moment de la journée',
                        'choices' => [
                            'Matin 7h-11h' => 'Matin',
                            'Midi 11h-15h'=>'Midi',
                            'Soir 15h-19h'=>'Soir',
                        ]
                    ])
                    ->getForm();
            $form->handleRequest($request);

            dump($sav);

            if($form->isSubmitted()&& $form->isValid()){
                $sav->setToken($this->generateToken());
                $manager->persist($sav);
                $manager->flush();
                $mailer->sendMail($sav->getMail(),$sav->getToken());
                dump($sav);
                
                return $this->redirectToRoute('recap');
            }
                    
        return $this->render('service/index.html.twig',[
            'formSAV'=>$form->createView()
        ]);
    }

    /**
     * @Route("/service", name="service")
     */
    public function index()
    {            
        $repo = $this->getDoctrine()->getRepository(SAV::class)
                                    ->getTodayDate();
        dump($repo);
        return $this->render('service/service.html.twig',[
            "retours" => $repo
        ]);
    }

    /**
     * @Route("/recap", name="recap")
     */
    public function view()
    {            
        return $this->render('service/recap.html.twig');
    }

}
