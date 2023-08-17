@extends('layouts.layout')
@section('content') 

<div class="container py-5">
<form action="{{ url('approval_discounts') }}" >
 @csrf 

 <div class="row">
    <div class="col-md-4 ">
         <div class="row">
            <div class="col-md-2"><label for="">بداية التاريخ</label></div>
            <div class="col-md-10"><input type="date" name="start_at" class="form-control"></div>
         </div>
    </div>
    <div class="col-md-4">
    <div class="row">
            <div class="col-md-2"><label for="">نهاية التاريخ</label></div>
            <div class="col-md-10"><input type="date" name="end_at" class="form-control"></div>
    </div>
    </div>
    <div class="col-md-4">
    <div class="row">
            <div class="col-md-2"><label for="">الفرع</label></div>
            <div class="col-md-10">
                <select name="branch_id" class="form-control">
                  <option value="">اختر فرعاً</option>
                  @foreach($branches as $branch)
                    <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                  @endforeach
                </select>
            </div>
    </div>
    </div>
    <div class="col-md-4 my-4">
    <div class="row">
            <div class="col-md-2"><label for="">رقم الهاتف</label></div>
            <div class="col-md-10">
               <input type="text" class="form-control" name="phone">
            </div>
    </div>
    </div>
    <div class="col-md-1"></div>
    <div class="col-md-1 my-4">
        <button class="btn marron-btn"><i class="fa fa-search"></i></button>
    </div>
    <div class="col-md-1 my-4">
    <a class="btn marron-outline-btn" href="{{ url('approval_discounts') }}"><i class="fa fa-refresh"></i></a>
    </div>
 </div>
</form>

<table class="table table-bordered text-center">
    <thead>
         <th>#</th>
         <th>الرقم</th>
         <th>التاريخ</th>
         <th>الفرع</th>
         <th>الفاتورة</th>
         <th>نوع الطلب</th>
         <th>الشكاوى</th>
         
    </thead>
      @foreach($discounts as $discount)
      <tbody>
        <td>{{ $index++ }}</td>
        <td>{{ $discount->order->customer->phone }}</td>
        <td>{{ $discount->order->order_date }}</td>
        <td>{{ $discount->order->branch->name }}</td>
        <td>{{ $discount->order->bill }}</td>
        <td>{{ $discount->order->orderType->name }}</td>
        <td>
            @if($discount->order->complaint)
            <table class="table table-bordered text-center">
               <thead>
                <th>القسم</th>
                <th>الطبق</th>
                <th>الشكوى</th>
               </thead>
              
                 @foreach($discount->order->complaint as $complaint)
                 <tbody>
                 <td>{{ $complaint->department->name }}</td>
                 <td>{{ $complaint->metarial }}</td>
                 <td>{{ $complaint->complaint }}</td>
                 </tbody>
                 @endforeach
             
            </table>
            @endif
        </td>
       
       
      </tbody>
      @endforeach
</table>
</div>
@endsection