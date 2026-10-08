@extends('layouts.app')

@section('title', $section ? 'Раздел: ' . $section : 'Все разделы')

@section('content')

{{-- Заголовок --}}
<div class="text-center mb-2">
    <p class="page-eyebrow">Traditional Home · Меню</p>
    <h1 class="page-title">{{ $section ?? 'Все разделы' }}</h1>
</div>
<div class="gold-divider"><i class="bi bi-gem"></i></div>

{{-- Навигация по разделам --}}
<div class="d-flex flex-wrap justify-content-center gap-2 mb-4">
    <a href="{{ route('catalog.section') }}"
       class="btn btn-sm {{ !$section ? 'btn-gold' : 'btn-outline-gold' }}">
        Все
    </a>
    @foreach($sections as $sec)
    <a href="{{ route('catalog.section', ['section' => $sec]) }}"
       class="btn btn-sm {{ $section === $sec ? 'btn-gold' : 'btn-outline-gold' }}">
        {{ $sec }}
    </a>
    @endforeach
</div>

@if(count($items) > 0)
<div class="row row-cols-1 row-cols-md-2 row-cols-xl-3 g-4">
    @foreach($items as $dish)
    <div class="col">
        <div class="dish-card">
            <div class="dish-card__img-wrap">
                <img src="{{ $dish['image'] }}" alt="{{ $dish['name'] }}" loading="lazy">
            </div>
            <div class="dish-card__body">
                <div class="d-flex align-items-center gap-2 mb-2 flex-wrap">
                    <span class="badge-code">{{ $dish['code'] }}</span>
                    @if($dish['is_vegan'])
                        <span class="badge-vegan"><i class="bi bi-leaf me-1"></i>Веган</span>
                    @endif
                </div>
                <a href="{{ route('catalog.show', $dish['id']) }}"
                   class="dish-card__title d-block">{{ $dish['name'] }}</a>
                <p class="dish-card__desc">{{ $dish['description'] }}</p>
                <div class="d-flex gap-3 text-muted" style="font-size:.75rem">
                    <span><i class="bi bi-rulers me-1"></i>{{ $dish['weight_g'] }} г</span>
                    <span><i class="bi bi-fire me-1"></i>{{ $dish['calories'] }} ккал</span>
                </div>
            </div>
            <div class="dish-card__footer">
                <span class="dish-price">{{ number_format($dish['price'], 0, '.', ' ') }} ₸</span>
                <a href="{{ route('catalog.show', $dish['id']) }}" class="btn btn-gold btn-sm">
                    Подробнее
                </a>
            </div>
        </div>
    </div>
    @endforeach
</div>
@else
<div class="text-center py-5">
    <i class="bi bi-grid" style="font-size:2.5rem;color:var(--clr-gold-lt)"></i>
    <p class="mt-3" style="color:var(--clr-muted)">В этом разделе пока нет блюд.</p>
    <a href="{{ route('catalog.section') }}" class="btn btn-outline-gold mt-1">Все разделы</a>
</div>
@endif

@endsection
