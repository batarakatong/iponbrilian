<?php

namespace App\Http\Controllers;

use App\Models\Promotion;
use App\Models\User;
use Illuminate\Http\Request;

class PromotionController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        $promotions = Promotion::with('user')
            ->when(!$user->isAdmin(), fn ($query) => $query->where('user_id', $user->id))
            ->latest()
            ->paginate(10);

        return view('promotions.index', compact('promotions', 'user'));
    }

    public function create(Request $request)
    {
        $this->ensureAdmin($request->user());

        $users = User::orderBy('name')->get();

        return view('promotions.create', compact('users'));
    }

    public function store(Request $request)
    {
        $this->ensureAdmin($request->user());

        $validated = $request->validate([
            'user_id' => ['required', 'exists:users,id'],
            'current_rank' => ['nullable', 'string', 'max:100'],
            'new_rank' => ['required', 'string', 'max:100'],
            'effective_date' => ['nullable', 'date'],
            'document_number' => ['nullable', 'string', 'max:100'],
            'notes' => ['nullable', 'string'],
            'document' => ['nullable', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:4096'],
        ]);

        $validated['user_id'] = (int) $request->input('user_id');

        if ($request->hasFile('document')) {
            $validated['document_path'] = $request->file('document')->store('promotion_docs', 'public');
        }

        Promotion::create($validated);

        return redirect()->route('promotions.index')->with('success', 'Data kenaikan pangkat berhasil disimpan.');
    }

    public function show(Promotion $promotion)
    {
        return redirect()->route('promotions.edit', $promotion);
    }

    public function edit(Request $request, Promotion $promotion)
    {
        $this->ensureAdmin($request->user());

        $users = User::orderBy('name')->get();

        return view('promotions.edit', compact('promotion', 'users'));
    }

    public function update(Request $request, Promotion $promotion)
    {
        $this->ensureAdmin($request->user());

        $validated = $request->validate([
            'user_id' => ['required', 'exists:users,id'],
            'current_rank' => ['nullable', 'string', 'max:100'],
            'new_rank' => ['required', 'string', 'max:100'],
            'effective_date' => ['nullable', 'date'],
            'document_number' => ['nullable', 'string', 'max:100'],
            'notes' => ['nullable', 'string'],
            'document' => ['nullable', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:4096'],
        ]);

        $validated['user_id'] = (int) $request->input('user_id');

        if ($request->hasFile('document')) {
            $validated['document_path'] = $request->file('document')->store('promotion_docs', 'public');
        }

        $promotion->update($validated);

        return redirect()->route('promotions.index')->with('success', 'Data kenaikan pangkat berhasil diperbarui.');
    }

    public function destroy(Request $request, Promotion $promotion)
    {
        $this->ensureAdmin($request->user());

        $promotion->delete();

        return redirect()->route('promotions.index')->with('success', 'Data kenaikan pangkat berhasil dihapus.');
    }

    private function ensureAdmin(User $user): void
    {
        if (!$user->isAdmin()) {
            abort(403, 'Hanya administrator yang dapat mengelola kenaikan pangkat.');
        }
    }
}
