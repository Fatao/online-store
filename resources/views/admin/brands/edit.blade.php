@extends('layouts.admin')
@section('page-title', 'Изменить бренд')
@section('content')
<div class="dash-card">
    <form action="{{ route('admin.brands.update', $brand) }}" method="POST" enctype="multipart/form-data">
        @include('admin.brands._form')
    </form>
</div>
@endsection