@extends('layouts.layout')
@section('content') 

<div class="container py-5">
<form action="{{ url('reports/customer') }}" >
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
            <div class="col-md-2"><label for="">نوع الجنس</label></div>
            <div class="col-md-10">
                <select name="gender" class="form-control">
                  <option value=""></option>
                  <option value="1">ذكر</option>
                  <option value="2">انثى</option>
                </select>
            </div>
    </div>
    </div>

    <div class="col-md-4 my-4">
    <div class="row">
            <div class="col-md-2"><label for="">تاريخ الميلاد</label></div>
            <div class="col-md-10">
                <input type="date" class="form-control" name="birthday">
            </div>
    </div>
    </div>

    <div class="col-md-1"></div>
    <div class="col-md-1 my-4">
        <button class="btn marron-btn"><i class="fa fa-search"></i></button>
    </div>
    <div class="col-md-1 my-4">
    <a class="btn marron-outline-btn" href="{{ url('reports/customer') }}"><i class="fa fa-refresh"></i></a>
    </div>
 </div>
</form>

<table class="table table-bordered text-center">
    <thead>
         <th>#</th>
         <th>الاسم</th>
         <th>الرقم</th>
         <th>نوع الجنس</th>
         <th>عدد مرات الطلب</th>
         <th>مجموع الفواتير</th>
         <th>عدد الخصومات المستخدمة</th>
         <th></th>
         
    </thead>
      @foreach($customers as $customer)
      <tbody>
        <td>{{ $index++ }}</td>
        <td>{{ $customer->name }}</td>
        <td>{{ $customer->phone }}</td>
        <td>
            @if($customer->gender == 1)ذكر @else انثى@endif
        </td>
        <td>{{ $customer->orders->count() }}</td>
        <td>
            {{ $customer->orders->sum('bill')}}
        </td> 
        <td>
            {{ $customer->orders->where('status', 2)->count() }}
        </td>
        <td>
            <a href="#" class="btn marron-btn">التفاصيل</a>
        </td>
      </tbody>
      @endforeach
</table>
</div>
@endsection