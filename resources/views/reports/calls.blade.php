@extends('layouts.layout')
@section('content') 

<div class="container py-5">
<form action="{{ url('calls') }}" >
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
            <div class="col-md-2"><label for="">حسب الرد</label></div>
            <div class="col-md-10">
                <select name="response" class="form-control">
                  <option value=""></option>
                  <option value="0">مكالمات لم يتم الرد عليها</option>
                  <option value="1">مكالمات تم الرد عليها</option>                
                </select>
            </div>
    </div>
    </div>
    

    <div class="col-md-1 my-4">
        <button class="btn marron-btn"><i class="fa fa-search"></i></button>
    </div>
    <div class="col-md-1 my-4">
    <a class="btn marron-outline-btn" href="{{ url('calls') }}"><i class="fa fa-refresh"></i></a>
    </div>
 </div>
</form>

<table class="table table-bordered text-center">
    <thead>
         <th>#</th>
         <th>الرقم</th>
         <th>التاريخ</th>
         <th>الفرع</th>
         <th>الاجراءات</th>
        
       
         
    </thead>
      @foreach($orders as $order)
      <tbody>
        <td>{{ $index++ }}</td>
        <td>{{ $order->customer->phone }}</td>
        <td>{{ $order->order_date }}</td>
        <td>{{ $order->branch->name }}</td>
        <td>
            @if($order->response == 0)
            <form action='{{ url("send_calls_messege/$order->id") }}' method="post">
                @csrf 
                <input type="hidden" name="phone" value="{{ $order->customer->phone }}">
                <button class="btn marron-btn">ارسال</button>
            </form>
            @endif
        </td> 
      </tbody>
      @endforeach
</table>
</div>
@endsection