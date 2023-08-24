@extends('layouts.layout')
@section('content')


<div class="heading mb-4 pt-3">

     <form action="{{ url('employees') }}" method="get">
       @csrf 
       <div class="row">
        <div class="col-md-4">
            <div class="row">
                <div class="col-md-2">
                    <label for="phone">بداية التاريخ </label>
                </div>
                <div class="col-md-8">
                    <input type="date" name="start_at" class="form-control">
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="row">
                <div class="col-md-2">
                    <label for="phone">نهاية التاريخ </label>
                </div>
                <div class="col-md-8">
                    <input type="date" name="end_at" class="form-control">
                </div>
            </div>
        </div>
        <div class="col-md-1">
             <button class="btn marron-btn"><i class="fa fa-search"></i></button>
        </div>
        <div class="col-md-1">
             <a href="{{ url('employees') }}" class="btn marron-outline-btn"><i class="fa fa-refresh"></i></a>
        </div>
        </div>
     </form>
</div>



   <div class="state-section mb-5">
    <div class="container">
        <div class="state">
    
        <div class="col-md-3 marron-bolder rounded d-flex justify-content-between align-items-center  py-3 px-2">
            <p>عدد الطلبات الكلي</p>
            <p>{{ $missed_calls->count() }}</p>
        </div>

        <div class="col-md-3 marron-bolder rounded d-flex justify-content-between align-items-center  py-3 px-2">
           <p>عدد  الزبائن الضائعة </p>
           <p>{{ $missed_calls->where('status', 0)->count() }}</p>
        </div>
        <div class="col-md-3 marron-bolder rounded d-flex justify-content-between align-items-center  py-3 px-2">
          <p>عدد  الزبائن الذين تم الاتصال بهم </p>
          <p>{{ $missed_calls->where('status', 2)->count() }}</p>
        </div>
        <div class="col-md-3 marron-bolder rounded d-flex justify-content-between align-items-center  py-3 px-2">
          <p>عدد الزبائن الذين عاودو الاتصال </p>
         <p>{{ $missed_calls->where('status', 1)->count() }}</p>
        </div>
        </div>
        </div>
</div>



<table class="table table-bordered text-center mt-5">
 <thead>   
     <th>#</th>
      <th>المصدر</th>
      <th>الوجهة</th>
      <th>التاريخ</th>
      <th>عدد المحاولات</th>
      <th>الحالة</th>

 </thead>

 @foreach($missed_calls as $missed_call)
 <tbody>
    <td>{{ $index++ }}</td>
    <td>{{ $missed_call->source }}</td>
    <td>{{ $missed_call->destination }}</td>
    <td>{{ $missed_call->datetime }}</td>
    <td>{{ $missed_call->number_of_attmpts }}</td>
    <td>
        @if( $missed_call->status == 0)
        زبون ضائع
       @elseif( $missed_call->status == 1)
       عاود الاتصال
       @elseif( $missed_call->status == 2)
       تم الاتصال به
       @else 
       خارج وقت العمل
       @endif

    </td>
 
 </tbody>

 @endforeach
</table>
@endsection