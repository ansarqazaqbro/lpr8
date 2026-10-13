@extends('layouts.app')

@section('title', 'Управление меню (CRUD)')

@section('content')

{{-- ── Заголовок страницы ── --}}
<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-3 gap-3">
    <div>
        <p class="page-eyebrow mb-1">Панель управления · База данных</p>
        <h1 class="page-title mb-0" style="font-size: 2rem;">Управление блюдами (CRUD)</h1>
    </div>
    <div>
        <a href="{{ route('dishes.create') }}" class="btn btn-gold">
            <i class="bi bi-plus-circle me-1"></i>Добавить блюдо
        </a>
    </div>
</div>

<div class="gold-divider"><i class="bi bi-sliders"></i></div>

{{-- ── Форма поиска ── --}}
<form method="GET" action="{{ route('dishes.index') }}" class="search-bar">
    <div class="row g-2 align-items-end">
        <div class="col-md-9">
            <label for="q" class="form-label small fw-semibold text-uppercase"
                   style="letter-spacing:.1em;font-size:.7rem;color:var(--clr-muted)">
                Поиск по названию блюда
            </label>
            <div class="input-group">
                <span class="input-group-text bg-white border-end-0">
                    <i class="bi bi-search text-muted"></i>
                </span>
                <input type="text"
                       id="q"
                       name="q"
                       class="form-control border-start-0"
                       placeholder="Введите название блюда..."
                       value="{{ $q }}">
            </div>
        </div>
        <div class="col-md-3 d-flex gap-2">
            <button type="submit" class="btn btn-gold flex-grow-1">
                Найти
            </button>
            @if($q)
                <a href="{{ route('dishes.index') }}" class="btn btn-outline-gold">
                    <i class="bi bi-x-lg"></i>
                </a>
            @endif
        </div>
    </div>
</form>

{{-- ── Список блюд ── --}}
@if($dishes->count() > 0)
    <div class="card border-0 shadow-sm mb-4" style="border-radius:4px; overflow:hidden;">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead style="background-color: var(--clr-header); color: var(--clr-gold-lt); font-size: 0.8rem; letter-spacing: 0.08em; text-transform: uppercase;">
                    <tr>
                        <th class="ps-3 py-3" style="width: 60px;">ID</th>
                        <th class="py-3">Название</th>
                        <th class="py-3">Раздел меню</th>
                        <th class="py-3 text-center">Вес</th>
                        <th class="py-3 text-end">Цена</th>
                        <th class="py-3 text-center">Калории</th>
                        <th class="py-3 text-center">Веган</th>
                        <th class="py-3 pe-3 text-end" style="width: 170px;">Действия</th>
                    </tr>
                </thead>
                <tbody style="font-size: 0.9rem;">
                    @foreach($dishes as $dish)
                    <tr>
                        <td class="ps-3 text-muted fw-semibold">
                            #{{ $dish->id }}
                        </td>
                        <td>
                            <div class="fw-bold text-dark font-serif" style="font-size: 1rem;">
                                {{ $dish->name }}
                            </div>
                            @if($dish->description)
                                <div class="text-muted small text-truncate" style="max-width: 320px;">
                                    {{ $dish->description }}
                                </div>
                            @endif
                        </td>
                        <td>
                            <span class="badge-section">
                                {{ $dish->menuSection->name ?? '—' }}
                            </span>
                        </td>
                        <td class="text-center text-muted">
                            {{ $dish->weight_g }} г
                        </td>
                        <td class="text-end fw-bold" style="color: var(--clr-header);">
                            {{ number_format($dish->price, 2, '.', ' ') }} ₸
                        </td>
                        <td class="text-center text-muted">
                            {{ $dish->calories }} ккал
                        </td>
                        <td class="text-center">
                            @if($dish->is_vegan)
                                <span class="badge-vegan">
                                    <i class="bi bi-leaf me-1"></i>Да
                                </span>
                            @else
                                <span class="badge text-bg-light text-muted border">Нет</span>
                            @endif
                        </td>
                        <td class="pe-3 text-end">
                            <div class="d-inline-flex gap-1">
                                <a href="{{ route('dishes.edit', $dish) }}"
                                   class="btn btn-sm btn-outline-gold"
                                   title="Редактировать">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('dishes.destroy', $dish) }}"
                                      method="POST"
                                      onsubmit="return confirm('Вы действительно хотите удалить блюдо «{{ $dish->name }}»?');"
                                      class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="btn btn-sm btn-outline-danger"
                                            title="Удалить">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- Пагинация --}}
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-center gap-3">
        <div class="text-muted small">
            Показано с <strong>{{ $dishes->firstItem() }}</strong> по <strong>{{ $dishes->lastItem() }}</strong> из <strong>{{ $dishes->total() }}</strong> блюд (по {{ $dishes->perPage() }} на странице)
        </div>
        <div>
            {{ $dishes->links() }}
        </div>
    </div>

@else
    <div class="text-center py-5 bg-white rounded shadow-sm border">
        <i class="bi bi-journal-x" style="font-size:2.5rem;color:var(--clr-gold-lt)"></i>
        <p class="mt-3 mb-2 fw-semibold" style="color:var(--clr-header)">
            @if($q)
                По запросу «{{ $q }}» блюда не найдены
            @else
                В базе данных пока нет блюд
            @endif
        </p>
        <p class="text-muted small mb-3">
            @if($q)
                Попробуйте изменить поисковый запрос или сбросить фильтр.
            @else
                Добавьте первое блюдо с помощью кнопки ниже.
            @endif
        </p>
        @if($q)
            <a href="{{ route('dishes.index') }}" class="btn btn-outline-gold btn-sm">
                Сбросить поиск
            </a>
        @else
            <a href="{{ route('dishes.create') }}" class="btn btn-gold btn-sm">
                <i class="bi bi-plus-circle me-1"></i>Добавить блюдо
            </a>
        @endif
    </div>
@endif

@endsection
