<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
use Illuminate\Http\Request;
use App\Models\Notification;
use Illuminate\Support\Str;

class ContactController extends Controller
{
    public function index()
    {
        return view('contact');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'       => 'required|string|max:255',
            'phone'      => 'required|string|max:20',
            'email'      => 'nullable|email|max:255',
            'purpose'    => 'required|string|max:100',
            'color_pref' => 'nullable|string|max:100',
            'message'    => 'required|string|max:600',
        ]);

        $message = ContactMessage::create($validated);

        Notification::create([
            'id' => (string) Str::ulid(),
            'type' => 'message',
            'reference_id' => $message->id,
            'reference_type' => ContactMessage::class,
            'title' => 'Pesan Masuk',
            'message' => $message->name,
        ]);

        return response()->json(['success' => true]);
    }
}
