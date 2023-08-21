<?php

namespace App\Http\Controllers;

use App\Services\DiscountsReports\{
    ApprovalService, RejectService , UsedService
};
use Illuminate\Http\Request;

class DiscountReportsController extends Controller
{

    private $approval;
    private $reject;
    private $used;

    public function __construct(ApprovalService $approval, RejectService $reject, UsedService $used)
    {
        $this->approval = $approval;
        $this->reject   = $reject;
        $this->used     = $used;
    }


    public function approval_discounts(Request $request)
    {
      return $this->approval->approval_discounts($request);
    }



    public function reject_discounts(Request $request)
    {
        return $this->reject->reject_discounts($request);
    }



    public function used_discounts(Request $request)
    {
       return $this->used->used_discounts($request);
    }


}
