@extends('layouts.layout')
@section('content') 

<style>
   table th, table td{
     font-size: 18px;
   }
   table  {
    border: 1px solid #792d30;
   }
</style>

<div class="container py-5">

<div class="d-flex my-4 justify-content-between">
   <h2>معلومات الزبون</h2>
    <a href="{{ url('customers') }}" class="btn marron-btn">عودة</a>
</div>
   <div class="state-section mb-5">
    <div class="container">
        <div class="state">
    
        <div class="col-md-3 marron-bolder rounded d-flex justify-content-between align-items-center  py-3 px-2">
            <p>عدد الطلبات الكلي</p>
            <p>{{$customer->orders->count() }}</p>
        </div>

        <div class="col-md-3 marron-bolder rounded d-flex justify-content-between align-items-center  py-3 px-2">
           <p>عدد الخصومات المقبولة </p>
           <p>{{$customer->orders->where('status', 2)->count() }}</p>
        </div>
        <div class="col-md-3 marron-bolder rounded d-flex justify-content-between align-items-center  py-3 px-2">
          <p>عدد الخصومات المستخدمة </p>
          <p>{{$customer->orders->where('status', 4)->count() }}</p>
        </div>
        <div class="col-md-3 marron-bolder rounded d-flex justify-content-between align-items-center  py-3 px-2">
         <p>عدد  الشكاوى المرفوضة </p>
            <p>{{$customer->orders->where('status', 3)->count() }}</p>
        </div>
        </div>
        </div>
</div>


<table class="table table-bordered text-center">
 <thead>
  <th>الإسم</th>
  <th>الرقم</th>
  <th>الطلبات</th>
 </thead>
 <tbody>
      <td>{{ $customer->name }}</td>
      <td>{{ $customer->phone }}</td>
      <td>
        <table class="table table-bordered text-center">
          <thead>
              <th>التاريخ</th>
              <th>نوع الطلب</th>
              <th>الفرع</th>
              <th>الشكاوى او الملاحظات</th>
              <th>الخصومات</th>
          </thead>
          @foreach($customer->orders as $order)
          <tbody>
             <td>{{ $order->order_date }}</td>          
             <td>{{ $order->orderType->name }}</td>
             <td>{{ $order->branch->name}}</td>
             <td>
              @if($order->complaints)
              <table  class="table table-bordered text-center">
              <thead>
                <th>القسم</th>
                <th>الطبق</th>
                <th>الشكوى</th>
               </thead>

               @foreach($order->complaints as $complaint)
               <tbody>
                 <td>{{ $complaint->department->name }}</td>
                 <td>{{ $complaint->metarial }}</td>
                 <td>{{ $complaint->complaint }}</td>
                 </tbody>
               @endforeach
              </table>
              @else لايوجد شكوى
              @endif
             </td>
             <td>
              <table class="table table-bordered text-center">
              @if($order->discount)
                <thead>
                  <th>قيمة الخصم</th>
                  <th>تاريخ اعطاء الخصم</th>
                  <th>تاريخ الاستخدام</th>
                  <th>الحساب</th>
                </thead>
     
                <tbody>
                  <td>@if(!is_null($order->discount->value)) {{ $order->discount->value }}@else {{ $order->discount->debt }} @endif</td>
                  <td>{{ Carbon\Carbon::parse($order->discount->created_at)->format('Y-m-d') }}</td>
                  <td>{{ $order->discount->date_use }}</td>
                  <td>{{ $order->discount->added_by }}</td>
                </tbody>
                
                @else لا يوجد خصم
                @endif
              </table>
             </td>
          </tbody>
          @endforeach
        </table>
      </td>
 </tbody>
</table>
</div>

@endsection