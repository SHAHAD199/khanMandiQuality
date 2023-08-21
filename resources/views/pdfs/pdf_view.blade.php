<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>

    <style>
      @font-face {
    font-family: 'harir';
    src:  url('@/public/fonts/alfont_com_harir.otf');

}
  body{
    font-family: 'harir'; 
  }
    </style>
</head>
<body>
<table class="table table-bordered text-center">
    <thead>
         <th>#</th>
         <th>الرقم</th>
         <th>التاريخ</th>
         <th>الفرع</th>
         <th>نوع الطلب</th>
         <th>الملاحظات او الشكاوى</th>     
         <th>الحالة</th>
    </thead>
      @foreach($orders as $order)
      <tbody>
        <td>{{ $index++ }}</td>
        <td>{{ $order->customer->phone }}</td>
        <td>{{ $order->order_date }}</td>
        <td>{{ $order->branch->name }}</td>
        <td>{{ $order->orderType->name }}</td>
        <td>
          @if($order->note)
           {{ $order->note->note}}
          @elseif($order->complaints)
          <table class="table table-bordered text-center">
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
        @if($order->status == 1) في قائمة الانتظار
        @elseif($order->status == 2) خصم مقبول
        @elseif($order->status == 3) خصم مرفوض
        @elseif($order->status == 4) خصم مستخدم
        @else لا يوجد خصم
        @endif
        </td>
        </tbody>
      @endforeach
</table>
</body>
</html>
