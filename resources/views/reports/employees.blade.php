@extends('layouts.layout')
@section('content') 

<div class="container py-5">
<form action="{{ url('reports/employee') }}" >
 @csrf 

 <div class="row">
    <div class="col-md-4 my-4">
         <div class="row">
            <div class="col-md-2"><label for="">بداية التاريخ</label></div>
            <div class="col-md-10"><input type="date" name="start_at" class="form-control"></div>
         </div>
    </div>
    <div class="col-md-4 my-4">
    <div class="row">
            <div class="col-md-2"><label for="">نهاية التاريخ</label></div>
            <div class="col-md-10"><input type="date" name="end_at" class="form-control"></div>
    </div>
    </div>


    <div class="col-md-1"></div>
    <div class="col-md-1 my-4">
        <button class="btn marron-btn"><i class="fa fa-search"></i></button>
    </div>
    <div class="col-md-1 my-4">
    <a class="btn marron-outline-btn" href="{{ url('reports/employee') }}"><i class="fa fa-refresh"></i></a>
    </div>
 </div>
</form>

<table class="table table-bordered text-center">
    @foreach($branches as $branch)
    <tr>
        <td colspan="11" class="marron-background-color text-white">فرع {{ $branch->name}}</td> 
    </tr>

    <tr>
        <td>نوع الطلب</td>
        <td>عدد الطلبات</td>
        <td>عدد المكالمات</td>
        <td>المكالمات التي تم الرد عليها</td>
        <td>%</td>
        <td>المكالمات التي لم يتم الرد عليها</td>
        <td>%</td>
        <td>الشكاوى</td>
        <td>%</td>
        <td>الملاحظات</td>
        <td>%</td>
    </tr>



        
        @foreach($orderTypes as $type)
      <tr>
      <td>{{ $type->name }}</td>
        <td>   
            {{
                App\Models\Order::where('branch_id', $branch->id)
                ->where('order_type_id', $type->id)
                ->get()->count()
            }}
        </td>
        <td>

        @php  
        $all_calls =  App\Models\Order::where('branch_id', $branch->id)
                ->where('order_type_id', $type->id)        
                ->where('add_status', 1)
                ->get()->count();
        @endphp

           {{ $all_calls }}
        </td>
        <!-- ->where('order_date', \Carbon\Carbon::yesterday()) -->
      
        <td>
            @php 
            $answered_calls =  App\Models\Order::where('branch_id', $branch->id)
                ->where('order_type_id', $type->id)        
                ->where('add_status', 1)
                ->where('response',1)
                ->get()->count();
            @endphp 

            {{ $answered_calls }}
        </td>
        <td>
       
        @php  
        $answered_calls_parcent = ($answered_calls) ? ($answered_calls /  $all_calls ) * 100 : 0;
        @endphp 

       {{ $answered_calls_parcent }}
        </td>
        <td>
            @php 
             $not_answered_calls =  App\Models\Order::where('branch_id', $branch->id)
                ->where('order_type_id', $type->id)        
                ->where('add_status', 1)
                ->where('response',0)
                ->get()->count();
            @endphp 

            {{ $not_answered_calls }}
        </td>
        <td>
            @php  
            $not_answered_calls_parcent = ($not_answered_calls) ? ($not_answered_calls /  $all_calls ) * 100 : 0;      
            @endphp 
         {{ $not_answered_calls_parcent }}
        
        </td>
        <td>
            @php  
            $complaints = App\Models\Order::where('branch_id', $branch->id)
                ->where('order_type_id', $type->id)        
                ->where('add_status', 1)
                ->where('response',1)
                ->where('status', 1)
                ->get()->count();
            @endphp
            {{ $complaints }}
        </td>
        <td>
            @php 
              $complaints_parcent = ($complaints) ? ($complaints / $all_calls) * 100 : 0;
            @endphp
            {{ $complaints_parcent }}
        </td>
        <td>
        @php  
            $notes = App\Models\Order::where('branch_id', $branch->id)
                ->where('order_type_id', $type->id)        
                ->where('add_status', 1)
                ->where('response',1)
                ->where('status', 0)
                ->get()->count();
            @endphp
            {{ $notes }}
        </td>
        <td>
            @php 
              $notes_parcent = ($notes) ? ($notes / $all_calls) * 100 : 0;
            @endphp
            {{ $notes_parcent }}
        </td>
    </tr>
    @endforeach
    @endforeach
</table>
</div>
@endsection