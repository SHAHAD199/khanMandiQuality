@extends('layouts.layout')
@section('content') 

<style>
    #info-div
     {
        display: flex;       
        justify-content: center;
        height: 600px;
        width: 70vw;
        position: fixed;
        top: 10%; 
        overflow: auto !important;
        background: #fff;
        margin: auto;      
    }

    #info-div .model 
    {
       height: 100%;
       min-width: 100%;
       margin:0;
       padding:20px;       
       border-radius: 5px;
       position: relative;
    }
</style>

<div class="container py-5">
<form action="{{ url('customers') }}" >
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
    <a class="btn marron-outline-btn" href="{{ url('customers') }}"><i class="fa fa-refresh"></i></a>
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
        <a href="#" class="btn marron-btn" onclick="info(this, <?php echo $customer->id; ?>)">التفاصيل</a>
        <input class="customer_hidden" name="customer_hidden" type="hidden" value="{{ $customer->id }}">
 </td>
      </tbody>
      @endforeach
</table>
</div>

<div class="test">

</div>


<script>
    function info(e,customer)
    {
//    document.cookie = "id =" + customer;


$('.test').append(
`

@php
$dd = $_COOKIE['id'];
$customer = App\Models\Customer::find($dd);
@endphp
<div id="info-div" class="marron-bolder">
<div class="model">
<div class="d-flex my-4 justify-content-between">
   <h2>اضافة زبون</h2>
 
   <button class="btn marron-btn" onclick="closeInfo(this)"><i class="fa fa-times"></i></button>
</div>
<table class="table table-bordered text-center">
 <tr>
  <td class="w-50">عدد الطلبات الكلي</td>
  <td class="w-50">{{$customer->orders->count() }}</td>
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
              @if($order->discount)
                <thead>
                  <th>قيمة الخصم</th>
                  <th>تاريخ اعطاء الخصم</th>
                  <th>تاريخ الاستخدام</th>
                  <th>الحساب</th>
                </thead>
     
                <tbody>
                  <td>@if(!is_null($order->discount->value)) {{ $order->discount->value }}@else {{ $order->discount->debt }} @endif</td>
                  <td>{{ $order->discount->created_at }}</td>
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
</div>
`
   );

 }
    function closeInfo(ss)
    {
        // $(ss).parents().parents().append().remove();
       $(ss).parents().parents().parents('#info-div').append().remove();
    }
</script>
@endsection