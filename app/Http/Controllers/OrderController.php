<?php

namespace App\Http\Controllers;
use App\Models\Order;
use App\Services\Orders\
{GetOrderService, PostOrderService};


use Illuminate\Http\Request;

class OrderController extends Controller
{

    private $getOrderService;
    private $postOrderService;
    
    public function __construct(GetOrderService $getOrderService, PostOrderService $postOrderService)
    {
        $this->getOrderService = $getOrderService;
        $this->postOrderService = $postOrderService;
    }

    public function index(Request $request)
    {
     return $this->getOrderService->index($request);
    }

    public function create(Order $order)
    {
        return $this->getOrderService->create($order);
    }


    public function update(Order $order, Request $request) 
    {           
       return $this->postOrderService->update($order, $request);
    }


    public function approval(Order $order, Request $request)
    {
       return $this->postOrderService->approval($order, $request);
    }

    public function reject(Order $order)
    {      
        return $this->postOrderService->reject($order);
    }

    public function notes(Request $request)
    { 
        return $this->getOrderService->notes($request);
    }
}
