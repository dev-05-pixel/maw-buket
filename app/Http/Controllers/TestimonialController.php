<?php

namespace App\Http\Controllers;

use App\Models\Testimonial;
use Illuminate\Http\Request;
use Stevebauman\Location\Facades\Location;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\RateLimiter;

class TestimonialController extends Controller
{
    public function index()
    {
        $testimonials = Testimonial::latest()->paginate(9);
        return view('testimonials.index', compact('testimonials'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:100',
            'message' => 'required|max:1000',
            'rating' => 'required|integer|min:1|max:5',
        ], [
            'message.max' => 'Pesan testimonial maksimal 1000 karakter.',
            'message.required' => 'Pesan testimonial wajib diisi.',
            'name.required' => 'Nama wajib diisi.',
            'rating.required' => 'Rating wajib dipilih.',
        ]);

        // =========================================
        // ANTI SPAM
        // =========================================
        $key = 'testimonial-' . $request->ip();

        if (RateLimiter::tooManyAttempts($key, 3)) {

            return back()
                ->withErrors([
                    'spam' => 'Terlalu banyak mengirim testimoni. Coba lagi beberapa saat lagi.'
                ])
                ->withInput();
        }

        RateLimiter::hit($key, 60);

        // =========================================
        // LOCATION
        // =========================================
        $location = 'Indonesia';
        $ip = app()->environment('local')
            ? '8.8.8.8'
            : $request->ip();

        $position = Location::get($ip);

        if ($position) {
            $city = $position->cityName ?? '';
            $region = $position->regionName ?? '';
            $location = trim($city . ', ' . $region, ', ');
        }

        // =========================================
        // SAVE
        // =========================================
        Testimonial::create([
            'id' => strtoupper(substr(uniqid(), -12)),
            'name' => $request->name,
            'message' => $request->message,
            'rating' => $request->rating,
            'location' => $location,
            'avatar_letter' => strtoupper(substr($request->name, 0, 1)),
            'ip_address' => $request->ip(),
        ]);

        return redirect()
            ->back()
            ->with('testimonial_success', true);
    }
}
