@extends('layouts.layout')
@section('content')

<div class="card px-4 py-3">
    <div class="heading-card d-flex justify-content-between">
    <h3 class="marron-color">جميع المستخدمين</h3>
    <a href="{{ url('users/create') }}" class="btn marron-btn"><i class="fa fa-plus"></i></a>
    </div>
</div>
<table class="table table-bordered text-center">
 <thead>
    
     <th>#</th>
     <th>الاسم</th>
     <th>الرقم</th>
     <th>الدور</th>
     <th>الفرع</th>    
     <th>الاجرائات</th>
 </thead>

 @foreach($users as $user)
 <tbody>
    <td>{{ $index++ }}</td>
    <td>{{ $user->name }}</td>
    <td>{{ $user->phone }}</td>
    <td>{{ $user->role->name }}</td>
    <td>
        @if($user->branch)
        {{ $user->branch->name }}
        @endif
        
    </td>
    <td>
        <a href='{{ url("users/edit/$user->id") }}' class="btn marron-btn ms-2" style="display: inline-block;"><i class="fa fa-pencil"></i></a>
        <form action='{{ url("users/delete/$user->id") }}'style="display: inline-block;"  method="post">
         @csrf 
         <button href='{{ url("users/delete/$user->id") }}' class="btn marron-outline-btn"><i class="fa fa-trash"></i></button>

        </form>
    </td>
   
   
 </tbody>

 @endforeach
</table>
@endsection