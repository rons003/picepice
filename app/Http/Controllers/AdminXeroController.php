<?php

namespace App\Http\Controllers;

use App\Http\Model\User;
use App\Http\Model\Member;
use App\Http\Model\Life;
use App\Http\Model\Chapter;
use App\Http\Model\Payment;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use XeroPHP\Application\PrivateApplication;
use XeroPHP\Models\Accounting\Invoice;
use XeroPHP\Models\Accounting\Invoice\LineItem;
use Illuminate\Support\Facades\Log;
use XeroPHP\Models\Accounting\Contact;
use Illuminate\Support\Facades\DB;


class AdminXeroController extends Controller
{

   
   public function createInvoice()
   {
        $xero = new PrivateApplication(config('xero.config'));
        $newInvoice = new Invoice();
        $newInvoice->setType(Invoice::INVOICE_TYPE_ACCREC);
        $newInvoice->setContact();
   }

   public function createContact()
   {
        $xero = new PrivateApplication(config('xero.config'));
        $contact = new Contact();      
        $contact->setFirstName('Christian');
        $contact->setLastName('Calabia');
        $contact->setEmail('xian.calabia@gmail.com');
        $contact->setContactStatus(Contact::CONTACT_STATUS_ACTIVE);
        //$xero->saveAll()
   }

   public function loadXeroInvoicePDF($id)
   {
        $xero = new PrivateApplication(config('xero.config'));
        $invoice = $xero->loadByGUID('Accounting\\Invoice', $id);
        return response($invoice->getPDF())
            ->header('Content-Type', "application/pdf");
   }


   public function loadInvoices($id)
   {
    
    $invoiceHistory = [];
    
    $xero = new PrivateApplication(config('xero.config'));
    $invoices = $xero->load('Accounting\\Invoice')
    ->where('Contact.ContactID',$id)
    //->where('page=1')
    ->execute();

    foreach ($invoices as $invoice) {
         //Log::info('Invoice ID: '. $invoice->contactid . $invoice->getName());
        $invoiceLineItems = [];

        if ($invoice->getLineItems() != NULL)
        {
            foreach ($invoice->getLineItems() as $li) {
                array_push($invoiceLineItems, ['type'=>$li->getDescription(),
                ]);
            }
        }


        array_push($invoiceHistory, ['type'=>$invoice->getType(),
            'total'=>'PHP '.number_format($invoice->getTotal()),
            'duedate'=>date_format($invoice->getDueDate(), 'm/d/y'),
            'status'=>$invoice->getStatus(),
            'name'=>$invoice->getContact()->getName(),
            'invoicenumber'=>$invoice->getInvoiceNumber(),
            'invoiceLineItems'=>$invoiceLineItems,
        ]);

 

    }

   return json_encode(array('result' => 'success', 'data' => $invoiceHistory));

}

}