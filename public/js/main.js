$('input[type=radio][name=response]').change(function() {
    if(this.value == 0){
        $("#all").css("display","none");
        console.log("all");
    } else {
        $("#all").css("display","block");
    }
});


$('#urgent').click(function(){
 var x = $(this).is(':checked');
 if(x == true){
  $("#discoubtType").append(
    `
   <div class="row form-group">
   <div class="col-md-2"> <label for="">نوع الخصم </label> </div>
   <div class="col-md-10">
     <div class="form-check form-check-inline">
    <input class="form-check-input" type="radio" name="discountType" value="1" onchange="changeDiscountType(1)"> <label class="form-check-label">قيمة خصم</label>
    </div>
      <div class="form-check form-check-inline">
    <input class="form-check-input" type="radio" name="discountType"  value="2" onchange="changeDiscountType(2)"> <label class="form-check-label" >مبلغ</label>
    </div>
   </div>
 </div> 
   `
  );
 }else {
  $("#discoubtType").children('.row').remove();
  $("#shahad").children('.debt').remove();
  $("#shahad").children('.value').remove();
 }
});


$('input[type=radio][name=type]').change(function() {
  
    if(this.value == 'سيء'){
        $('#copmlants_type').toggleClass('d-none');
        $('#note').children('.row').remove();
    }
    
    else if(this.value == 'جيد'){
      $('#copmlants_type').addClass('d-none');
      $('#note').append(`
      <div class="row form-group">
      <div class="col-md-2"> <label for="" id="label">ملاحظات</label> </div>
      <div class="col-md-10">
      <textarea  class="form-control" name="note" id="note"> </textarea>
      </div>
    </div>
      `);
    }
    else {
      $('#copmlants_type').addClass('d-none');
      $('#note').children('.row').remove();
    }
});


function changeDiscountType(ss)
{

  if(ss == 1){
   
    $('#shahad').append(
      `
      <div class="row form-group value">
      <div class="col-md-2"> <label for="" id="label">قيمة الخصم</label> </div>

      <div class="col-md-10">
      <select name="value" class="form-control">
      <option></option>
      <option value="10">10%</option>
      <option value="15">15%</option>
      <option value="20">20%</option>
      <option value="25">25%</option>
      <option value="50">50%</option>
      <option value="100">100%</option>
      </select>
      </div>
      `
    );
    
      $("#shahad").children('.debt').remove();
  }
  else if(ss == 2){
    $("#shahad").append(`
    <div class="row form-group debt">
    <div class="col-md-2"> <label for="" id="label"> مبلغ الخصم</label> </div>

    <div class="col-md-10">
    <input name="debt" class="form-control">
    </div>
    `);
    $("#shahad").children('.value').remove();
  }
}



