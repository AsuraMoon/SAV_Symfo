<?php

namespace App\Controller;

use App\Entity\SAV;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ServiceController extends AbstractController
{
    /**
     * @Route("/service", name="service")
     */
    public function create(Request $request, ObjectManager $manager)
    {
        $sav = new SAV();

        $form = $this->createFormBuilder($sav)
                    ->add('fName')
                    ->add('lName')
                    ->add('mail')
                    ->add('phone')
                    ->add('categories')
                    ->add('numProduct')
                    ->getForm();
                    
        return $this->render('service/service.html.twig',[
            'formSAV'=>$form->createView()
        ]);
    }

    /**
     * @Route("/", name="rdv")
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
}
