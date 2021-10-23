<?php

namespace App\Controller;

use App\Entity\SAV;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ServiceController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function create(Request $request, EntityManagerInterface $manager)
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
                    ->add('mail',TextType::class, [
                        'attr'=> [
                            'placeholder' => 'xxx@xxx.fr'
                        ]
                    ])
                    ->add('phone',TextType::class, [
                        'attr'=> [
                            'placeholder' => '01 23 45 67 89'
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
                            'placeholder' => '1234567890'
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
                $manager->persist($sav);
                $manager->flush();
                
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
