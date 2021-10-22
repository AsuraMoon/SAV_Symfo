<?php

namespace App\Controller;

use App\Entity\SAV;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class ServiceController extends AbstractController
{
    /**
     * @Route("/", name="service")
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
     * @Route("/service", name="rdv")
     */
    public function index()
    {            
        $repo = $this->getDoctrine()->getRepository(SAV::class);
        $retours = $repo->findAll();
        dump($retours);

        return $this->render('service/service.html.twig',[
            "retours" => $retours
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
