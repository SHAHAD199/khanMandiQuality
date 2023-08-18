<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Services\Customers\GetCustomerService;
use App\Services\Customers\PostCustomerService;
use Illuminate\Http\Request;

class CustomerController extends Controller
{

   private $getCustomerService;
   private $postCustomerService;

   public function __construct(GetCustomerService $getCustomerService, PostCustomerService $postCustomerService)
   {
      $this->getCustomerService  = $getCustomerService;
      $this->postCustomerService = $postCustomerService;
   }
    public function index(Request $request)
    {
      return $this->getCustomerService->index($request);
    }


    public function show(Customer $customer)
    {
      
    }
}
