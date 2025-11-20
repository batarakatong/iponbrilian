<?php

namespace App\Http\Controllers;

use App\Models\Certificate;
use App\Models\User;
use Illuminate\Http\Request;

class CertificateController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        $certificates = Certificate::with('user')
            ->when(!$user->isAdmin(), fn ($query) => $query->where('user_id', $user->id))
            ->latest()
            ->paginate(10);

        return view('certificates.index', compact('certificates', 'user'));
    }

    public function create(Request $request)
    {
        $users = $request->user()->isAdmin()
            ? User::orderBy('name')->get()
            : collect();

        return view('certificates.create', compact('users'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'issuer' => ['nullable', 'string', 'max:255'],
            'issued_at' => ['nullable', 'date'],
            'expired_at' => ['nullable', 'date', 'after_or_equal:issued_at'],
            'reference_number' => ['nullable', 'string', 'max:100'],
            'description' => ['nullable', 'string'],
            'user_id' => ['nullable', 'exists:users,id'],
            'document' => ['nullable', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:4096'],
        ]);

        $validated['user_id'] = $request->user()->isAdmin() && $request->filled('user_id')
            ? (int) $request->input('user_id')
            : $request->user()->id;

        if ($request->hasFile('document')) {
            $validated['document_path'] = $request->file('document')->store('certificate_docs', 'public');
        }

        Certificate::create($validated);

        return redirect()->route('certificates.index')->with('success', 'Sertifikat berhasil disimpan.');
    }

    public function edit(Request $request, Certificate $certificate)
    {
        $this->authorizeCertificate($request->user(), $certificate);

        $users = $request->user()->isAdmin()
            ? User::orderBy('name')->get()
            : collect();

        return view('certificates.edit', compact('certificate', 'users'));
    }

    public function update(Request $request, Certificate $certificate)
    {
        $this->authorizeCertificate($request->user(), $certificate);

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'issuer' => ['nullable', 'string', 'max:255'],
            'issued_at' => ['nullable', 'date'],
            'expired_at' => ['nullable', 'date', 'after_or_equal:issued_at'],
            'reference_number' => ['nullable', 'string', 'max:100'],
            'description' => ['nullable', 'string'],
            'user_id' => ['nullable', 'exists:users,id'],
            'document' => ['nullable', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:4096'],
        ]);

        if ($request->user()->isAdmin() && $request->filled('user_id')) {
            $validated['user_id'] = (int) $request->input('user_id');
        }

        if ($request->hasFile('document')) {
            $validated['document_path'] = $request->file('document')->store('certificate_docs', 'public');
        }

        $certificate->update($validated);

        return redirect()->route('certificates.index')->with('success', 'Sertifikat berhasil diperbarui.');
    }

    public function destroy(Request $request, Certificate $certificate)
    {
        $this->authorizeCertificate($request->user(), $certificate);

        $certificate->delete();

        return redirect()->route('certificates.index')->with('success', 'Sertifikat berhasil dihapus.');
    }

    private function authorizeCertificate(User $user, Certificate $certificate): void
    {
        if (!$user->isAdmin() && $certificate->user_id !== $user->id) {
            abort(403, 'Anda tidak memiliki akses terhadap sertifikat ini.');
        }
    }
}
