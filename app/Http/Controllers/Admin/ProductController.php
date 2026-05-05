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
            'color'       => 'required|string|max:50',
            'size'        => 'required|in:S,M,L',
        ]);

        $id = strtoupper(Str::random(12));

        // Normalisasi warna (rapikan spasi + kapitalisasi)
        $color = preg_replace('/\s+/', ' ', $request->color);
        $color = trim(ucwords(strtolower($color)));

        // Upload image
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
        }

        if (!$imagePath) {
            return back()
                ->withErrors(['image' => 'Upload gagal'])
                ->withInput();
        }

        Product::create([
            'id'          => $id,
            'name'        => $request->name,
            'price'       => $request->price,
            'category'    => $request->category,
            'description' => $request->description,
            'image'       => $imagePath,
            'color'       => $color,
            'size'        => $request->size,
        ]);

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Produk berhasil ditambahkan.');
    }

    public function edit(Product $product)
    {
        $colors = $this->getColors();

        return view('admin.products.edit', compact('product', 'colors'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name'        => 'required|max:255',
            'category'    => 'required|in:Buket Segar,Buket Kering,Pampas,Mini Bouquet',
            'price'       => 'required|numeric|min:1000',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png|max:20480',
            'description' => 'nullable|string',
            'color'       => 'required|string|max:50',
            'size'        => 'required|in:S,M,L',
        ]);

        // Normalisasi warna
        $color = preg_replace('/\s+/', ' ', $request->color);
        $color = trim(ucwords(strtolower($color)));

        $imagePath = $product->image;

        if ($request->hasFile('image')) {

            // Hapus image lama jika ada
            if ($product->image && Storage::disk('public')->exists($product->image)) {
                Storage::disk('public')->delete($product->image);
            }

            $imagePath = $request->file('image')->store('products', 'public');
        }

        $product->update([
            'name'        => $request->name,
            'price'       => $request->price,
            'category'    => $request->category,
            'description' => $request->description,
            'color'       => $color,
            'size'        => $request->size,
            'image'       => $imagePath,
        ]);

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Produk berhasil diperbarui.');
    }

    public function destroy(Product $product)
    {
        if ($product->image && Storage::disk('public')->exists($product->image)) {
            Storage::disk('public')->delete($product->image);
        }

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
            ->distinct()
            ->pluck('color');
    }
}
