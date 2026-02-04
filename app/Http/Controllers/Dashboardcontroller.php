<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Child;
use App\Models\GrowthRecord;
use App\Models\BodyAnalysis;
use Illuminate\Support\Facades\Auth;
use App\Models\ActivityLog;

class DashboardController extends Controller
{
    /**
     * Display the dashboard
     */
    public function index()
    {
        $userId = Auth::id();

        // Get total children count
        $totalChildren = Child::where('user_id', $userId)->count();

        // Get total growth records
        $totalRecords = GrowthRecord::whereHas('child', function($query) use ($userId) {
            $query->where('user_id', $userId);
        })->count();

        // Get total body analyses (fitur tambahan)
        $totalAnalyses = BodyAnalysis::where('user_id', $userId)->count();

        // Get all children with growth records count
        $children = Child::where('user_id', $userId)
            ->withCount('growthRecords')
            ->with('latestGrowth')
            ->orderBy('created_at', 'desc')
            ->get();

        // Get recent growth records
        $recentRecords = GrowthRecord::whereHas('child', function($query) use ($userId) {
                $query->where('user_id', $userId);
            })
            ->with('child')
            ->orderBy('record_date', 'desc')
            ->limit(5)
            ->get();

        return view('dashboard', compact(
            'totalChildren',
            'totalRecords',
            'totalAnalyses',
            'children',
            'recentRecords'
        ));
    }
}