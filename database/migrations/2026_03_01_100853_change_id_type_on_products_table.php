<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement('ALTER TABLE products MODIFY id BIGINT UNSIGNED NOT NULL');
        DB::statement('ALTER TABLE products DROP PRIMARY KEY');
        DB::statement('ALTER TABLE products MODIFY id VARCHAR(12) NOT NULL');
        DB::statement('ALTER TABLE products ADD PRIMARY KEY (id)');
    }

    public function down(): void
    {
        DB::statement('ALTER TABLE products DROP PRIMARY KEY');
        DB::statement('ALTER TABLE products MODIFY id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT');
        DB::statement('ALTER TABLE products ADD PRIMARY KEY (id)');
    }
};
