@extends('layouts.layout')
@section('content') 

<div class="container py-5">
<form action="{{ url('reports/orders') }}" >
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
    <div class="col-md-1"></div>
    <div class="col-md-1 my-4">
        <button class="btn marron-btn"><i class="fa fa-search"></i></button>
    </div>
    <div class="col-md-1 my-4">
    <a class="btn marron-outline-btn" href="{{ url('reports/orders') }}"><i class="fa fa-refresh"></i></a>
    </div>

    <div class="col-md-1 my-4">
    
    <a class="btn marron-outline-btn" href="{{ url('create_pdf') }}"><i class="fa fa-file-pdf-o"></i></a>
    </div>
 </div>
</form>

<table class="table table-bordered text-center">
    <thead>
         <th>#</th>
         <th>الرقم</th>
         <th>التاريخ</th>
         <th>الفرع</th>
         <th>نوع الطلب</th>
         <th>الملاحظات او الشكاوى</th>     
         <th>الحالة</th>
    </thead>
      @foreach($orders as $order)
      <tbody>
        <td>{{ $index++ }}</td>
        <td>{{ $order->customer->phone }}</td>
        <td>{{ $order->order_date }}</td>
        <td>{{ $order->branch->name }}</td>
        <td>{{ $order->orderType->name }}</td>
        <td>
          @if($order->note)
           {{ $order->note->note}}
          @elseif($order->complaints)
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
       <td>
        @if($order->status == 1) في قائمة الانتظار
        @elseif($order->status == 2) خصم مقبول
        @elseif($order->status == 3) خصم مرفوض
        @elseif($order->status == 4) خصم مستخدم
        @else لا يوجد خصم
        @endif
        </td>
        </tbody>
      @endforeach
</table>
</div>
@endsection