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
         <th>قيمة الخصم</th>
         <th>اسم المستخدم</th>
         <th>نوع الطلب</th>
         <th>السبب</th>
         
    </thead>
      @foreach($discounts as $discount)
      <tbody>
        <td>{{ $index++ }}</td>
        <td>{{ $discount->customer->phone }}</td>
        <td>
          @if($discount->order)
          {{ $discount->order->order_date }}
          @endif
        </td>
        <td>
          @if($discount->order)
          {{ $discount->order->branch->name }}</td>
          @endif
        <td>
          @if($discount->order)
          {{ $discount->order->bill }}</td>
          @endif
        <td>
          @if(!is_null($discount->value))
          {{ $discount->value }}
          @else 
          {{ $discount->debt }}
          @endif

        </td>
        <td>{{ $discount->added_by}}</td>
        <td>
          @if($discount->order)
          {{ $discount->order->orderType->name }}
          @endif
        </td>
        <td>
          @if($discount->order)
            @if($discount->order->complaints)
            <table class="table table-bordered text-center">
               <thead>
                <th>القسم</th>
                <th>الطبق</th>
                <th>الشكوى</th>
               </thead>
              
                 @foreach($discount->order->complaints as $complaint)
                 <tbody>
                 <td>{{ $complaint->department->name }}</td>
                 <td>{{ $complaint->metarial }}</td>
                 <td>{{ $complaint->complaint }}</td>
                 </tbody>
                 @endforeach
             
            </table>
            @endif
          @elseif($discount->customer && $discount->customer->where('birthday_status', '1'))
          عيد ميلاد
          @endif
        </td>
       
       
      </tbody>
      @endforeach
</table>
</div>
@endsection