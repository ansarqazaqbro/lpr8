@extends('layouts.app')

@section('title', $dish->exists ? 'Редактировать блюдо: ' . $dish->name : 'Добавить новое блюдо')

@section('content')

{{-- Хлебные крошки --}}
<nav aria-label="breadcrumb" class="mb-4">
    <ol class="breadcrumb" style="font-size:.78rem;letter-spacing:.05em">
        <li class="breadcrumb-item">
            <a href="{{ route('catalog.index') }}" style="color:var(--clr-gold);text-decoration:none">Главная</a>
        </li>
        <li class="breadcrumb-item">
            <a href="{{ route('dishes.index') }}" style="color:var(--clr-gold);text-decoration:none">Управление меню</a>
        </li>
        <li class="breadcrumb-item active text-muted">
            {{ $dish->exists ? 'Редактирование' : 'Создание' }}
        </li>
    </ol>
</nav>

<div class="row justify-content-center">
    <div class="col-lg-8 col-md-10">

        <div class="text-center mb-2">
            <p class="page-eyebrow">База данных · {{ $dish->exists ? 'Редактирование записи' : 'Новая запись' }}</p>
            <h1 class="page-title" style="font-size: 2rem;">
                {{ $dish->exists ? 'Редактировать блюдо' : 'Добавить блюдо' }}
            </h1>
        </div>
        <div class="gold-divider mb-4"><i class="bi bi-pencil-square" style="font-size:.8rem"></i></div>

        {{-- Карточка формы --}}
        <div class="card border-0 shadow-sm" style="border-radius:4px;">
            <div class="card-body p-4 p-md-5">

                <form method="POST"
                      action="{{ $dish->exists ? route('dishes.update', $dish) : route('dishes.store') }}"
                      novalidate>
                    @csrf
                    @if($dish->exists)
                        @method('PUT')
                    @endif

                    {{-- Раздел меню --}}
                    <div class="mb-3">
                        <label for="menu_section_id"
                               class="form-label"
                               style="font-size:.72rem;letter-spacing:.1em;text-transform:uppercase;color:var(--clr-muted);font-weight:600">
                            Раздел меню <span style="color:var(--clr-gold)">*</span>
                        </label>
                        <select id="menu_section_id"
                                name="menu_section_id"
                                class="form-select @error('menu_section_id') is-invalid @enderror"
                                required>
                            <option value="">— Выберите раздел меню —</option>
                            @foreach($menuSections as $section)
                                <option value="{{ $section->id }}"
                                    {{ old('menu_section_id', $dish->menu_section_id) == $section->id ? 'selected' : '' }}>
                                    {{ $section->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('menu_section_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Название блюда --}}
                    <div class="mb-3">
                        <label for="name"
                               class="form-label"
                               style="font-size:.72rem;letter-spacing:.1em;text-transform:uppercase;color:var(--clr-muted);font-weight:600">
                            Название блюда <span style="color:var(--clr-gold)">*</span>
                        </label>
                        <input type="text"
                               id="name"
                               name="name"
                               class="form-control @error('name') is-invalid @enderror"
                               value="{{ old('name', $dish->name) }}"
                               placeholder="Например: Кале Цезарь с цыпленком"
                               minlength="2"
                               maxlength="127"
                               required>
                        <div class="form-text text-muted small">От 2 до 127 символов. Должно быть уникальным в пределах выбранного раздела.</div>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Описание состава / рецепта --}}
                    <div class="mb-3">
                        <label for="description"
                               class="form-label"
                               style="font-size:.72rem;letter-spacing:.1em;text-transform:uppercase;color:var(--clr-muted);font-weight:600">
                            Описание состава
                        </label>
                        <textarea id="description"
                                  name="description"
                                  class="form-control @error('description') is-invalid @enderror"
                                  rows="3"
                                  maxlength="1000"
                                  placeholder="Ингредиенты, соус, особенности подачи...">{{ old('description', $dish->description) }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Числовые поля: Вес, Цена, Калории в сетку --}}
                    <div class="row g-3 mb-3">
                        {{-- Вес --}}
                        <div class="col-md-4">
                            <label for="weight_g"
                                   class="form-label"
                                   style="font-size:.72rem;letter-spacing:.1em;text-transform:uppercase;color:var(--clr-muted);font-weight:600">
                                Вес (граммы) <span style="color:var(--clr-gold)">*</span>
                            </label>
                            <div class="input-group">
                                <input type="number"
                                       id="weight_g"
                                       name="weight_g"
                                       class="form-control @error('weight_g') is-invalid @enderror"
                                       value="{{ old('weight_g', $dish->weight_g) }}"
                                       min="10"
                                       max="2000"
                                       placeholder="250"
                                       required>
                                <span class="input-group-text bg-light text-muted">г</span>
                                @error('weight_g')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- Цена --}}
                        <div class="col-md-4">
                            <label for="price"
                                   class="form-label"
                                   style="font-size:.72rem;letter-spacing:.1em;text-transform:uppercase;color:var(--clr-muted);font-weight:600">
                                Цена (₸) <span style="color:var(--clr-gold)">*</span>
                            </label>
                            <div class="input-group">
                                <input type="number"
                                       step="0.01"
                                       id="price"
                                       name="price"
                                       class="form-control @error('price') is-invalid @enderror"
                                       value="{{ old('price', $dish->price) }}"
                                       min="0"
                                       placeholder="3500.00"
                                       required>
                                <span class="input-group-text bg-light text-muted">₸</span>
                                @error('price')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- Калории --}}
                        <div class="col-md-4">
                            <label for="calories"
                                   class="form-label"
                                   style="font-size:.72rem;letter-spacing:.1em;text-transform:uppercase;color:var(--clr-muted);font-weight:600">
                                Калории <span style="color:var(--clr-gold)">*</span>
                            </label>
                            <div class="input-group">
                                <input type="number"
                                       id="calories"
                                       name="calories"
                                       class="form-control @error('calories') is-invalid @enderror"
                                       value="{{ old('calories', $dish->calories) }}"
                                       min="0"
                                       max="3000"
                                       placeholder="450"
                                       required>
                                <span class="input-group-text bg-light text-muted">ккал</span>
                                @error('calories')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    {{-- Чекбокс Веган --}}
                    <div class="mb-4 pt-2">
                        <div class="form-check form-switch">
                            <input type="checkbox"
                                   class="form-check-input"
                                   role="switch"
                                   id="is_vegan"
                                   name="is_vegan"
                                   value="1"
                                   {{ old('is_vegan', $dish->is_vegan) ? 'checked' : '' }}>
                            <label class="form-check-label fw-semibold" for="is_vegan">
                                <i class="bi bi-leaf text-success me-1"></i>Вегетарианское блюдо (Vegan)
                            </label>
                        </div>
                        @error('is_vegan')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Кнопки действий --}}
                    <div class="d-flex gap-3 pt-3 border-top">
                        <button type="submit" class="btn btn-gold px-4">
                            <i class="bi bi-check-lg me-1"></i>{{ $dish->exists ? 'Сохранить изменения' : 'Создать блюдо' }}
                        </button>
                        <a href="{{ route('dishes.index') }}" class="btn btn-outline-gold">
                            <i class="bi bi-x-lg me-1"></i>Отмена
                        </a>
                    </div>

                </form>

            </div>
        </div>

    </div>
</div>

@endsection
