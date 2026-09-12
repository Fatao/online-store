@extends('layouts.admin')
@section('page-title', 'Новый бренд')
@section('content')
<div class="dash-card">
    <form action="{{ route('admin.brands.store') }}" method="POST" enctype="multipart/form-data">
        @include('admin.brands._form')
    </form>
</div>
@endsection