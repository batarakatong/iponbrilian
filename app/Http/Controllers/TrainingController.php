<?php

namespace App\Http\Controllers;

use App\Models\Training;
use Illuminate\Http\Request;

class TrainingController extends Controller
{
    public function index(Request $request)
    {
        $trainings = Training::latest()->paginate(10);

        return view('trainings.index', [
            'trainings' => $trainings,
            'user' => $request->user(),
        ]);
    }

    public function create(Request $request)
    {
        $this->ensureAdmin($request->user());

        return view('trainings.create');
    }

    public function store(Request $request)
    {
        $this->ensureAdmin($request->user());

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'trainer' => ['nullable', 'string', 'max:255'],
            'start_date' => ['nullable', 'date'],
            'end_date' => ['nullable', 'date', 'after_or_equal:start_date'],
            'location' => ['nullable', 'string', 'max:255'],
            'is_mandatory' => ['nullable', 'boolean'],
            'document' => ['nullable', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:4096'],
        ]);

        $validated['is_mandatory'] = $request->boolean('is_mandatory');

        if ($request->hasFile('document')) {
            $validated['document_path'] = $request->file('document')->store('training_docs', 'public');
        }

        Training::create($validated);

        return redirect()->route('trainings.index')->with('success', 'Materi pelatihan berhasil disimpan.');
    }

    public function show(Training $training)
    {
        return view('trainings.show', compact('training'));
    }

    public function edit(Request $request, Training $training)
    {
        $this->ensureAdmin($request->user());

        return view('trainings.edit', compact('training'));
    }

    public function update(Request $request, Training $training)
    {
        $this->ensureAdmin($request->user());

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'trainer' => ['nullable', 'string', 'max:255'],
            'start_date' => ['nullable', 'date'],
            'end_date' => ['nullable', 'date', 'after_or_equal:start_date'],
            'location' => ['nullable', 'string', 'max:255'],
            'is_mandatory' => ['nullable', 'boolean'],
            'document' => ['nullable', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:4096'],
        ]);

        $validated['is_mandatory'] = $request->boolean('is_mandatory');

        if ($request->hasFile('document')) {
            $validated['document_path'] = $request->file('document')->store('training_docs', 'public');
        }

        $training->update($validated);

        return redirect()->route('trainings.index')->with('success', 'Materi pelatihan berhasil diperbarui.');
    }

    public function destroy(Request $request, Training $training)
    {
        $this->ensureAdmin($request->user());

        $training->delete();

        return redirect()->route('trainings.index')->with('success', 'Materi pelatihan berhasil dihapus.');
    }

    private function ensureAdmin($user): void
    {
        if (!$user->isAdmin()) {
            abort(403, 'Hanya administrator yang dapat mengelola materi pelatihan.');
        }
    }
}
