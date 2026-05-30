<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('notifications', function (Blueprint $table) {

            $table->string('id', 28)->primary();

            $table->string('type', 50);

            $table->string('reference_id', 28);
            $table->string('reference_type', 100);

            $table->string('title');
            $table->text('message');

            $table->boolean('is_read')
                ->default(false);

            $table->timestamp('read_at')
                ->nullable();

            $table->timestamps();

            $table->index('is_read');
            $table->index(['reference_id', 'reference_type']);
            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
