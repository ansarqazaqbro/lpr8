@extends('layouts.app')

@section('title', $dish['name'])

@section('content')

{{-- Хлебные крошки --}}
<nav aria-label="breadcrumb" class="mb-4">
    <ol class="breadcrumb" style="font-size:.78rem;letter-spacing:.05em">
        <li class="breadcrumb-item">
            <a href="{{ route('catalog.index') }}" style="color:var(--clr-gold);text-decoration:none">Меню</a>
        </li>
        <li class="breadcrumb-item">
            <a href="{{ route('catalog.section', ['section' => $dish['menu_section']]) }}"
               style="color:var(--clr-gold);text-decoration:none">{{ $dish['menu_section'] }}</a>
        </li>
        <li class="breadcrumb-item active text-muted">{{ $dish['name'] }}</li>
    </ol>
</nav>

<div class="row g-5 align-items-start">

    {{-- ── Фото блюда (слева) ── --}}
    <div class="col-md-5">
        <div style="border-radius:4px;overflow:hidden;box-shadow:0 12px 40px rgba(44,14,20,.15);">
            <img src="{{ $dish['image'] }}"
                 alt="{{ $dish['name'] }}"
                 class="img-fluid w-100"
                 style="object-fit:cover;max-height:480px;">
        </div>
    </div>

    {{-- ── Детали (справа) ── --}}
    <div class="col-md-7">

        {{-- Метки --}}
        <div class="d-flex flex-wrap gap-2 mb-3">
            <span class="badge-code">{{ $dish['code'] }}</span>
            <a href="{{ route('catalog.section', ['section' => $dish['menu_section']]) }}"
               class="badge-section">{{ $dish['menu_section'] }}</a>
            @if($dish['is_vegan'])
                <span class="badge-vegan"><i class="bi bi-leaf me-1"></i>Вегетарианское</span>
            @endif
        </div>

        {{-- Название --}}
        <h1 class="page-title mb-1">{{ $dish['name'] }}</h1>
        <div class="gold-divider my-3"><i class="bi bi-diamond-fill" style="font-size:.6rem"></i></div>

        {{-- Цена --}}
        <div class="mb-4">
            <span class="dish-price" style="font-size:2rem">
                {{ number_format($dish['price'], 0, '.', ' ') }} ₸
            </span>
        </div>

        {{-- Описание --}}
        <p style="color:var(--clr-muted);line-height:1.75;font-size:.9rem;margin-bottom:1.75rem">
            {{ $dish['description'] }}
        </p>

        {{-- Характеристики --}}
        <dl class="row" style="font-size:.88rem;border-top:1px solid var(--clr-border);padding-top:1.25rem">

            <dt class="col-5 text-muted fw-normal">Вес</dt>
            <dd class="col-7 fw-semibold">{{ $dish['weight_g'] }} г</dd>

            <dt class="col-5 text-muted fw-normal">Калорийность</dt>
            <dd class="col-7 fw-semibold">{{ $dish['calories'] }} ккал</dd>

            <dt class="col-5 text-muted fw-normal">Вегетарианское</dt>
            <dd class="col-7">
                @if($dish['is_vegan'])
                    <span class="badge-vegan"><i class="bi bi-leaf me-1"></i>Да</span>
                @else
                    <span class="text-muted">Нет</span>
                @endif
            </dd>

            <dt class="col-5 text-muted fw-normal">Раздел меню</dt>
            <dd class="col-7">
                <a href="{{ route('catalog.section', ['section' => $dish['menu_section']]) }}"
                   class="badge-section">{{ $dish['menu_section'] }}</a>
            </dd>

            <dt class="col-5 text-muted fw-normal">Код блюда</dt>
            <dd class="col-7">
                <a href="{{ route('catalog.code', $dish['code']) }}"
                   class="badge-code text-decoration-none" style="font-size:.78rem">
                    {{ $dish['code'] }}
                </a>
            </dd>

        </dl>

        {{-- Действия --}}
        <div class="d-flex gap-3 mt-4">
            <a href="{{ route('catalog.index') }}" class="btn btn-gold">
                <i class="bi bi-arrow-left me-1"></i>Назад к меню
            </a>
            <a href="{{ route('catalog.section', ['section' => $dish['menu_section']]) }}"
               class="btn btn-outline-gold">
                Все блюда раздела
            </a>
        </div>

    </div>
</div>

@endsection
