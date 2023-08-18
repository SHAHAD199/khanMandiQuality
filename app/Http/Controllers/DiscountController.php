<?php

namespace App\Http\Controllers;

use App\Models\Discount;
use App\Services\Discounts\GetDiscountService;
use App\Services\Discounts\PostDiscountService;
use App\Services\Whatsapp;
use Illuminate\Http\Request;

class DiscountController extends Controller
{

    private $whatsapp;
    private $getDiscountService;
    private $postDiscountService;
    public function __construct(Whatsapp $whatsapp, GetDiscountService $getDiscountService, PostDiscountService $postDiscountService)
    {
        $this->whatsapp = $whatsapp;
        $this->getDiscountService = $getDiscountService;
        $this->postDiscountService = $postDiscountService;
    }
    public function birthday()
    {
     return $this->getDiscountService->birthday();
    }

    public function send_birthday_sms(Request $request)
    {
       return $this->postDiscountService->send_birthday_sms($request);
    }

    public function index(Request $request)
    {
       return $this->getDiscountService->index($request);
    }

    public function waiting_list(Request $request)
    {
      return $this->getDiscountService->waiting_list($request);
    }
    public function use_discount(Discount $discount)
    {
       return $this->postDiscountService->use_discount($discount);
    }


}
