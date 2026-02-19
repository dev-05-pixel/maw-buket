<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\Product;

class AdminStats extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Produk', Product::count()),
            Stat::make('Total Stok', Product::sum('stock')),
            Stat::make('Produk Aktif', Product::where('is_active', true)->count()),
            Stat::make('Terjual', Product::sum('sold_count')),
        ];
    }
}
