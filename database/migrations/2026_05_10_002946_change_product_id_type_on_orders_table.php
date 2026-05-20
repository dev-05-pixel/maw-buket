<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->string('new_id', 12)->nullable()->after('id');
        });

        $orders = DB::table('orders')->get();

        foreach ($orders as $order) {
            DB::table('orders')
                ->where('id', $order->id)
                ->update([
                    'new_id' => strtoupper(Str::random(12)),
                ]);
        }

        DB::statement('ALTER TABLE orders MODIFY id BIGINT NOT NULL');

        DB::statement('ALTER TABLE orders DROP PRIMARY KEY');

        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('id');
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->renameColumn('new_id', 'id');
        });

        DB::statement('ALTER TABLE orders ADD PRIMARY KEY (id)');
    }

    public function down(): void
    {
        //
    }
};
