@extends('layouts.app')

@section('title', 'Меню ресторана')

@section('content')

{{-- ── Заголовок страницы ── --}}
<div class="text-center mb-2">
    <p class="page-eyebrow">Ansar havchik</p>
    <h1 class="page-title">Наше меню</h1>
</div>
<div class="gold-divider"><i class="bi bi-gem"></i></div>

{{-- ── Форма поиска и сортировки ── --}}
<form method="GET" action="{{ route('catalog.index') }}" class="search-bar">
    <div class="row g-2 align-items-end">
        <div class="col-md-6">
            <label for="q" class="form-label small fw-semibold text-uppercase"
                   style="letter-spacing:.1em;font-size:.7rem;color:var(--clr-muted)">
                Поиск блюда
            </label>
            <input type="text"
                   id="q" name="q"
                   class="form-control"
                   placeholder="Введите название..."
                   value="{{ $q }}">
        </div>
        <div class="col-md-3">
            <label for="sort" class="form-label small fw-semibold text-uppercase"
                   style="letter-spacing:.1em;font-size:.7rem;color:var(--clr-muted)">
                Сортировка
            </label>
            <select id="sort" name="sort" class="form-select">
                <option value="" {{ $sort === '' ? 'selected' : '' }}>— По умолчанию —</option>
                <option value="name"     {{ $sort === 'name'     ? 'selected' : '' }}>По названию</option>
                <option value="price"    {{ $sort === 'price'    ? 'selected' : '' }}>По цене</option>
                <option value="calories" {{ $sort === 'calories' ? 'selected' : '' }}>По калориям</option>
            </select>
        </div>
        <div class="col-md-3 d-flex gap-2">
            <button type="submit" class="btn btn-gold flex-grow-1">
                <i class="bi bi-search me-1"></i>Найти
            </button>
            @if($q || $sort)
                <a href="{{ route('catalog.index') }}" class="btn btn-outline-gold">
                    <i class="bi bi-x-lg"></i>
                </a>
            @endif
        </div>
    </div>
</form>

{{-- ── Сетка карточек ── --}}
@if(count($items) > 0)

<div class="row row-cols-1 row-cols-md-2 row-cols-xl-3 g-4">
    @foreach($items as $dish)
    <div class="col">
        <div class="dish-card">

            {{-- Фото --}}
            <div class="dish-card__img-wrap">
                <img src="{{ $dish['image'] }}"
                     alt="{{ $dish['name'] }}"
                     loading="lazy">
            </div>

            {{-- Тело карточки --}}
            <div class="dish-card__body">

                {{-- Метки --}}
                <div class="d-flex align-items-center gap-2 mb-2 flex-wrap">
                    <span class="badge-code">{{ $dish['code'] }}</span>
                    <a href="{{ route('catalog.section', ['section' => $dish['menu_section']]) }}"
                       class="badge-section">{{ $dish['menu_section'] }}</a>
                    @if($dish['is_vegan'])
                        <span class="badge-vegan">
                            <i class="bi bi-leaf me-1"></i>Веган
                        </span>
                    @endif
                </div>

                {{-- Название --}}
                <a href="{{ route('catalog.show', $dish['id']) }}"
                   class="dish-card__title d-block">{{ $dish['name'] }}</a>

                {{-- Состав --}}
                <p class="dish-card__desc">{{ $dish['description'] }}</p>

                {{-- Мета --}}
                <div class="d-flex gap-3 text-muted" style="font-size:.75rem">
                    <span><i class="bi bi-rulers me-1"></i>{{ $dish['weight_g'] }} г</span>
                    <span><i class="bi bi-fire me-1"></i>{{ $dish['calories'] }} ккал</span>
                </div>
            </div>

            {{-- Подвал карточки --}}
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

<p class="text-muted mt-3" style="font-size:.78rem">
    Найдено позиций: <strong>{{ count($items) }}</strong>
</p>

@else
<div class="text-center py-5">
    <i class="bi bi-search" style="font-size:2.5rem;color:var(--clr-gold-lt)"></i>
    <p class="mt-3" style="color:var(--clr-muted)">
        По запросу <strong>«{{ $q }}»</strong> ничего не найдено.
    </p>
    <a href="{{ route('catalog.index') }}" class="btn btn-outline-gold mt-1">Сбросить поиск</a>
</div>
@endif

@endsection
