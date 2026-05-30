<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Models\Notification;

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
            'name'                    => 'required|max:255',
            'category'                => 'required|in:Buket Segar,Buket Kering,Pampas,Mini Bouquet',
            'image'                   => 'required|image|mimes:jpg,jpeg,png|max:20480',
            'description'             => 'nullable|string',
            'color'                   => 'required|string|max:255',
            'variants'                => 'required|array|min:1',
            'variants.*.name'         => 'required|string|max:255',
            'variants.*.price'        => 'required|string',
        ]);

        $id = strtoupper(Str::random(12));

        $color = collect(explode(',', $request->color))
            ->map(function ($item) {
                $item = preg_replace('/\s+/', ' ', $item);

                return trim(
                    ucwords(strtolower($item))
                );
            })
            ->filter()
            ->unique()
            ->implode(', ');

        $variants = collect($request->variants)
            ->map(function ($variant) {

                $price = preg_replace('/[^0-9]/', '', $variant['price']);

                return [
                    'name'  => trim($variant['name']),
                    'price' => (int) $price,
                ];
            })
            ->filter(function ($variant) {
                return $variant['name'] !== '' && $variant['price'] !== null;
            })
            ->values()
            ->toArray();

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

        $product = Product::create([
            'id'          => $id,
            'name'        => $request->name,
            'category'    => $request->category,
            'description' => $request->description,
            'image'       => $imagePath,
            'color'       => $color,
            'variants'    => $variants,
        ]);

        Notification::create([
            'id' => (string) Str::ulid(),
            'type' => 'product',
            'reference_id' => $product->id,
            'reference_type' => Product::class,
            'title' => 'Produk Baru',
            'message' => $product->name,
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
            'name'                    => 'required|max:255',
            'category'                => 'required|in:Buket Segar,Buket Kering,Pampas,Mini Bouquet',
            'image'                   => 'nullable|image|mimes:jpg,jpeg,png|max:20480',
            'description'             => 'nullable|string',
            'color'                   => 'required|string|max:255',
            'variants'                => 'required|array|min:1',
            'variants.*.name'         => 'required|string|max:255',
            'variants.*.price'        => 'required|string',
        ]);

        $color = collect(explode(',', $request->color))
            ->map(function ($item) {

                $item = preg_replace('/\s+/', ' ', $item);

                return trim(
                    ucwords(strtolower($item))
                );
            })
            ->filter()
            ->unique()
            ->implode(', ');

        $variants = collect($request->variants)
            ->map(function ($variant) {

                $price = preg_replace('/[^0-9]/', '', $variant['price']);

                return [
                    'name'  => trim($variant['name']),
                    'price' => (int) $price,
                ];
            })
            ->filter(function ($variant) {
                return $variant['name'] !== '' && $variant['price'] !== null;
            })
            ->values()
            ->toArray();

        $imagePath = $product->image;

        if ($request->hasFile('image')) {

            if (
                $product->image &&
                Storage::disk('public')->exists($product->image)
            ) {

                Storage::disk('public')->delete($product->image);
            }

            $imagePath = $request
                ->file('image')
                ->store('products', 'public');
        }

        $product->update([
            'name'        => $request->name,
            'category'    => $request->category,
            'description' => $request->description,
            'color'       => $color,
            'variants'    => $variants,
            'image'       => $imagePath,
        ]);

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Produk berhasil diperbarui.');
    }

    public function destroy(Product $product)
    {
        if (
            $product->image &&
            Storage::disk('public')->exists($product->image)
        ) {

            Storage::disk('public')->delete($product->image);
        }

        $product->delete();

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Produk berhasil dihapus.');
    }

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
