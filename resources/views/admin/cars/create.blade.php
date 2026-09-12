@extends('layouts.admin')
@section('page-title', 'Новый автомобиль')
@section('content')
<div class="dash-card">
    <form action="{{ route('admin.cars.store') }}" method="POST" enctype="multipart/form-data">
        @include('admin.cars._form')
    </form>
</div>
@endsection