@extends('layouts.layout')
@section('content')

<div class="heading my-3">
    <h3>البحث عن زبون</h3>
</div>
<form action="{{ url('/') }}" method="get">
    @csrf 
    <div class="row">
        <div class="col-md-4">
            <div class="row">
            <div class="col-md-2">
                <label for="">الرقم</label>
            </div>
            <div class="col-md-10">
                <input type="text" name="phone" class="form-control">
            </div>
            </div>          
        </div>
        
        <div class="col-md-1">
            <button class="btn marron-btn"><i class="fa fa-search"></i></button>
        </div>
        <div class="col-md-1">
            <a href="{{ url('/') }}" class="btn marron-outline-btn"><i class="fa fa-refresh"></i></a>
        </div>

    </div>
</form>

<table class="table table-bordered text-center my-4">
    <thead>
         <th>#</th>
         <th>الرقم</th>
         <th>قيمة الخصم</th>
        <th>تاريخ الطلب</th>
        <th>تاريخ اعطاء الخصم</th>
        <th>الاجراء</th>
    </thead>

    @if(isset($discounts))
      @foreach($discounts as $discount)
      <tbody>
        <td>{{ $index++ }}</td>
        <td>{{ $discount->customer->phone }}</td>
        <td>{{ $discount->value }}</td>
        <td>
            @if($discount->order)
            {{ Carbon\Carbon::parse($discount->order->order_date)->format('Y-m-d')  }}
            @endif
        </td>
        <td>
        {{ Carbon\Carbon::parse($discount->created_at)->format('Y-m-d')}}
           
        </td>
        <td>
                 
                    @if($discount->status == 1)
                    <p class="marron-color"> في قائمة الانتظار</p>
                    @elseif($discount->status == 2)
                    <form action='{{ url("use_discount/$discount->id") }}'>
                        @csrf 
                        @if($discount->customer && $discount->customer->where('birthday_status', '1'))
                        <p class="text">سبب الخصم : عيد ميلاد</p>   
                        @endif
                        <button class="btn marron-btn">استخدام الخصم</button>
                    </form>
                    @elseif($discount->status == 3)
                    <p class="marron-color">الخصم مرفوض</p>
                    @elseif($discount->status == 4)
                    <p class="marron-color">الخصم مستخدم</p>
                    @else
                    <p class="marron-color">لا يوجد خصم</p>
                   @endif
        </td>
      </tbody>
      @endforeach
    @endif
</table>
@endsection