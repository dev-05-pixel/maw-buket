<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('contact_messages', function (Blueprint $table) {
            $table->dropColumn('id');
        });

        Schema::table('contact_messages', function (Blueprint $table) {
            $table->string('id', 32)->primary()->first();
        });
    }

    public function down(): void
    {
        Schema::table('contact_messages', function (Blueprint $table) {
            $table->dropColumn('id');
        });

        Schema::table('contact_messages', function (Blueprint $table) {
            $table->bigIncrements('id')->first();
        });
    }
};
