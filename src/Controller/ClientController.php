<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use App\Form\ClientType;

use App\Entity\Client;

class ClientController extends AbstractController
{

   /**
    * @Route("/client/create", name="client_create")
    */
    public function clientCreate(Request $request)
    {

      $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
      $client = new Client();
      $form = $this->createForm(ClientType::class, $client);

      $form->handleRequest($request);
      if ($form->isSubmitted() && $form->isValid()) {
         $client = $form->getData();
         $workgroup = $this->getUser()->getWorkgroup();
         $client->setWorkgroup($workgroup);
         $em = $this->getDoctrine()->getManager();
         $em->persist($client);
         $em->flush();
         return $this->redirectToRoute('home');
         //dump($client);
         //return New Response("<body>Form sent :)</body>");
      }

      return $this->render('client_create.html.twig', array(
         'form' => $form->createView()
      ));


      //return New Response("<body>Hola, quieres crear un cliente :)</body>");
    }

    /**
     * @Route("/client/view/all", name="client_view_all")
     */
     public function clientViewAll()
     {

         $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

         $user_workgroup = $this->getUser()->getWorkgroup();
         $clients = $this->getDoctrine()
              ->getRepository(Client::class)
              ->findBy(
                      ['workgroup' => $user_workgroup],
                      ['name' => 'ASC']
                      );
           if (!$clients) {
              $clients = NULL;
           }

           return $this->render('client_view_all.html.twig', array(
              'clients' => $clients
           ));


     }

     /**
      * @Route("/client/view/{id}", name="client_view_one", requirements={"id"="\d+"})
      */
      public function clientViewOne($id)
      {
         $client = $this->getDoctrine()
            ->getRepository(Client::class)
            ->find($id);

         if (!$client) {
            $client = NULL;
         }
           return $this->render('client_view_one.html.twig', array(
            'client' => $client
         ));
      }


}
