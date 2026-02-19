<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            'Wisuda',
            'Ulang Tahun',
            'Anniversary',
            'Pernikahan',
            'Valentine',
            'Bunga Mawar',
            'Bunga Tulip',
            'Bunga Lily',
            'Snack',
            'Buket Uang',
            'Buket Coklat',
            'Buket Boneka',
            'Custom',
            'Buket Mini',
            'Premium',
            'Standing Flower',
            'Flower Box',
            'Hand Bouquet',
            'Artificial Flower',
        ];

        foreach ($categories as $name) {
            Category::create([
                'uid' => (string) Str::uuid(),
                'name' => $name,
                'slug' => Str::slug($name),
            ]);
        }
    }
}
