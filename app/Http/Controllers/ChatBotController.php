<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ChatBotController extends Controller
{
    public function sendChat(Request $request)
    {
        $message = $request->input('message');

        // Configuración de Hugging Face
        $apiKey = config('huggingface.api_key');
        $model = config('huggingface.model');
        $endpoint = config('huggingface.endpoint') . $model;

        // Realizar la solicitud a Hugging Face
        $response = Http::withHeaders([
            'Authorization' => "Bearer $apiKey",
            'Content-Type' => 'application/json',
        ])->post($endpoint, [
            'inputs' => $message,
        ]);

        // Obtener la respuesta del modelo
        $data = $response->json();

        // Manejar posibles errores
        if ($response->failed() || empty($data)) {
            return response()->json(['response' => 'Hubo un error con la API de Hugging Face.'], 500);
        }

        // Obtener el texto de la respuesta
        $responseText = $data[0]['generated_text'] ?? 'No se pudo generar una respuesta.';

        return response()->json(['response' => $responseText]);
    }
}
