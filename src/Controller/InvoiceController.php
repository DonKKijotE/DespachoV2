<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;


use App\Form\InvoiceType;

use App\Entity\Expedient;
use App\Entity\Invoice;
use App\Entity\InvoiceConcept;



class InvoiceController extends AbstractController
{

   /**
    * @Route("/invoice/create/{expedient_id}", name="invoice_create", requirements={"expedient_id"="\d+"})
    */
    public function invoiceCreate(Request $request, $expedient_id)
    {

      $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
      $invoice = new Invoice();

      /* $invoiceConcept1 = new InvoiceConcept();
      $invoiceConcept1->setConcept("Informe Pascual");
      $invoiceConcept1->setAmount("1500.00");
      $invoice->addInvoiceConcept($invoiceConcept1);

      $invoiceConcept2 = new InvoiceConcept();
      $invoiceConcept2->setConcept("Honorarios Gregorio");
      $invoiceConcept2->setAmount("150.00");
      $invoice->addInvoiceConcept($invoiceConcept2); */



      $form = $this->createForm(InvoiceType::class, $invoice);

      $expedient = $this->getDoctrine()
         ->getRepository(Expedient::class)
         ->find($expedient_id);

         if (!$expedient) {
          throw $this->createNotFoundException('The expedient does not exist');
        }

      $form->handleRequest($request);

      if ($form->isSubmitted() && $form->isValid()) {
         $invoice = $form->getData();
         $workgroup = $this->getUser()->getWorkgroup();
         $invoice->setWorkgroup($workgroup);
         $invoice->setExpedient($expedient);
         $em = $this->getDoctrine()->getManager();
         $em->persist($invoice);
         $em->flush();
         return $this->redirectToRoute('home');
         //dump($expedient);
         //return New Response("<body>Expedient form sent :)</body>");
      }

      /* return $this->render('expedient_create.html.twig', array(
         'form' => $form->createView()
      )); */




        return $this->render('invoice_create.html.twig', array(
         'form' => $form->createView(),
         'expedient_id' => $expedient_id,
      ));

      //return New Response("<body>Hola, quieres crear un expediente.</body>");
    }




}
