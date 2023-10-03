<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Sale;
use App\Entity\SalesForm;
use App\Form\Type\SaleType;
use Doctrine\ORM\EntityManagerInterface; 
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\HttpFoundation\Request;


class SalesController extends AbstractController
{
    private $_entityManager;

    //set VAT rate of 20%
    const VAT_RATE = 20.00;

    function __construct(
        EntityManagerInterface $entityManager
    )
    {
        $this->_entityManager = $entityManager;
    }

    #[Route('/sales', name: 'app_sales')]
    public function index(): Response
    {
        return $this->render('pages/sales.html.twig', [
            'controller_name' => 'SalesController',
        ]);
    }

    #[Route('/sales/new', name: 'app_sales_new')]
    public function newAction(Request $request) {  
        $sale = new SalesForm();
        $form = $this->createFormBuilder($sale)
            ->add('productName', TextType::class, array('label' => 'Product Name'))
            ->add('productValue', TextType::class, array('label' => 'Product Value','required' => true, 'constraints' => array(new Regex("/^([1-9][0-9]*|0)(\.[0-9]{2})?$/"))))
            ->add('productQty', TextType::class, array('label' => 'Product Qty','required' => true, 'constraints' => array(new Regex("/^\d+$/"))))
            ->add('customerName', TextType::class, array('label' => 'Customer Name','required' => false)) 
            ->add('customerEmail', TextType::class, array('label' => 'Customer Email','required' => false))
            ->add('saleRef', TextType::class, array('label' => 'Sale Ref.','required' => false))
            ->add('save', SubmitType::class, ['label' => 'Create New Sale', 'attr' => array('class' => 'button')])
            ->getForm(); 


        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // $form->getData() holds the submitted values
            // but, the original `$task` variable has also been updated
            $sale = $form->getData();

            if ($this->saveSale($sale)){
                return $this->redirectToRoute('app_sales_success');
            }
        }

        $title = 'New Sale';

        return $this->render('pages/sales.html.twig', array(
            'title' => $title,
            'form' => $form->createView(),
        )); 
    }

    #[Route('/sales/success', name: 'app_sales_success')]
    public function taskSuccess() {
        //$request = Request::createFromGlobals();
        return $this->render('pages/sales.html.twig', array( 
            'success' => true
        )); 
    }

    protected function saveSale($sale) :bool
    {   
        $totalValueExcVAT = $sale->getProductValue() * $sale->getProductQty();
        $vatAmount = $totalValueExcVAT * self::VAT_RATE / 100;
        $totalValueIncVAT = $totalValueExcVAT + $vatAmount;

        //save sale to db
        $currentDatetime = new \DateTimeImmutable;

        $saleRecord = new Sale();
        $saleRecord->setProductName($sale->getProductName());
        $saleRecord->setProductValue($sale->getProductValue());
        $saleRecord->setProductQty($sale->getProductQty());
        $saleRecord->setVatRate(self::VAT_RATE);
        $saleRecord->setVatAmount($vatAmount);
        $saleRecord->setTotalValueExcVat($totalValueExcVAT);
        $saleRecord->setTotalValueIncVat($totalValueIncVAT);
        $saleRecord->setCustomerName($sale->getCustomerName());
        $saleRecord->setCustomerEmail($sale->getCustomerEmail());
        $saleRecord->setSaleRef($sale->getSaleRef());
        $saleRecord->setCreatedAt($currentDatetime);
        $saleRecord->setUpdatedAt($currentDatetime);

        // tell Doctrine you want to (eventually) save the Product (no queries yet)
        $this->_entityManager->persist($saleRecord);
        try {
            $this->_entityManager->flush();
            return true;
        } catch (\exception $e) {
            $result['data'] = $e->getmessage(); // the exact message of the exception thrown during insert
            return false;
        }
    }

    #[Route('/sales/history', name: 'app_sales_history')]
    public function getSalesHistory()
    {
        $title = 'Sales History';
        $salesData = $this->getSalesData();
        
        return $this->render('pages/history.html.twig', array( 
            'title' => $title,
            'sales_history' => $salesData
        )); 
    }

    #[Route('/sales/download', name: 'app_sales_download')]
    public function downloadCsv()
    {
        $salesData = $this->getSalesData();

        $fp = fopen('php://output', 'w');

        $headers = ['ID', 'Product Name', 'Price Per Unit', 'Product Qty', 'VAT Rate', 'VAT Amount', 'Total Value Exc. VAT', 'Total Value Inc. VAT','Customer','Customer Email','Created At'];

        fputcsv($fp, $headers);
        foreach ($salesData as $fields) {
            fputcsv($fp, $fields);
        }

        $currentDatetime = new \DateTimeImmutable;
        $filename = 'sales_list_' . $currentDatetime->format("dmy_His") . '.csv';

        $response = new Response();
        $response->headers->set('Content-Type', 'text/csv');
        $response->headers->set('Content-Disposition', 'attachment; filename="'.$filename.'"');

        return $response;
    }

    #[Route('/sales/delete', name: 'app_sales_delete')]
    public function deleteSalesRecords()
    {
        $sql = 'DELETE FROM `sale`';
        $stmt = $this->_entityManager->getConnection()->prepare($sql);
        $stmt->execute();
        
        $title = 'Welcome to my VAT Calculator app';
        return $this->render('pages/home.html.twig', [
            'title' => $title,
        ]);
    }

    private function getSalesData()
    {
        $salesData = [];
        $repository = $this->_entityManager->getRepository(Sale::class);
        $salesHistory = $repository->findAll();
        foreach ($salesHistory as $sale){
            $salesData[] = ['saleId' => $sale->getId(),
                            'productName' => $sale->getProductName(),
                            'pricePerUnit' => number_format($sale->getProductValue(), 2),
                            'productQty' => $sale->getProductQty(),
                            'vatRate' => number_format($sale->getVatRate(), 2),
                            'vatAmount' => number_format($sale->getVatAmount(), 2),
                            'totalValueExcVat' => number_format($sale->getTotalValueExcVat(), 2),
                            'totalValueIncVat' => number_format($sale->getTotalValueIncVat(), 2),
                            'customerName' => $sale->getCustomerName(),
                            'customerEmail' => $sale->getCustomerEmail(),
                            'createdAt' => $sale->getCreatedAt()->format("d-m-Y H:i:s")];
        }
        return $salesData;
    }

}


