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