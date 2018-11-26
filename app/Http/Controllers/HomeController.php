<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Model\Invoice;
use Illuminate\Support\Facades\DB;
use Barryvdh\Snappy\Facades\SnappyPdf;
use PDF;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {    
        return view('admin_page/home');
    }

        /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function loadInvoices(Request $request)
    {
        $invoice;
        if ($request->search_invoice != '')
        {
            $invoice_no = strtoupper(trim($request->search_invoice));
            $invoice =  DB::table('invoice')
                        ->where('invoicenumber','like','%'.$invoice_no.'%')
                        ->paginate(50);
        } else {
            $invoice = DB::table('invoice')->paginate(50);
        }
        
        return view('admin_page/invoices',compact('invoice'));
    }


    function generatePdf() {
        $data = [
            'foo' => 'bar'
        ];
        

         $chapters = DB::table('chapter')
        ->paginate(20);

        $pdf = SnappyPdf::loadView('admin_page/pdf',compact('chapters'));
        //return view('admin_page/chapter',compact('chapters'));
        //return PDF::loadView('pdf.invoice', $data);
        return $pdf->stream('invoice.pdf');
    }

     function generatePdfOld() {
        $data = [
            'foo' => 'bar'
        ];
        

         $chapters = DB::table('chapter')
        ->paginate(20);

        $pdf = PDF::loadView('admin_page/pdf',compact('chapters'));
        //return view('admin_page/chapter',compact('chapters'));


        return $pdf->stream('document.pdf');
    }

}
