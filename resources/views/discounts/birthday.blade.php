@extends('layouts.layout')
@section('content') 

<div class="container py-5">
<form action="{{ url('birthday') }}" >
 @csrf 

 <div class="row">
    <div class="col-md-4 mb-4">
         <div class="row">
            <div class="col-md-2"><label for="">بداية التاريخ</label></div>
            <div class="col-md-10"><input type="date" name="start_at" class="form-control"></div>
         </div>
    </div>
    <div class="col-md-4 mb-4">
    <div class="row">
            <div class="col-md-2"><label for="">نهاية التاريخ</label></div>
            <div class="col-md-10"><input type="date" name="end_at" class="form-control"></div>
    </div>
    </div>

    <div class="col-md-1 mb-4">
        <button class="btn marron-btn"><i class="fa fa-search"></i></button>
    </div>
    <div class="col-md-1 mb-4">
    <a class="btn marron-outline-btn" href="{{ url('birthday') }}"><i class="fa fa-refresh"></i></a>
    </div>
 </div>
</form>

<table class="table table-bordered text-center">
    <thead>
         <th>#</th>
         <th>الاسم</th>
         <th>الرقم</th>
         <th>الاجراءات</th>
         
    </thead>
      @foreach($customers as $customer)
      <tbody>
        <td>{{ $index++ }}</td>
        <td>{{ $customer->name }}</td>
        <td>{{ $customer->phone }}</td>
        <td>
            <form action="{{ url('send_birthday_sms') }}" method="post">
                @csrf 
                <input type="hidden" value="{{ $customer->id }}" name="customer_id">
                <input type="hidden" value="{{ $customer->phone }}" name="phone">
                <button class="btn marron-btn">ارسال الخصم</button>
            </form>
        </td>
      </tbody>
      @endforeach
</table>
</div>
@endsection