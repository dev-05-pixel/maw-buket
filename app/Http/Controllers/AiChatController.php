<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AiChatController extends Controller
{
    public function chat(Request $request)
    {
        $request->validate([
            'message' => 'required|string'
        ]);

        // Kirim ke Python AI / Flask / FastAPI
        $response = Http::post('http://127.0.0.1:5000/chat', [
            'message' => $request->message
        ]);

        return response()->json([
            'reply' => $response->json()['reply'] ?? 'No response'
        ]);
    }
}