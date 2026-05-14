<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FaqAnswer;
use App\Models\FaqQuestion;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;

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

            // 🔥 IMPORTANT: refresh Flask cache
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

            // 🔥 refresh Flask cache
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

            // 🔥 refresh Flask cache
            $this->refreshAiCache();

            return redirect()
                ->route('admin.faqs.index')
                ->with('success', 'FAQ berhasil dihapus');

        } catch (\Exception $e) {
            return back()->with('error', 'Gagal hapus FAQ');
        }
    }

    /**
     * EMBEDDING SERVICE (SAFE)
     */
    private function getEmbedding($text)
    {
        try {
            $response = Http::timeout(5)->post(
                'http://127.0.0.1:5000/generate-embedding',
                ['question' => $text]
            );

            if ($response->successful()) {
                return $response->json()['embedding'] ?? [];
            }

        } catch (\Exception $e) {
            // optional log
        }

        return [];
    }

    /**
     * 🔥 FLASK CACHE REFRESH (SOLUSI 2)
     */
    private function refreshAiCache()
    {
        try {
            Http::timeout(5)->post(
                'http://127.0.0.1:5000/refresh-faq'
            );
        } catch (\Exception $e) {
            // kalau gagal refresh, tidak menghentikan flow
        }
    }
}