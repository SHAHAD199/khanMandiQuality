<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous"> -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <link rel="stylesheet" href="{{ asset('css\app.css')}}">
    <link rel="stylesheet" href="{{ asset('css\style.css')}}">

</head>
<body>

<div class="row">
  <div class="col-md-2">
  <div class="side-bar">
    <!-- header section -->
    <header>
      <!-- close button -->
      
      <img src="{{ asset('imgs/logo.jpg') }}" alt="">
      <h1>CRM</h1>
    </header>
    <!-- end header section -->

    <div class="menu">
        <div class="item"><a href="{{ url('/') }}">الصفحة الرئيسية</a></div>
        <div class="item"><a class="sub-btn" >المستخدمين
        <!-- dropdown -->
        <i class="fa fa fa-angle-left dropdown"></i>
        <div class="sub-menu">
        
          <a href="{{ url('users') }}" class="sub-item">كل المستخدمين</a>
          <a href="{{ url('users/create') }}" class="sub-item">اضافة مستخدم</a>
          <a href="{{ url('roles')}}" class="sub-item">الادوار</a>
        </div>
       <!-- dropdown arrow -->
    </a>
    </div>
        <div class="item"><a class="sub-btn">
       <!-- dropdown -->
       الجودة
        <i class="fa fa-angle-left dropdown"></i>
        <div class="sub-menu">
          <a href="{{ url('birthday') }}" class="sub-item">اعياد الميلاد</a>
          <a href="{{ url('excel/add') }}" class="sub-item">اضافة طلبات الامس</a>
          <a href="{{ url('orders') }}" class="sub-item">طلبات الامس</a>
          <a href="{{ url('waiting_list') }}" class="sub-item">قائمة الانتظار</a>
        </div>
       <!-- dropdown arrow -->
      </a></div>
        <div class="item"><a class="sub-btn">
       <!-- dropdown -->
       تقارير جودة
        <i class="fa fa-angle-left dropdown"></i>
        <div class="sub-menu">
          <a href="{{ url('delivary') }}" class="sub-item">جودة الدليفيري</a>
          <a href="{{ url('takeaway') }}" class="sub-item">جودة السفري</a>
          <a href="{{ url('departments') }}" class="sub-item">جودة الاقسام</a>
        </div>
       <!--  -->
      </a></div>
      <!-- dropdown arrow -->


      <div class="item"><a class="sub-btn">
       <!-- dropdown -->
       تقارير خصومات
        <i class="fa fa-angle-left dropdown"></i>
        <div class="sub-menu">
          <a href="{{ url('approval_discounts') }}" class="sub-item">الخصومات المقبولة</a>
          <a href="{{ url('reject_discounts') }}" class="sub-item">الخصومات المرفوضة</a>
          <a href="{{ url('used_discounts') }}" class="sub-item">الخصومات المستخدمة</a>
        </div>
       <!--  -->
      </a></div>
      <!-- dropdown arrow -->

        <div class="item"><a class="sub-btn">
       <!-- dropdown -->
       تقارير زبائن
        <i class="fa fa-angle-left dropdown"></i>
        <div class="sub-menu">
          <a href="{{ url('customers') }}" class="sub-item">شامل</a>
        </div>
       <!-- dropdown arrow -->
      </a></div>

       <!-- dropdown arrow -->

       <div class="item"><a class="sub-btn">
       <!-- dropdown -->
       تقارير موظفين
        <i class="fa fa-angle-left dropdown"></i>
        <div class="sub-menu">
          <a href="{{ url('reports/employee') }}" class="sub-item">نسب المكالمات</a>
        </div>
       <!-- dropdown arrow -->
      </a></div>
    </div>
  </div>
  </div>
  

<div class="col-md-10">
<div class="container p-5">

@yield('content')

</div>
  </div>
  </div>

<script src="{{ asset('js/jquery.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>

<script>
  $(document).ready(function()
  {
    // menu btn
    $('.menu-btn').click(function(){
      $('.side-bar').addClass('active');
      $('menu-btn').css('visibility' , 'hidden');
    });

    // close btn
    $('.close-btn').click(function(){
      $('.side-bar').removeClass('active');
      $('menu-btn').css('visibility' , 'visible');
    });


    // sub menu dropdown
    $('.sub-btn').click(function(){
      $(this).next('.sub-menu').slideToggle();
      $(this).find('.dropdown').toggleClass('rotate');
    })
  })
</script>
</body>
</html>