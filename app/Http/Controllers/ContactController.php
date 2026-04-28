<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class ContactController extends Controller
{
    public function show(): View
    {
        return view('contact');
    }

    public function send(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name'    => 'required|string|min:2|max:100',
            'contact' => 'required|string|min:2|max:200',
            'message' => 'required|string|min:10|max:2000',
        ]);

        $token  = config('services.telegram.bot_token');
        $chatId = config('services.telegram.chat_id');

        if ($token && $chatId) {
            $text = "<b>Сообщение с timcode.ru</b>\n\n"
                  . "<b>Имя:</b> " . e($data['name']) . "\n"
                  . "<b>Контакт:</b> " . e($data['contact']) . "\n\n"
                  . e($data['message']);

            $proxy = config('services.telegram.proxy');
            $http = Http::timeout(5);

            if ($proxy) {
                $http = $http->withOptions(['proxy' => $proxy]);
            }

            $response = $http->post("https://api.telegram.org/bot{$token}/sendMessage", [
                'chat_id'    => $chatId,
                'text'       => $text,
                'parse_mode' => 'HTML',
            ]);

            if (! $response->successful()) {
                Log::error('Telegram send failed', ['status' => $response->status(), 'body' => $response->body()]);
            }
        }

        return redirect('/contact')->with('success', 'Сообщение отправлено. Отвечу в ближайшее время.');
    }
}
