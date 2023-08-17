@extends('layouts.layout')
@section('content')

<table class="table table-bordered">
    <thead>
      
        <th>Departments</th>
        <th>Metarial</th>
        <th>Complaints</th>
        <th>
          <button onclick="BtnAdd()" class="btn marron-btn">
          <!-- <i class="fa fa-plus"></i> -->
          +
          </button>
        </th>
    </thead>

    <tbody id="Tbody">
      <tr id="Trow">

      <td>
        <select class="form-control" id="departments"  onchange="departmentchange(this)">
          <option value=""></option>
          @foreach($departments as $department)
          <option value="{{ $department->id }}">{{ $department->name }}</option>
          @endforeach
        </select>
      </td>
      <td>
        <select name="material" id="material" class="form-control">
        
        </select>
      </td>
      <td>
       <textarea name="complaints[]" id="" cols="10" rows="3" class="form-control" onchange="changeComplaint(this)"></textarea>
      </td>
      <td>
        <button onclick="BtnRemove(this)" class="btn marron-outline-btn">
        <!-- <i class="fa fa-times"></i> -->
        x
        </button>
      </td>
      </tr>

    </tbody>
</table>


<script src="{{ asset('js/jquery.js') }}"></script>

<script>

  function BtnAdd()
  {
    var v = $("#Trow").clone().appendTo('#Tbody');
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
        <option value=""></option>
        @foreach(explode('-', $order->main_course) as $main)
            <option value="{{ $main }}">{{ $main }}</option>
        @endforeach
      `
     );

     
  
   }else if(value == 2){
    $(ss).parent().siblings().children('#material').children('option').remove();
    $(ss).parent().siblings().children('#material').append(
      `
        <option value=""></option>
        @foreach(explode('-', $order->appetizers) as $appetizer)
            <option value="{{ $appetizer }}">{{ $appetizer }}</option>
        @endforeach
      `
     )

   }else if(value == 3){
    $(ss).parent().siblings().children('#material').children('option').remove();
    $(ss).parent().siblings().children('#material').append(
      `
        <option value=""></option>
        @foreach(explode('-', $order->additions) as $addition)
            <option value="{{ $addition }}">{{ $addition }}</option>
        @endforeach
      `
     )
 
   }else if(value == 4){
    $(ss).parent().siblings().children('#material').children('option').remove();
    $(ss).parent().siblings().children('#material').append(
      `
        <option value=""></option>
        @foreach(explode('-', $order->drinks	) as $drink)
            <option value="{{ $drink }}">{{ $drink }}</option>
        @endforeach
      `
     )
   }else {
 
    $(ss).parent().siblings().children('#material').children('option').remove();
   }

   $(ss).parent().append(
    `
    <input name="all_${value}[]" type="hidden" id="all_${value}">
    `
   );


  }



  function changeComplaint(comp){
    let tt = [];
    tt.push($(comp).parent().siblings().children('#departments').val());
    tt.push($(comp).parent().siblings().children('#material').val());
    tt.push($(comp).val());
    $(comp).parent().siblings().children(`#all_${$(comp).parent().siblings().children('#departments').val()}`).val(tt);
   }
</script>
@endsection 