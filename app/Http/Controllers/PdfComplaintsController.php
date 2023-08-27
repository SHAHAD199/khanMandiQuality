<?php

namespace App\Http\Controllers;

use App\Services\Orders\PdfOrderService;
use Illuminate\Http\Request;

class PdfComplaintsController extends Controller
{
    private $pdforderService;
    public function __construct(PdfOrderService $pdfOrderService)
    {
        $this->pdforderService = $pdfOrderService;
    }
    public function create_pdf(Request $request)
    {
       return $this->pdforderService->create_pdf($request);
    }
}
