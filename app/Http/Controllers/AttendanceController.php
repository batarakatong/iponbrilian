<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AttendanceController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $isAdmin = $user->isAdmin();

        $baseQuery = Attendance::query();
        $selectedUserId = null;
        $filterUsers = collect();

        if ($isAdmin) {
            $selectedUserId = $request->query('user_id');
            if (filled($selectedUserId)) {
                $selectedUserId = (int) $selectedUserId;
                $baseQuery->where('user_id', $selectedUserId);
            } else {
                $selectedUserId = null;
            }
            $filterUsers = User::orderBy('name')->get(['id', 'name']);
        } else {
            $selectedUserId = $user->id;
            $baseQuery->where('user_id', $selectedUserId);
        }

        $attendances = (clone $baseQuery)
            ->with('user')
            ->orderBy('month', 'desc')
            ->paginate(12)
            ->appends($request->only('user_id'));

        $statusCounts = [
            'present' => (clone $baseQuery)->sum('present_count'),
            'late' => (clone $baseQuery)->sum('late_count'),
            'leave' => (clone $baseQuery)->sum('leave_count'),
            'absent' => (clone $baseQuery)->sum('absent_count'),
        ];

        return view('attendances.index', [
            'attendances' => $attendances,
            'statusCounts' => $statusCounts,
            'user' => $user,
            'filterUsers' => $filterUsers,
            'selectedUserId' => $selectedUserId,
        ]);
    }

    public function create(Request $request)
    {
        $this->ensureAdmin($request->user());

        $users = User::orderBy('name')->get(['id', 'name']);

        return view('attendances.create', compact('users'));
    }

    public function store(Request $request)
    {
        $this->ensureAdmin($request->user());

        $validated = $request->validate([
            'user_id' => ['required', 'exists:users,id'],
            'month' => [
                'required',
                'date',
                Rule::unique('attendances')->where(
                    fn ($query) => $query->where('user_id', $request->input('user_id'))
                ),
            ],
            'present_count' => ['required', 'integer', 'min:0'],
            'late_count' => ['required', 'integer', 'min:0'],
            'leave_count' => ['required', 'integer', 'min:0'],
            'absent_count' => ['required', 'integer', 'min:0'],
            'document' => ['nullable', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:4096'],
        ]);

        $validated['month'] = Carbon::parse($validated['month'])->startOfMonth()->toDateString();

        if ($request->hasFile('document')) {
            $validated['document_path'] = $request->file('document')->store('attendance_docs', 'public');
        }

        Attendance::create($validated);

        return redirect()->route('attendances.index')->with('success', 'Data absensi berhasil disimpan.');
    }

    public function show(Attendance $attendance)
    {
        return redirect()->route('attendances.edit', $attendance);
    }

    public function edit(Request $request, Attendance $attendance)
    {
        $this->ensureAdmin($request->user());

        $users = User::orderBy('name')->get(['id', 'name']);

        return view('attendances.edit', compact('attendance', 'users'));
    }

    public function update(Request $request, Attendance $attendance)
    {
        $this->ensureAdmin($request->user());

        $validated = $request->validate([
            'user_id' => ['required', 'exists:users,id'],
            'month' => [
                'required',
                'date',
                Rule::unique('attendances')
                    ->ignore($attendance->id)
                    ->where(fn ($query) => $query->where('user_id', $request->input('user_id'))),
            ],
            'present_count' => ['required', 'integer', 'min:0'],
            'late_count' => ['required', 'integer', 'min:0'],
            'leave_count' => ['required', 'integer', 'min:0'],
            'absent_count' => ['required', 'integer', 'min:0'],
            'document' => ['nullable', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:4096'],
        ]);

        $validated['month'] = Carbon::parse($validated['month'])->startOfMonth()->toDateString();

        if ($request->hasFile('document')) {
            $validated['document_path'] = $request->file('document')->store('attendance_docs', 'public');
        }

        $attendance->update($validated);

        return redirect()->route('attendances.index')->with('success', 'Data absensi berhasil diperbarui.');
    }

    public function destroy(Request $request, Attendance $attendance)
    {
        $this->ensureAdmin($request->user());

        $attendance->delete();

        return redirect()->route('attendances.index')->with('success', 'Data absensi berhasil dihapus.');
    }

    private function ensureAdmin(User $user): void
    {
        if (!$user->isAdmin()) {
            abort(403, 'Hanya administrator yang dapat mengelola data absensi.');
        }
    }
}
