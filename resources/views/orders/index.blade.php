@extends('layouts.layout')
@section('content')


<div class="heading mb-4 pt-3">

    
     <form action="{{ url('orders') }}" method="get">
       @csrf 
       <div class="row">
        <div class="col-md-6">
            <div class="row">
                <div class="col-md-2">
                    <label for="phone"> رقم الهاتف</label>
                </div>
                <div class="col-md-8">
                    <input type="text" name="phone" class="form-control">
                </div>
            </div>
        </div>
        <div class="col-md-1">
             <button class="btn marron-btn"><i class="fa fa-search"></i></button>
        </div>
        <div class="col-md-1">
             <a href="{{ url('orders') }}" class="btn marron-outline-btn"><i class="fa fa-refresh"></i></a>
        </div>
        </div>
     </form>
   

</div>
<table class="table table-bordered">
 <thead>
    
     <th>#</th>
     <th>الاسم</th>
     <th>الرقم</th>
     <th>الفاتورة</th>
     <th>الفرع</th>
     <th>المدينة</th>
     <th>نوع الطلب</th>
     <th>تاريخ الطلب</th>
     <th>عدد مرات الطلب</th>
     <th>history</th>
     <th>الاجرائات</th>
 </thead>

 @foreach($orders as $order)
 <tbody>
    <td>{{ $index++ }}</td>
    <td>{{ $order->customer->name }}</td>
    <td>{{ $order->customer->phone }}</td>
    <td>{{ $order->bill }}</td>
    <td>{{ $order->branch->name }}</td>
    <td>{{ $order->city }}</td>
    <td>{{ $order->orderType->name}}</td>
    <td>{{ $order->order_date }}</td>
    <td>{{ $order->customer->orders->count() }}</td>
    <td>
   
        @if($order->customer->orders && !is_null($order->complaints))
          <table class="table table-bordered">
            <thead>
                <th>الوجبة</th>
                <th>التاريخ</th>
                <th>قيمة الخصم</th>
                <th>الشكاوى</th>
            </thead>
            @foreach($order->customer->orders->where('order_date', '!=', $order->order_date) as $order)
            <tbody>
                <td>{{ $order->mail }}</td>
                <td>{{ $order->order_date }}</td>
                <td>
                    @if($order->discount)
                    {{ $order->discount->value}}
                    @endif
                </td>
                <td>
                    @if($order->complaints)
                    <table class="table table-bordered">
                        <thead>
                            <th>القسم</th>
                            <th>الطبق</th>
                            <th>الشكاوى</th>
                        </thead>
                        @foreach($order->complaints as $complaint)
                        <tbody>
                            <td>{{ $complaint->department->name }}</td>
                            <td>{{ $complaint->material }}</td>
                            <td>{{ $complaint->complaint }}</td>
                        </tbody>
                        @endforeach
                    </table>
                    @endif
                </td>
            </tbody>
            @endforeach
          </table>
        @endif
    </td>
    <td>
        <a href='{{ url("orders/create/$order->id") }}'  class="btn marron-btn">اضافة تقييم</a>
    </td>
 </tbody>

 @endforeach
</table>
@endsection