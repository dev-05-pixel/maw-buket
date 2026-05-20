<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
use Illuminate\Http\Request;

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

        ContactMessage::create($validated);

        return response()->json(['success' => true]);
    }
}
