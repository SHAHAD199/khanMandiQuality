@extends('layouts.layout')

@section('content')

<div class="heading mb-4">
    <h2>اضافة تقييمات الامس</h2>
</div>
<form action="{{ url('excel/store') }}" method="post" enctype="multipart/form-data">
    @csrf 
    <div class="row">
        <div class="col-md-2">
            <label for="file">اختر ملف</label>
        </div>
        <div class="col-md-8">
            <input type="file" class="form-control" name="file" id="file">
        </div>
    </div>

<button class="btn marron-btn">تحميل</button>
</form>
@endsection