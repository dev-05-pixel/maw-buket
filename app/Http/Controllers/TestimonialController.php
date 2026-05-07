<?php

namespace App\Http\Controllers;

use App\Models\Testimonial;
use Illuminate\Http\Request;
use Stevebauman\Location\Facades\Location;

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
            'message' => 'required',
            'rating' => 'required|integer|min:1|max:5',
        ]);

        $location = 'Indonesia';

        // localhost testing
        $position = Location::get('8.8.8.8');

        // hosting nanti:
        // $position = Location::get($request->ip());

        if ($position) {

            $city = $position->cityName ?? '';
            $region = $position->regionName ?? '';

            $location = trim($city . ', ' . $region, ', ');
        }

        Testimonial::create([
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
