<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function index(Request $request)
    {
        $perPage  = $request->get('per_page', 10);
        $messages = ContactMessage::latest()->paginate($perPage)->withQueryString();

        return view('admin.messages.index', compact('messages', 'perPage'));
    }

    public function show(ContactMessage $message)
    {
        // Tandai sudah dibaca
        if (!$message->is_read) {
            $message->update(['is_read' => true]);
        }

        return view('admin.messages.show', compact('message'));
    }

    public function destroy(ContactMessage $message)
    {
        $message->delete();

        return redirect()
            ->route('admin.messages.index')
            ->with('success', 'Pesan berhasil dihapus.');
    }
}
