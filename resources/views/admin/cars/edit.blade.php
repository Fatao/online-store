@extends('layouts.admin')
@section('page-title', 'Изменить автомобиль')
@section('content')
<div class="dash-card">
    <form action="{{ route('admin.cars.update', $car) }}" method="POST" enctype="multipart/form-data">
        @include('admin.cars._form')
    </form>
</div>
@endsection