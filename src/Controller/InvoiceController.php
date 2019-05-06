<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Knp\Snappy\Pdf;


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
         $year = date("Y");
         $code = $this->getDoctrine()
            ->getRepository(Invoice::class)
            ->assignCode($year,$workgroup);
         $invoice->setCode($code);
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

    /**
    * @Route("/invoice/view/all", name="invoice_view_all")
    */
    public function invoiceViewAll()
    {
       $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
       $user_workgroup = $this->getUser()->getWorkgroup();
       $invoices = $this->getDoctrine()
            ->getRepository(Invoice::class)
            ->findBy(
                      ['workgroup' => $user_workgroup],
                      ['created' => 'DESC']
                  );

         if (!$invoices) {
            $invoices = NULL;
         }
         return $this->render('invoice_view_all.html.twig', array(
            'invoices' => $invoices
         ));
    }

    /**
      * @Route("/invoice-generate/{id}", name="invoice_generate", requirements={"id"="\d+"})
      */
      public function invoiceGenerate(Pdf $snappy,  int $id)
      {
        $invoice = $this->getDoctrine()
           ->getRepository(Invoice::class)
           ->find($id);

        if (!$invoice) {
           $invoice = NULL;
        }
        //$emisor = $this->getUser()->getWorkgroup();
        $emisor = $invoice->getWorkgroup();
        
        if ($emisor == "GROUP_JAVI")
        {
        $html = $this->renderView('invoice_javi.html.twig', array(
           'invoice' => $invoice
        ));
        }
        elseif ($emisor == "GRUPO_DP") {
          $html = $this->renderView('invoice_dp.html.twig', array(
             'invoice' => $invoice
          ));
        }
    $filename = 'Factura - '. $invoice->getId();
        return new Response(
          $snappy->getOutputFromHtml($html),200,array(
              'images' => true,
             'Content-Type'          => 'application/pdf',
             'Encoding' => 'utf-8',
             'Content-Disposition'   => 'attachment; filename="'.$filename.'.pdf"'
           )
         );
      // return $this->render('consentimiento.html.twig');
      }




}
