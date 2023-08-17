@extends('layouts.layout')
@section('content')

<div class="card px-4 py-3">
    <div class="heading-card d-flex justify-content-between">
    <h3 class="marron-color">جميع الادوار</h3>
    <a href="{{ url('roles/create') }}" class="btn marron-btn"><i class="fa fa-plus"></i></a>
    </div>
</div>

<table class="table table-bordered text-center">
 <thead>
    
     <th>#</th>
     <th>الاسم</th>
    
 </thead>

 @foreach($roles as $role)
 <tbody>
    <td>{{ $index++ }}</td>
    <td>{{ $role->name }}</td>

 </tbody>

 @endforeach
</table>
@endsection
