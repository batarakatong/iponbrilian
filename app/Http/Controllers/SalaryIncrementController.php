<?php

namespace App\Http\Controllers;

use App\Models\SalaryIncrement;
use App\Models\User;
use Illuminate\Http\Request;

class SalaryIncrementController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        $salaryIncrements = SalaryIncrement::with('user')
            ->when(!$user->isAdmin(), fn ($query) => $query->where('user_id', $user->id))
            ->latest()
            ->paginate(10);

        return view('salary_increments.index', compact('salaryIncrements', 'user'));
    }

    public function create(Request $request)
    {
        $this->ensureAdmin($request->user());

        $users = User::orderBy('name')->get();

        return view('salary_increments.create', compact('users'));
    }

    public function store(Request $request)
    {
        $this->ensureAdmin($request->user());

        $validated = $request->validate([
            'user_id' => ['required', 'exists:users,id'],
            'amount' => ['required', 'numeric', 'min:0'],
            'effective_date' => ['nullable', 'date'],
            'reason' => ['nullable', 'string'],
            'approved_by' => ['nullable', 'string', 'max:255'],
            'document' => ['nullable', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:4096'],
        ]);

        if ($request->hasFile('document')) {
            $validated['document_path'] = $request->file('document')->store('salary_docs', 'public');
        }

        SalaryIncrement::create($validated);

        return redirect()->route('salary-increments.index')->with('success', 'Kenaikan gaji berhasil disimpan.');
    }

    public function show(SalaryIncrement $salaryIncrement)
    {
        return redirect()->route('salary-increments.edit', $salaryIncrement);
    }

    public function edit(Request $request, SalaryIncrement $salaryIncrement)
    {
        $this->ensureAdmin($request->user());

        $users = User::orderBy('name')->get();

        return view('salary_increments.edit', compact('salaryIncrement', 'users'));
    }

    public function update(Request $request, SalaryIncrement $salaryIncrement)
    {
        $this->ensureAdmin($request->user());

        $validated = $request->validate([
            'user_id' => ['required', 'exists:users,id'],
            'amount' => ['required', 'numeric', 'min:0'],
            'effective_date' => ['nullable', 'date'],
            'reason' => ['nullable', 'string'],
            'approved_by' => ['nullable', 'string', 'max:255'],
            'document' => ['nullable', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:4096'],
        ]);

        if ($request->hasFile('document')) {
            $validated['document_path'] = $request->file('document')->store('salary_docs', 'public');
        }

        $salaryIncrement->update($validated);

        return redirect()->route('salary-increments.index')->with('success', 'Kenaikan gaji berhasil diperbarui.');
    }

    public function destroy(Request $request, SalaryIncrement $salaryIncrement)
    {
        $this->ensureAdmin($request->user());

        $salaryIncrement->delete();

        return redirect()->route('salary-increments.index')->with('success', 'Kenaikan gaji berhasil dihapus.');
    }

    private function ensureAdmin(User $user): void
    {
        if (!$user->isAdmin()) {
            abort(403, 'Hanya administrator yang dapat mengelola kenaikan gaji.');
        }
    }
}
