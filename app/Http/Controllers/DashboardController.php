<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Attendance;
use App\Models\CashTransaction;
use App\Models\Department;
use App\Models\Document;
use App\Models\Letter;
use App\Models\MeetingNote;
use App\Models\Member;
use App\Models\Program;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(): View
    {
        $startOfMonth = now()->startOfMonth()->toDateString();
        $endOfMonth = now()->endOfMonth()->toDateString();
        $today = now()->toDateString();

        $totalIncome = CashTransaction::query()
            ->whereNull('archived_at')
            ->where('type', 'income')
            ->sum('amount');

        $totalExpense = CashTransaction::query()
            ->whereNull('archived_at')
            ->where('type', 'expense')
            ->sum('amount');

        $statistics = [
            'active_members' => Member::where('member_status', 'active')->count(),
            'active_departments' => Department::where('status', 'active')->count(),
            'programs' => Program::count(),
            'activities_this_month' => Activity::query()
                ->whereBetween('activity_date', [$startOfMonth, $endOfMonth])
                ->count(),
            'incoming_letters_this_month' => Letter::query()
                ->where('type', 'incoming')
                ->whereBetween('letter_date', [$startOfMonth, $endOfMonth])
                ->count(),
            'outgoing_letters_this_month' => Letter::query()
                ->where('type', 'outgoing')
                ->whereBetween('letter_date', [$startOfMonth, $endOfMonth])
                ->count(),
            'documents' => Document::whereNull('archived_at')->count(),
            'meeting_notes' => MeetingNote::whereNull('archived_at')->count(),
            'cash_income' => $totalIncome,
            'cash_expense' => $totalExpense,
            'cash_balance' => $totalIncome - $totalExpense,
        ];

        $upcomingActivities = Activity::query()
            ->with(['department', 'program'])
            ->where(function ($query) use ($today) {
                $query->whereDate('activity_date', '>=', $today)
                    ->orWhereDate('started_at', '>=', $today);
            })
            ->orderByRaw('COALESCE(activity_date, DATE(started_at)) asc')
            ->limit(5)
            ->get();

        $latestPrograms = Program::query()
            ->with(['department', 'pic'])
            ->latest()
            ->limit(5)
            ->get();

        $latestCashTransactions = CashTransaction::query()
            ->with(['cashCategory'])
            ->whereNull('archived_at')
            ->latest()
            ->limit(5)
            ->get();

        $programStatusCounts = Program::query()
            ->select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status');

        $attendanceRecaps = Activity::query()
            ->whereHas('attendances')
            ->withCount([
                'attendances as present_count' => fn ($query) => $query->where('status', 'present'),
                'attendances as permission_count' => fn ($query) => $query->where('status', 'permission'),
                'attendances as absent_count' => fn ($query) => $query->where('status', 'absent'),
            ])
            ->orderByRaw('COALESCE(activity_date, DATE(started_at), DATE(created_at)) desc')
            ->limit(5)
            ->get();

        return view('dashboard', [
            'statistics' => $statistics,
            'upcomingActivities' => $upcomingActivities,
            'latestPrograms' => $latestPrograms,
            'latestCashTransactions' => $latestCashTransactions,
            'programStatusCounts' => $programStatusCounts,
            'attendanceRecaps' => $attendanceRecaps,
        ]);
    }
}
