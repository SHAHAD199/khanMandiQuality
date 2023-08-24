@extends('layouts.layout')
@section('content') 

<div class="container py-5">
<form action="{{ url('departments') }}" >
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
            <div class="col-md-2"><label for="">القسم</label></div>
            <div class="col-md-10">
                <select name="department_id" class="form-control">
                  <option value="">اختر قسماً</option>
                  @foreach($departments as $department)
                    <option value="{{ $department->id }}">{{ $department->name }}</option>
                  @endforeach
                </select>
            </div>
    </div>
    </div>

    <div class="col-md-1"></div>
    <div class="col-md-1 my-4">
        <button class="btn marron-btn"><i class="fa fa-search"></i></button>
    </div>
    <div class="col-md-1 my-4">
    <a class="btn marron-outline-btn" href="{{ url('departments') }}"><i class="fa fa-refresh"></i></a>
    </div>
 </div>
</form>

<table class="table table-bordered text-center">
    <thead>
         <th>#</th>
         <th>الرقم</th>
         <th>التاريخ</th>
         <th>الفاتورة</th>
         <th>نوع الطلب</th>
         <th>الفرع</th>
         <th>الشكاوى</th>
         
    </thead>
      @foreach($orders as $order)
      <tbody>
        <td>{{ $index++ }}</td>
        <td>{{ $order->customer->phone }}</td>
        <td>{{ $order->order_date }}</td>
        <td>{{ $order->bill }}</td>
        <td>{{ $order->orderType->name }}</td>
        <td>{{ $order->branch->name}}</td>
        <td>
            @if($order->complaints)
            <table class="table table-bordered text-center">
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
            @endif
        </td>
       
       
      </tbody>
      @endforeach
</table>
</div>

<table>
 <tr>
  <td>عدد الطلبات الكلي</td>
  <td>{{$customer->orders->count() }}</td>
 </tr>
 <tr>
  <td>عدد الخصومات المقبولة </td>
  <td>{{$customer->orders->where('status', 2)->count() }}</td>
 </tr>
 <tr>
  <td>عدد  الخصومات المستخدمة</td>
  <td>{{$customer->orders->where('status', 4)->count() }}</td>
 </tr>
 <tr>
  <td>عدد الشكاوى المرفوضة </td>
  <td>{{$customer->orders->where('status', 3)->count() }}</td>
 </tr>
</table>
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
       
              @endif
             </td>
             <td>
              <table class="table table-bordered text-center">
              @if($order->discounts)
                <thead>
                  <th>قيمة الخصم</th>
                  <th>تاريخ اعطاء الخصم</th>
                  <th>تاريخ الاستخدام</th>
                  <th>الحساب</th>
                </thead>
                @foreach($order->discounts as $discount)
                <tbody>
                  <td>@if(!is_null($discount->value)) {{ $discount->value }}@else {{ $discount->debt }} @endif</td>
                  <td>{{ $discount->created_at }}</td>
                  <td>{{ $discount->date_use }}</td>
                  <td>{{ $discount->added_by }}</td>
                </tbody>
                @endforeach
                @endif
              </table>
             </td>
          </tbody>
          @endforeach
        </table>
      </td>
 </tbody>
</table>

@endsection