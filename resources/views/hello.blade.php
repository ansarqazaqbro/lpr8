@extends('layouts.app')

@section('title', 'Привет!')

@section('content')
<div class="text-center py-5">
    <h1 class="display-4">{{ $greeting }}</h1>
    <a href="{{ route('catalog.index') }}" class="btn btn-danger mt-3">
        <i class="bi bi-arrow-left me-1"></i>К меню
    </a>
</div>
@endsection
