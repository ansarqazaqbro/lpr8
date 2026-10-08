<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    /**
     * Форма обратной связи.
     */
    public function feedbackForm()
    {
        return view('feedback');
    }

    /**
     * Обработка отправки формы обратной связи.
     */
    public function feedbackSend(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'message' => 'required|string|max:2000',
        ]);

        // Здесь можно сохранить сообщение или отправить письмо
        // В рамках учебной работы просто возвращаем flash-статус

        return redirect()->route('feedback.form')
            ->with('status', 'Спасибо, '.htmlspecialchars($request->input('name')).'! Ваше сообщение отправлено.');
    }
}
