<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;

use App\Models\FaqAnswer;
use App\Models\FaqQuestion;

class FaqAISeeder extends Seeder
{
    public function run(): void
    {
        $json = File::get(storage_path('app/faq.json'));
        $items = json_decode($json, true);

        foreach ($items as $item) {

            $answer = FaqAnswer::create([
                'answer' => $item['answer']
            ]);

            foreach ($item['questions'] as $question) {

                $response = Http::post(
                    'http://127.0.0.1:5000/generate-embedding',
                    ['question' => $question]
                );

                $embedding = $response->json()['embedding'];

                FaqQuestion::create([
                    'answer_id' => $answer->id,
                    'question' => $question,
                    'embedding' => json_encode($embedding)
                ]);
            }
        }

        // 🔥 IMPORTANT: refresh Flask cache setelah seeding
        Http::post('http://127.0.0.1:5000/refresh-faq');
    }
}