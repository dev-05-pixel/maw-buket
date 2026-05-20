<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 10);

        $products = Product::latest()
            ->paginate($perPage)
            ->withQueryString();

        return view('admin.products.index', compact('products', 'perPage'));
    }

    public function create()
    {
        $colors = $this->getColors();

        return view('admin.products.create', compact('colors'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required|max:255',
            'category'    => 'required|in:Buket Segar,Buket Kering,Pampas,Mini Bouquet',
            'price'       => 'required|numeric|min:1000',
            'image'       => 'required|image|mimes:jpg,jpeg,png|max:20480',
            'description' => 'nullable|string',
            'color'       => 'required|string|max:255',
            'sizes'       => 'required|array|min:1',
            'sizes.*'     => 'string',
        ]);

        /*
        |--------------------------------------------------------------------------
        | GENERATE ID
        |--------------------------------------------------------------------------
        */
        $id = strtoupper(Str::random(12));

        /*
        |--------------------------------------------------------------------------
        | NORMALISASI WARNA
        |--------------------------------------------------------------------------
        |
        | Input:
        | pink, dusty pink, peach
        |
        | Output:
        | Pink, Dusty Pink, Peach
        |
        */
        $color = collect(explode(',', $request->color))
            ->map(function ($item) {

                $item = preg_replace('/\s+/', ' ', $item);
                return trim(ucwords(strtolower($item)));
            })
            ->filter()
            ->unique()
            ->implode(', ');

        /*
        |--------------------------------------------------------------------------
        | NORMALISASI SIZE
        |--------------------------------------------------------------------------
        */
        $size = collect($request->sizes)
            ->map(function ($item) {

                return trim($item);
            })
            ->filter()
            ->unique()
            ->implode(', ');

        /*
        |--------------------------------------------------------------------------
        | UPLOAD IMAGE
        |--------------------------------------------------------------------------
        */
        $imagePath = null;

        if ($request->hasFile('image')) {

            $imagePath = $request
                ->file('image')
                ->store('products', 'public');
        }

        if (!$imagePath) {

            return back()
                ->withErrors([
                    'image' => 'Upload gagal'
                ])
                ->withInput();
        }

        /*
        |--------------------------------------------------------------------------
        | CREATE PRODUCT
        |--------------------------------------------------------------------------
        */
        Product::create([
            'id'          => $id,
            'name'        => $request->name,
            'price'       => $request->price,
            'category'    => $request->category,
            'description' => $request->description,
            'image'       => $imagePath,
            'color'       => $color,
            'size'        => $size,
        ]);

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Produk berhasil ditambahkan.');
    }

    public function edit(Product $product)
    {
        $colors = $this->getColors();

        return view('admin.products.edit', compact(
            'product',
            'colors'
        ));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name'        => 'required|max:255',
            'category'    => 'required|in:Buket Segar,Buket Kering,Pampas,Mini Bouquet',
            'price'       => 'required|numeric|min:1000',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png|max:20480',
            'description' => 'nullable|string',
            'color'       => 'required|string|max:255',
            'sizes'       => 'required|array|min:1',
            'sizes.*'     => 'string',
        ]);

        /*
        |--------------------------------------------------------------------------
        | NORMALISASI WARNA
        |--------------------------------------------------------------------------
        */
        $color = collect(explode(',', $request->color))
            ->map(function ($item) {
                $item = preg_replace('/\s+/', ' ', $item);
                return trim(ucwords(strtolower($item)));
            })
            ->filter()
            ->unique()
            ->implode(', ');

        /*
        |--------------------------------------------------------------------------
        | NORMALISASI SIZE
        |--------------------------------------------------------------------------
        */
        $size = collect($request->sizes)
            ->map(function ($item) {

                return trim($item);
            })
            ->filter()
            ->unique()
            ->implode(', ');

        /*
        |--------------------------------------------------------------------------
        | IMAGE
        |--------------------------------------------------------------------------
        */
        $imagePath = $product->image;

        if ($request->hasFile('image')) {

            /*
            |--------------------------------------------------------------------------
            | HAPUS IMAGE LAMA
            |--------------------------------------------------------------------------
            */
            if (
                $product->image &&
                Storage::disk('public')->exists($product->image)
            ) {

                Storage::disk('public')->delete($product->image);
            }

            /*
            |--------------------------------------------------------------------------
            | UPLOAD IMAGE BARU
            |--------------------------------------------------------------------------
            */
            $imagePath = $request
                ->file('image')
                ->store('products', 'public');
        }

        /*
        |--------------------------------------------------------------------------
        | UPDATE PRODUCT
        |--------------------------------------------------------------------------
        */
        $product->update([
            'name'        => $request->name,
            'price'       => $request->price,
            'category'    => $request->category,
            'description' => $request->description,
            'color'       => $color,
            'size'        => $size,
            'image'       => $imagePath,
        ]);

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Produk berhasil diperbarui.');
    }

    public function destroy(Product $product)
    {
        /*
        |--------------------------------------------------------------------------
        | DELETE IMAGE
        |--------------------------------------------------------------------------
        */
        if (
            $product->image &&
            Storage::disk('public')->exists($product->image)
        ) {

            Storage::disk('public')->delete($product->image);
        }

        /*
        |--------------------------------------------------------------------------
        | DELETE PRODUCT
        |--------------------------------------------------------------------------
        */
        $product->delete();

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Produk berhasil dihapus.');
    }

    /**
     * Ambil daftar warna unik dari database
     */
    private function getColors()
    {
        return Product::select('color')
            ->whereNotNull('color')
            ->pluck('color')
            ->flatMap(function ($item) {

                return explode(',', $item);
            })

            ->map(function ($item) {
                return trim($item);
            })

            ->filter()
            ->unique()
            ->sort()
            ->values();
    }
}
