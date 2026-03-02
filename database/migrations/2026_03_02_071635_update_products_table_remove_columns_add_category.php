<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // hapus column
            $table->dropColumn(['slug', 'stock', 'is_active']);

            // tambah column baru
            $table->string('category', 32)->after('name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // kembalikan column yang dihapus
            $table->string('slug', 255);
            $table->integer('stock')->nullable();
            $table->tinyInteger('is_active')->default(1);

            // hapus category jika rollback
            $table->dropColumn('category');
        });
    }
};
