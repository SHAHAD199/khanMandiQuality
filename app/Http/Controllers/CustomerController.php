<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Order;
use App\Services\Customers\{
   GetCustomerService, PostCustomerService,
    ReportsCustomerService
};

use Illuminate\Http\Request;

class CustomerController extends Controller
{
   private $getCustomerService;
   private $reportsCustomerService;

   public function __construct(GetCustomerService $getCustomerService, ReportsCustomerService $reportsCustomerService)
   {
      $this->getCustomerService  = $getCustomerService;
      $this->reportsCustomerService = $reportsCustomerService;
   }
    public function index(Request $request)
    {
      return $this->getCustomerService->index($request);
    }


    public function show(Customer $customer)
    {
      return $this->getCustomerService->show($customer);
    }

    public function calls(Request $request)
    {
      return $this->reportsCustomerService->index($request);
    }

    public function send_calls_messege(Order $order,Request $request)
    {
     return $this->reportsCustomerService->send_calls_messege($order,$request);
    }  
}
