<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FaqAnswer;
use App\Models\FaqQuestion;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class FaqController extends Controller

{

    public function index()
    {
        $faqs = FaqAnswer::with('questions')->latest()->get();
        return view('admin.faqs.index', compact('faqs'));
    }

    public function create()
    {
        return view('admin.faqs.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'answer' => 'required|string',
            'questions' => 'required|array|min:1',
            'questions.*' => 'nullable|string'
        ]);

        DB::beginTransaction();

        try {
            $answer = FaqAnswer::create([
                'answer' => $request->answer
            ]);

            foreach ($request->questions as $q) {

                $q = trim($q);

                if (!$q) continue;

                $embedding = $this->getEmbedding($q);

                FaqQuestion::create([
                    'answer_id' => $answer->id,
                    'question' => $q,
                    'embedding' => json_encode($embedding)
                ]);
            }

            DB::commit();

            //  IMPORTANT: refresh Flask cache
            $this->refreshAiCache();

            return redirect()
                ->route('admin.faqs.index')
                ->with('success', 'FAQ berhasil ditambahkan');
        } catch (\Exception $e) {
            DB::rollBack();

            return back()
                ->withInput()
                ->with('error', 'Gagal menyimpan FAQ: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        $faq = FaqAnswer::with('questions')->findOrFail($id);
        return view('admin.faqs.edit', compact('faq'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'answer' => 'required|string',
            'questions' => 'required|array|min:1',
            'questions.*' => 'nullable|string'
        ]);

        DB::beginTransaction();

        try {
            $faq = FaqAnswer::findOrFail($id);

            $faq->update([
                'answer' => $request->answer
            ]);

            // hapus lama
            $faq->questions()->delete();

            foreach ($request->questions as $q) {

                $q = trim($q);

                if (!$q) continue;

                $embedding = $this->getEmbedding($q);

                FaqQuestion::create([
                    'answer_id' => $faq->id,
                    'question' => $q,
                    'embedding' => json_encode($embedding)
                ]);
            }

            DB::commit();

            //  refresh Flask cache
            $this->refreshAiCache();

            return redirect()
                ->route('admin.faqs.index')
                ->with('success', 'FAQ berhasil diupdate');
        } catch (\Exception $e) {
            DB::rollBack();

            return back()
                ->withInput()
                ->with('error', 'Gagal update FAQ: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $faq = FaqAnswer::findOrFail($id);
            $faq->delete();

            //  refresh Flask cache
            $this->refreshAiCache();

            return redirect()
                ->route('admin.faqs.index')
                ->with('success', 'FAQ berhasil dihapus');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal hapus FAQ');
        }
    }

    /**
     * EMBEDDING SERVICE
     */
    private function getEmbedding($text)
    {
        try {

            $url = rtrim(
                config('services.ai.url'),
                '/'
            );

            $response = Http::timeout(30)
                ->acceptJson()
                ->post(
                    $url . '/generate-embedding',
                    [
                        'question' => $text
                    ]
                );

            // DEBUG RESPONSE
            if (!$response->successful()) {

                Log::error('AI EMBEDDING ERROR', [

                    'status' => $response->status(),

                    'body' => $response->body()

                ]);

                throw new \Exception(
                    'AI server gagal merespon'
                );
            }

            $json = $response->json();

            // VALIDASI RESPONSE
            if (
                !isset($json['embedding']) ||
                !is_array($json['embedding']) ||
                count($json['embedding']) === 0
            ) {

                Log::error('EMBEDDING EMPTY', [
                    'response' => $json
                ]);

                throw new \Exception(
                    'Embedding kosong dari AI'
                );
            }

            return $json['embedding'];
        } catch (\Exception $e) {

            Log::error(
                'GET EMBEDDING ERROR: ' .
                    $e->getMessage()
            );

            throw $e;
        }
    }       

    /**
     *  FLASK CACHE REFRESH (SOLUSI 2)
     */
    private function refreshAiCache()
    {
        try {

            $url = config('services.ai.url');

            $response = Http::timeout(10)->post(
                $url . '/refresh-faq'
            );

            if (!$response->successful()) {

                throw new \Exception(
                    'Refresh AI gagal: ' . $response->body()
                );
            }
        } catch (\Exception $e) {

            Log::error(
                'AI CACHE ERROR: ' . $e->getMessage()
            );
        }
    }
}
