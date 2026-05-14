<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('faq_questions', function (Blueprint $table) {

            $table->id();

            $table->foreignId('answer_id')
                ->constrained('faq_answers')
                ->onDelete('cascade');

            $table->text('question');

            $table->longText('embedding');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('faq_questions');
    }
};