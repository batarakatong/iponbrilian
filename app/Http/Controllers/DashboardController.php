<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Certificate;
use App\Models\Promotion;
use App\Models\SalaryIncrement;
use App\Models\Training;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $isAdmin = $user->isAdmin();

        $certificatesCount = Certificate::when(!$isAdmin, fn ($query) => $query->where('user_id', $user->id))->count();
        $trainingsCount = Training::count();
        $promotionsCount = $isAdmin ? Promotion::count() : $user->promotions()->count();
        $salaryCount = $isAdmin ? SalaryIncrement::count() : $user->salaryIncrements()->count();

        $attendanceQuery = Attendance::query();

        if (!$isAdmin) {
            $attendanceQuery->where('user_id', $user->id);
        }

        $attendanceStats = [
            'present' => (clone $attendanceQuery)->sum('present_count'),
            'absent' => (clone $attendanceQuery)->sum('absent_count'),
            'late' => (clone $attendanceQuery)->sum('late_count'),
            'leave' => (clone $attendanceQuery)->sum('leave_count'),
        ];

        $attendanceByMonth = (clone $attendanceQuery)->orderBy('month', 'desc')
            ->limit(6)
            ->get(['month', 'present_count as present', 'absent_count as absent', 'late_count as late', 'leave_count as leave_count'])
            ->reverse()
            ->values();

        $recentTrainings = Training::latest()->limit(5)->get();
        $recentCertificates = Certificate::with('user')
            ->when(!$isAdmin, fn ($query) => $query->where('user_id', $user->id))
            ->latest()
            ->limit(5)
            ->get();
        $recentPromotions = Promotion::with('user')
            ->when(!$isAdmin, fn ($query) => $query->where('user_id', $user->id))
            ->latest()
            ->limit(5)
            ->get();

        return view('dashboard', [
            'certificatesCount' => $certificatesCount,
            'trainingsCount' => $trainingsCount,
            'promotionsCount' => $promotionsCount,
            'salaryCount' => $salaryCount,
            'attendanceStats' => $attendanceStats,
            'attendanceByMonth' => $attendanceByMonth,
            'recentTrainings' => $recentTrainings,
            'recentCertificates' => $recentCertificates,
            'recentPromotions' => $recentPromotions,
            'isAdmin' => $isAdmin,
        ]);
    }
}
