<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\BodyAnalysis;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    /**
     * Display admin dashboard
     */
    public function dashboard()
    {
        // Statistics
        $totalUsers = User::count();
        $totalAnalyses = BodyAnalysis::count();
        $todayAnalyses = BodyAnalysis::whereDate('created_at', today())->count();
        $activeUsers = User::whereHas('bodyAnalyses', function($query) {
            $query->where('created_at', '>=', now()->subDays(30));
        })->count();

        // Users with analyses count
        $users = User::withCount('bodyAnalyses')
                    ->orderBy('created_at', 'desc')
                    ->get();

        // Recent analyses
        $recentAnalyses = BodyAnalysis::with('user')
                                     ->latest()
                                     ->take(10)
                                     ->get();

        // Chart data - Last 7 days analyses
        $chartLabels = [];
        $chartData = [];
        
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $chartLabels[] = $date->format('M d');
            $chartData[] = BodyAnalysis::whereDate('created_at', $date)->count();
        }

        // User registration chart
        $userChartLabels = [];
        $userChartData = [];
        
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $userChartLabels[] = $date->format('M d');
            $userChartData[] = User::whereDate('created_at', $date)->count();
        }

        return view('admin.dashboard', compact(
            'totalUsers',
            'totalAnalyses',
            'todayAnalyses',
            'activeUsers',
            'users',
            'recentAnalyses',
            'chartLabels',
            'chartData',
            'userChartLabels',
            'userChartData'
        ));
    }

    /**
     * Show user details
     */
    public function showUser($id)
    {
        $user = User::with('bodyAnalyses')->findOrFail($id);
        
        return view('admin.users.show', compact('user'));
    }

    /**
     * Delete user
     */
    public function destroyUser($id)
    {
        $user = User::findOrFail($id);
        
        // Prevent deleting own account
        if ($user->id === auth()->id()) {
            return back()->with('error', 'You cannot delete your own account.');
        }

        // Delete user's analyses and images
        foreach ($user->bodyAnalyses as $analysis) {
            $imagePath = public_path($analysis->image_path);
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
            $analysis->delete();
        }

        // Delete user
        $user->delete();

        return redirect()->route('admin.dashboard')
                        ->with('success', 'User deleted successfully!');
    }

    /**
     * Show all analyses
     */
    public function analyses()
    {
        $analyses = BodyAnalysis::with('user')
                                ->latest()
                                ->paginate(20);

        return view('admin.analyses', compact('analyses'));
    }

    /**
     * Delete analysis
     */
    public function destroyAnalysis($id)
    {
        $analysis = BodyAnalysis::findOrFail($id);
        
        // Delete image
        $imagePath = public_path($analysis->image_path);
        if (file_exists($imagePath)) {
            unlink($imagePath);
        }
        
        $analysis->delete();

        return back()->with('success', 'Analysis deleted successfully!');
    }

    /**
     * Toggle user role (admin/user)
     */
    public function toggleRole($id)
    {
        $user = User::findOrFail($id);
        
        // Prevent changing own role
        if ($user->id === auth()->id()) {
            return back()->with('error', 'You cannot change your own role.');
        }

        $user->role = $user->role === 'admin' ? 'user' : 'admin';
        $user->save();

        return back()->with('success', 'User role updated successfully!');
    }

    /**
     * Export users data
     */
    public function exportUsers()
    {
        $users = User::withCount('bodyAnalyses')->get();

        $filename = 'users-export-' . date('Y-m-d') . '.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];

        $callback = function() use ($users) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['ID', 'Name', 'Email', 'Role', 'Analyses Count', 'Registered Date']);

            foreach ($users as $user) {
                fputcsv($file, [
                    $user->id,
                    $user->name,
                    $user->email,
                    $user->role,
                    $user->body_analyses_count,
                    $user->created_at->format('Y-m-d H:i:s'),
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Export all analyses
     */
    public function exportAnalyses()
    {
        $analyses = BodyAnalysis::with('user')->get();

        $filename = 'analyses-export-' . date('Y-m-d') . '.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];

        $callback = function() use ($analyses) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['ID', 'User', 'Email', 'Height (cm)', 'Weight (kg)', 'Age', 'BMI', 'Date']);

            foreach ($analyses as $analysis) {
                $heightM = $analysis->estimated_height / 100;
                $bmi = $heightM > 0 ? round($analysis->estimated_weight / ($heightM * $heightM), 1) : 0;

                fputcsv($file, [
                    $analysis->id,
                    $analysis->user->name ?? 'N/A',
                    $analysis->user->email ?? 'N/A',
                    $analysis->estimated_height,
                    $analysis->estimated_weight,
                    $analysis->estimated_age,
                    $bmi,
                    $analysis->created_at->format('Y-m-d H:i:s'),
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}