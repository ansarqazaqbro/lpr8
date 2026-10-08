@extends('layouts.app')

@section('title', 'Обратная связь')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-6 col-md-8">

        <div class="text-center mb-2">
            <p class="page-eyebrow">Ansar havchik</p>
            <h1 class="page-title" style="font-size:1.9rem">Обратная связь</h1>
        </div>
        <div class="gold-divider mb-4"><i class="bi bi-envelope" style="font-size:.8rem"></i></div>

        <div class="card border-0 shadow-sm" style="border-radius:4px">
            <div class="card-body p-4">
                <form method="POST" action="{{ route('feedback.send') }}" novalidate>
                    @csrf

                    {{-- Имя --}}
                    <div class="mb-3">
                        <label for="name" class="form-label"
                               style="font-size:.72rem;letter-spacing:.1em;text-transform:uppercase;color:var(--clr-muted);font-weight:600">
                            Ваше имя <span style="color:var(--clr-gold)">*</span>
                        </label>
                        <input type="text"
                               id="name" name="name"
                               class="form-control @error('name') is-invalid @enderror"
                               value="{{ old('name') }}"
                               required maxlength="255"
                               placeholder="Иванов Иван">
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Сообщение --}}
                    <div class="mb-4">
                        <label for="message" class="form-label"
                               style="font-size:.72rem;letter-spacing:.1em;text-transform:uppercase;color:var(--clr-muted);font-weight:600">
                            Сообщение <span style="color:var(--clr-gold)">*</span>
                        </label>
                        <textarea id="message" name="message"
                                  class="form-control @error('message') is-invalid @enderror"
                                  rows="5" required maxlength="2000"
                                  placeholder="Напишите ваш вопрос или отзыв...">{{ old('message') }}</textarea>
                        @error('message')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex gap-3">
                        <button type="submit" class="btn btn-gold">
                            <i class="bi bi-send me-1"></i>Отправить
                        </button>
                        <a href="{{ route('catalog.index') }}" class="btn btn-outline-gold">
                            <i class="bi bi-arrow-left me-1"></i>Назад
                        </a>
                    </div>

                </form>
            </div>
        </div>

    </div>
</div>
@endsection
