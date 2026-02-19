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
        Schema::create('products', function (Blueprint $table) {
            $table->char('uid', 36)->primary();

            $table->string('name');
            $table->string('slug')->unique();
            $table->decimal('price', 15, 2);

            $table->integer('stock')->default(0);
            $table->integer('sold_count')->default(0);
            $table->boolean('is_active')->default(true);

            $table->char('category_id', 36);

            $table->timestamps();

            $table->foreign('category_id')
                ->references('uid')
                ->on('categories')
                ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
