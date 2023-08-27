@extends('layouts.layout')
@section('content')
<style>
#all{ display:none;}
#all .form-group{padding:1%; border-bottom:1px solid #eee;}

 /* @media (max-width:500px)
 {ul.navbar-nav {display:none !important;}
 .card-header,.card-body{text-align: right;}
 .col-md-2 label {color:#00acc0;font-weight: 700;}
 .col-md-8 {flex-grow: 0;flex-shrink: 0;flex-basis: 86.6667%;max-width: 86.66667% !important;}} */
</style>


 <div class="row justify-content-center mt-5">
    <div class="col-md-9">
        <div class="card p-3">
            <div class="d-flex justify-content-between" >
            <h4 >استبيان</h4>   
            <a href="{{ url('orders') }}" class="btn marron-btn">عودة</a>
           </div>
<div class="card-body">
<form  method="POST" action='{{ url("orders/store/$order->id")}}'>
 @csrf 

 <div class="col-md-12 mt-3">
        <div class="row form-group text-center" style="border-bottom:none">
          <div class="col-md-2"> <label for=""> الفرع</label> </div>
          <div class="col-md-10">              
            <input type="text" readonly class="form-control" value="{{ $order->branch->name }}"  name="branch_id" >
          </div>
        </div>
</div>


 <!-- response input -->
<div class="col-md-12 mt-3">
         <div class="row form-group">
          <div class="col-md-2"> <label for=""> هل تم الرد؟</label> </div>
          <div class="col-md-10">
              <div class="form-check form-check-inline">
            <input type="radio" name="response" class="form-check-input" id="no" value="0"> <label for="no" class="form-check-label">لا</label>
            </div>
            <div class="form-check form-check-inline">
            <input type="radio" name="response" class="form-check-input" id="yes" value="1"> <label for="yes" class="form-check-label">نعم</label>
            </div>
          </div>
         </div>
        </div>
<!-- end response input -->
<div class="all col-md-12 mt-3" id="all">
<div class="row">

<!-- full name input -->
<div class="col-md-12 mt-3">
        <div class="row form-group text-center" style="border-bottom:none">
          <div class="col-md-2"> <label for="">الاسم الثلاثي</label> </div>
          <div class="col-md-10">   
            @if($order->customer) 
            <input type="text" class="form-control"  name="fname"  value="{{ $order->customer->fname }}">
            @else     
            <input type="text" class="form-control"  name="fname"  placeholder="ادخل الاسم الثلاثي">
            @endif
          </div>
        </div>
</div>
<!-- end full name input -->

<!-- Birthday input -->
<div class="col-md-12 mt-3">
        <div class="row form-group text-center" style="border-bottom:none">
          <div class="col-md-2"> <label for="birthday"> تاريخ الولادة</label> </div>
          <div class="col-md-10">         
          @if($order->customer) 
          <input type="date" class="form-control"  name="birthday" id="birthday" value="{{ $order->customer->birthday }}">
          @else
            <input type="date" class="form-control"  name="birthday" id="birthday">
          @endif
          </div>
        </div>
</div>
<!--end  Birthday input -->

<!-- Gender Input -->
<div class="col-md-12 mt-3">
    <div class="row form-group">
     <div class="col-md-2"><label for="">نوع الجنس</label></div>
    <div class="col-md-10">
        <div class="form-check form-check-inline">
        <input class="form-check-input" type="radio" name="gender" id="inlineCheckbox1" value="1"
        @if($order->customer && $order->customer->gender == 1) echo checked @endif
        >
        <label class="form-check-label" for="inlineCheckbox1"> ذكر</label>
        </div> 
        
        <div class="form-check form-check-inline">
        <input class="form-check-input" type="radio" name="gender" id="inlineCheckbox1" value="2"
        @if($order->customer && $order->customer->gender == 2) echo checked @endif
        >
        <label class="form-check-label" for="inlineCheckbox1">انثى</label>
        </div>

    </div>
    </div>
</div>

<!-- end gender input -->

<!-- Type Input -->
<div class="col-md-12 mt-3">
  <div class="row form-group">
  <div class="col-md-2"> <label for=""> الحالة</label> </div>
  <div class="col-md-10">
    <div class="form-check form-check-inline">
        <input class="form-check-input" type="radio" name="type" id="very_good" value="جيد جدا"> <label class="form-check-label" for="very_good">جيد جدا</label>
   </div>
   <div class="form-check form-check-inline">
        <input class="form-check-input" type="radio" name="type" id="good" value="جيد"> <label class="form-check-label" for="good">جيد</label>
   </div>
   <div class="form-check form-check-inline">
        <input class="form-check-input" type="radio" name="type" id="bad" value="سيء"> <label class="form-check-label" for="bad">سيء</label>
   </div>

  </div>
</div>
</div>


<!-- End type Input -->





<div class="col-md-12 d-none" id="copmlants_type" >
<table class="table table-bordered">
    <thead>
      
        <th>الاقسام</th>
        <th>الاطباق</th>
        <th>الشكاوى</th>
        <th>
          <a onclick="BtnAdd()" class="btn marron-btn">
          <i class="fa fa-plus"></i></a>
        </th>
    </thead>

    <tbody id="Tbody">
  
    </tbody>
</table>

<!-- Discount Status -->
<div class="col-md-6 mt-3" id="status" >

<div class="row form-group">
  <div class="col-md-2"> <label for=""> </label> </div>
  <div class="col-md-10">

     <div class="form-check form-check-inline">
   <input class="form-check-input" type="checkbox" name="is_immediately" id="urgent" value="2"> <label class="form-check-label" for="urgent">فوري</label>
   </div>
  </div>
</div> 


</div>
<!--End Discount Status -->


<!-- Img Status -->
<!-- <div class="col-md-6 mt-3" >

<div class="row form-group">
  <div class="col-md-2"> <label for=""></label> </div>
  <div class="col-md-10">

     <div class="form-check form-check-inline">
   <input class="form-check-input" type="checkbox" name="img_status" id="img_status" value="1"> <label class="form-check-label" for="img_status">صورة</label>
   </div>
  </div>
</div>
</div>  -->
<!--End Img Status -->


<!-- Discount Type -->
<div id="discoubtType" class="mt-3"></div>
<!-- End Discount Type -->

<!-- Value or Debt -->
<div id="shahad" class="mt-3"></div>
<!-- End Value or Dept -->


</div>  



</div>




<!-- Note Input -->
<div class="col-md-12 mt-3" id="note"></div>
<!--  -->


</div>
</div>
<div class="col-md-12 mt-5">
          <div class="row form-group">
          <!-- <div class="col-md-2"> <label for=""> </label> </div> -->
          <div class="col-md-10">
          <button  class="btn marron-outline-btn"  type="submit">ادخال</button>
          </div>
        </div> 
</div>

</div>
</form>
    </div>
    </div>
</div>
</div>
 
<script src="{{ asset('js/jquery.js') }}"></script>
<script src="{{ asset('js/main.js') }}"></script>
<script>
  function BtnAdd()
  {
    var v = $(`<tr id="Trow">
      <td>
        <select class="form-control" id="departments"  onchange="departmentchange(this)">
          <option value=""></option>
          @foreach($departments as $department)
          <option value="{{ $department->id }}">{{ $department->name }}</option>
          @endforeach
        </select>
      </td>
      <td id="mat">
        <select  id="material" name="material" class="form-control">
        
        </select>
      </td>
      <td> 
       <textarea  cols="10" rows="3" class="form-control" onchange="changeComplaint(this)"></textarea>
      </td>
      <td>
        <a onclick="BtnRemove(this)" class="btn marron-outline-btn">
        <i class="fa fa-times"></i></a>
      </td>
      </tr>`).clone().appendTo('#Tbody');
    $(v).find('input').val('');
    $(v).find('textarea').val('');
    
  }
  function BtnRemove(v)
  {
     $(v).parent().parent().remove();
  }
  function departmentchange(ss) {
   let value = $(ss).val();
   let tt = [];

   if(value == 1){
    $(ss).parent().siblings().children('#material').children('option').remove();
     $(ss).parent().siblings().children('#material').append(
      `
       
        @foreach(explode('-', $order->main_course) as $key=>$main)
            <option value="{{ $key }}">{{ $main }}</option>
        @endforeach
      `
     );
   }else if(value == 2){
    $(ss).parent().siblings().children('#material').children('option').remove();
    $(ss).parent().siblings().children('#material').append(
      `
        @foreach(explode('-', $order->appetizers) as $key=>$appetizer)
            <option value="{{ $key }}">{{ $appetizer }}</option>
        @endforeach
      `
     )

   }else if(value == 3){
    $(ss).parent().siblings().children('#material').children('option').remove();
    $(ss).parent().siblings().children('#material').append(
      `
        @foreach(explode('-', $order->additions) as $key=>$addition)
            <option value="{{$key}}">{{ $addition }}</option>
        @endforeach
      `
     )
   }else if(value == 4){
    $(ss).parent().siblings().children('#material').children('option').remove();
    $(ss).parent().siblings().children('#material').append(
      `      
        @foreach(explode('-', $order->drinks) as $key=>$drink)
            <option value="{{$key}}">{{ $drink }}</option>
        @endforeach
      `
     )
   }else {
    $(ss).parent().siblings().children('#material').children('option').remove();
   }
  }
  function changeComplaint(comp){

    
    let tt = [];
   
    let value = $(comp).parent().siblings().children('#departments').val();
    let material_value = $(comp).parent().siblings().children('#material').val();
    console.log($(comp).parent().siblings());


    $(comp).parent().siblings('#mat').append(
        `
        <input name="all_${value}[]" type="hidden" id="all_${value}_${material_value}">
        `
      );


  // console.log($(comp).parent().siblings().children('#material').children(`#all_${value}_${$(comp).val()}`).val());
    if(value != 1 && value != 2 && value != 3 && value != 4 ){
      
      tt.push(value);
      tt.push('لا يوجد');
      tt.push($(comp).val()); 

    }else{
      tt.push(value);
      tt.push($(comp).parent().siblings().children('#material').find(':selected').text());
      tt.push($(comp).val());

    }
    $(comp).parent().siblings('#mat').children(`#all_${value}_${material_value}`).val(tt);

   console.log($(comp).parent().siblings('#mat').children(`#all_${value}_${material_value}`).val());
   // $(comp).parent().siblings().children(`all_${value}_${$(comp).val()}`).val(tt);
    // console.log( $(comp).parent().siblings().children(`all_${value}_${$(comp).val()}`).val());

   }

  

 
</script>
@endsection


