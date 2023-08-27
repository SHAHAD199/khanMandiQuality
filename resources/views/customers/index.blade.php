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
            <div class="col-md-2"><label for="">رقم الهاتف</label></div>
            <div class="col-md-10">
                <input type="text" class="form-control" name="phone">
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
<form action="{{ url('send_birthday_sms') }}" method="post" class="mt-5">
    @csrf 

    @if(isset($birthday))
    <div class="row">
       <div class="col-md-2"><a href="#" class="btn marron-outline-btn" id="select_all">select all</a></div>
       <div class="col-md-8"></div>
       <div class="col-md-2"> <button class="btn marron-btn  ms-auto">ارسال الخصم</button></div>
     </div>
     @endif

    </div>
 

<table class="table table-bordered text-center mb-4">
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

        @if(isset($birthday))
         <a href='{{ url("customers/$customer->id") }}' class="btn marron-btn d-inline-block">التفاصيل</a>
            <input type="hidden" value="{{ $customer->id }}"  name="customer_id">
            <input type="checkbox" name="phone[]" value="{{ $customer->phone }}"  class="select me-3">
    
        @else
        <a href='{{ url("customers/$customer->id") }}' class="btn marron-btn ">التفاصيل</a>
        @endif
     
 </td>
      </tbody>
      @endforeach
</table>
</form>
</div>

<script src="{{asset('js/jquery.js')}}"> </script>
<script>
             $(document).ready(function() {
              $("#select_all").click(function(){
                  $(".select").each(function(i,value){
                      
                      if($(this).is(":checked")) {
                         $(this).attr("checked", false);
                      } else {
                             $(this).attr("checked", true);
                      }
                    })
             })
          })
     </script>

@endsection