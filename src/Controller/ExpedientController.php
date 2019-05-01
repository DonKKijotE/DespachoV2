<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;


use App\Form\ExpedientType;

use App\Entity\Expedient;
use App\Entity\Client;



class ExpedientController extends AbstractController
{

   /**
    * @Route("/expedient/create/{client_id}", name="expedient_create", requirements={"client_id"="\d+"})
    */
    public function expedientCreate(Request $request, $client_id)
    {

      $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
      $expedient = new Expedient();
      $form = $this->createForm(ExpedientType::class, $expedient);

      $client = $this->getDoctrine()
         ->getRepository(Client::class)
         ->find($client_id);

         if (!$client) {
          throw $this->createNotFoundException('The client does not exist');
        }

      $form->handleRequest($request);

      if ($form->isSubmitted() && $form->isValid()) {
         $expedient = $form->getData();
         $workgroup = $this->getUser()->getWorkgroup();
         $expedient->setWorkgroup($workgroup);
         $expedient->setClient($client);
         $em = $this->getDoctrine()->getManager();
         $em->persist($expedient);
         $em->flush();
         return $this->redirectToRoute('home');
         //dump($expedient);
         //return New Response("<body>Expedient form sent :)</body>");
      }

      /* return $this->render('expedient_create.html.twig', array(
         'form' => $form->createView()
      )); */




        return $this->render('expedient_create.html.twig', array(
         'form' => $form->createView(),
         'client_id' => $client_id
      ));

      //return New Response("<body>Hola, quieres crear un expediente.</body>");
    }

    /**
     * @Route("/expedient/view/{id}", name="expedient_view_one", requirements={"id"="\d+"})
     */
     public function expedientViewOne($id)
     {
        $expedient = $this->getDoctrine()
           ->getRepository(Expedient::class)
           ->find($id);

        if (!$expedient) {
           $expedient = NULL;
        }
          return $this->render('expedient_view_one.html.twig', array(
           'expedient' => $expedient
        ));
     }


}
