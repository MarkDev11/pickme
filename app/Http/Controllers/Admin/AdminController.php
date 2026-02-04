<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\BodyAnalysis;
use App\Models\Child;
use App\Models\GrowthRecord;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

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
        $totalChildren = Child::count();
        $totalGrowthRecords = GrowthRecord::count();
        $todayAnalyses = BodyAnalysis::whereDate('created_at', today())->count();
        $activeUsers = User::whereHas('bodyAnalyses', function($query) {
            $query->where('created_at', '>=', now()->subDays(30));
        })->count();

        // System Load Stats
        $systemLoad = $this->getSystemLoad();

        // Users with analyses count
        $users = User::withCount(['bodyAnalyses', 'children', 'growthRecords'])
                    ->orderBy('created_at', 'desc')
                    ->take(10)
                    ->get();

        // Recent analyses
        $recentAnalyses = BodyAnalysis::with('user')
                                     ->latest()
                                     ->take(10)
                                     ->get();

        // Recent Activity Logs
        $recentLogs = ActivityLog::with('user')
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

        // Growth Records Chart
        $growthChartLabels = [];
        $growthChartData = [];
        
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $growthChartLabels[] = $date->format('M d');
            $growthChartData[] = GrowthRecord::whereDate('created_at', $date)->count();
        }

        return view('admin.dashboard', compact(
            'totalUsers',
            'totalAnalyses',
            'totalChildren',
            'totalGrowthRecords',
            'todayAnalyses',
            'activeUsers',
            'systemLoad',
            'users',
            'recentAnalyses',
            'recentLogs',
            'chartLabels',
            'chartData',
            'userChartLabels',
            'userChartData',
            'growthChartLabels',
            'growthChartData'
        ));
    }

    /**
     * Get system load information
     */
    private function getSystemLoad()
    {
        // Default value (untuk Windows atau jika gagal ambil data)
        $cpuLoad = [0, 0, 0];

        // Cek apakah fungsi tersedia (Hanya di Linux/Mac)
        if (function_exists('sys_getloadavg')) {
            $load = sys_getloadavg();
            if ($load) {
                $cpuLoad = $load;
            }
        }

        return [
            'cpu_1min' => round($cpuLoad[0] * 100, 2),
            'cpu_5min' => round($cpuLoad[1] * 100, 2),
            'cpu_15min' => round($cpuLoad[2] * 100, 2),
            'memory_usage' => $this->getMemoryUsage(),
            'disk_usage' => $this->getDiskUsage(),
        ];
    }

    /**
     * Get memory usage percentage
     */
    private function getMemoryUsage()
    {
        $memoryUsed = memory_get_usage(true);
        $memoryLimit = $this->returnBytes(ini_get('memory_limit'));
        
        if ($memoryLimit == -1) {
            return 0;
        }
        
        return round(($memoryUsed / $memoryLimit) * 100, 2);
    }

    /**
     * Get disk usage percentage
     */
    private function getDiskUsage()
    {
        $diskFree = disk_free_space('/');
        $diskTotal = disk_total_space('/');
        
        return round((($diskTotal - $diskFree) / $diskTotal) * 100, 2);
    }

    /**
     * Convert memory limit string to bytes
     */
    private function returnBytes($val)
    {
        $val = trim($val);
        $last = strtolower($val[strlen($val)-1]);
        $val = (int) $val;
        
        switch($last) {
            case 'g':
                $val *= 1024;
            case 'm':
                $val *= 1024;
            case 'k':
                $val *= 1024;
        }
        
        return $val;
    }

    /**
     * Show all users
     */
    public function users(Request $request)
    {
        $query = User::withCount(['bodyAnalyses', 'children', 'growthRecords']);

        // Search filter
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Role filter
        if ($request->has('role') && $request->role != '') {
            $query->where('role', $request->role);
        }

        $users = $query->latest()->paginate(20);

        return view('admin.users.index', compact('users'));
    }

    /**
     * Show user details
     */
    public function showUser($id)
    {
        $user = User::with(['bodyAnalyses', 'children.growthRecords'])
                    ->withCount(['bodyAnalyses', 'children', 'growthRecords'])
                    ->findOrFail($id);
        
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
            if ($analysis->image_path && file_exists(public_path($analysis->image_path))) {
                @unlink(public_path($analysis->image_path));
            }
            $analysis->delete();
        }

        // Delete user's children and related data
        foreach ($user->children as $child) {
            if ($child->photo && file_exists(public_path($child->photo))) {
                @unlink(public_path($child->photo));
            }
            $child->delete();
        }

        // Log the activity
        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'deleted_user',
            'description' => 'Deleted user: ' . $user->name,
            'subject_type' => User::class,
            'subject_id' => $user->id,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);

        // Delete user
        $user->delete();

        return redirect()->route('admin.users')
                        ->with('success', 'User deleted successfully!');
    }

    /**
     * Show all analyses
     */
    public function analyses(Request $request)
    {
        $query = BodyAnalysis::with('user');

        // Search filter
        if ($request->has('search')) {
            $search = $request->search;
            $query->whereHas('user', function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
            });
        }

        $analyses = $query->latest()->paginate(20);

        return view('admin.analyses.index', compact('analyses'));
    }

    /**
     * Delete analysis
     */
    public function destroyAnalysis($id)
    {
        $analysis = BodyAnalysis::findOrFail($id);
        
        // Delete image
        if ($analysis->image_path && file_exists(public_path($analysis->image_path))) {
            @unlink(public_path($analysis->image_path));
        }
        
        // Log the activity
        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'deleted_analysis',
            'description' => 'Deleted analysis #' . $analysis->id,
            'subject_type' => BodyAnalysis::class,
            'subject_id' => $analysis->id,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);
        
        $analysis->delete();

        return back()->with('success', 'Analysis deleted successfully!');
    }

    /**
     * Show all children
     */
    public function children(Request $request)
    {
        $query = Child::with('user')->withCount('growthRecords');

        // Search filter
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhereHas('user', function($q2) use ($search) {
                      $q2->where('name', 'like', "%{$search}%");
                  });
            });
        }

        // Gender filter
        if ($request->has('gender') && $request->gender != '') {
            $query->where('gender', $request->gender);
        }

        $children = $query->latest()->paginate(20);

        return view('admin.children.index', compact('children'));
    }

    /**
     * Show child details
     */
    public function showChild($id)
    {
        $child = Child::with(['user', 'growthRecords' => function($query) {
                        $query->orderBy('record_date', 'desc');
                    }])
                    ->withCount('growthRecords')
                    ->findOrFail($id);
        
        return view('admin.children.show', compact('child'));
    }

    /**
     * Show all growth records
     */
    public function growthRecords(Request $request)
    {
        $query = GrowthRecord::with(['child', 'user']);

        // Search filter
        if ($request->has('search')) {
            $search = $request->search;
            $query->whereHas('child', function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
            });
        }

        // Status filter
        if ($request->has('status') && $request->status != '') {
            $query->where('growth_status', 'like', "%{$request->status}%");
        }

        $records = $query->latest('record_date')->paginate(20);

        return view('admin.growth-records.index', compact('records'));
    }

    /**
     * Show activity logs
     */
    public function activityLogs(Request $request)
    {
        $query = ActivityLog::with('user');

        // Action filter
        if ($request->has('action') && $request->action != '') {
            $query->where('action', $request->action);
        }

        // Date filter
        if ($request->has('date') && $request->date != '') {
            $query->whereDate('created_at', $request->date);
        }

        $logs = $query->latest()->paginate(50);
        
        // Get unique actions for filter
        $actions = ActivityLog::select('action')->distinct()->pluck('action');

        return view('admin.activity-logs.index', compact('logs', 'actions'));
    }

    /**
     * Clear old activity logs
     */
    public function clearOldLogs()
    {
        $deleted = ActivityLog::where('created_at', '<', now()->subDays(90))->delete();
        
        return back()->with('success', "Deleted {$deleted} old activity logs.");
    }

    /**
     * Show system status
     */
    public function systemStatus()
    {
        $systemLoad = $this->getSystemLoad();
        
        // Get database stats
        $dbStats = [
            'users' => User::count(),
            'children' => Child::count(),
            'growth_records' => GrowthRecord::count(),
            'body_analyses' => BodyAnalysis::count(),
            'activity_logs' => ActivityLog::count(),
        ];

        // Get storage info
        $storageInfo = $this->getStorageInfo();

        return view('admin.system-status', compact('systemLoad', 'dbStats', 'storageInfo'));
    }

    /**
     * Get storage information
     */
    private function getStorageInfo()
    {
        $publicPath = public_path();
        
        return [
            'total_size' => $this->formatBytes($this->getDirectorySize($publicPath)),
            'uploads_size' => $this->formatBytes($this->getDirectorySize($publicPath . '/uploads')),
            'images_size' => $this->formatBytes($this->getDirectorySize($publicPath . '/images')),
        ];
    }

    /**
     * Get directory size
     */
    private function getDirectorySize($path)
    {
        if (!is_dir($path)) {
            return 0;
        }

        $size = 0;
        foreach (new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($path)) as $file) {
            $size += $file->getSize();
        }
        return $size;
    }

    /**
     * Format bytes to human readable
     */
    private function formatBytes($bytes, $precision = 2)
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];

        for ($i = 0; $bytes > 1024; $i++) {
            $bytes /= 1024;
        }

        return round($bytes, $precision) . ' ' . $units[$i];
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

        $oldRole = $user->role;
        $user->role = $user->role === 'admin' ? 'user' : 'admin';
        $user->save();

        // Log the activity
        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'changed_user_role',
            'description' => "Changed role of {$user->name} from {$oldRole} to {$user->role}",
            'subject_type' => User::class,
            'subject_id' => $user->id,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);

        return back()->with('success', 'User role updated successfully!');
    }

    /**
     * Export users data
     */
    public function exportUsers()
    {
        $users = User::withCount(['bodyAnalyses', 'children', 'growthRecords'])->get();

        $filename = 'users-export-' . date('Y-m-d-His') . '.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];

        $callback = function() use ($users) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['ID', 'Name', 'Email', 'Role', 'Children', 'Growth Records', 'Analyses', 'Registered Date']);

            foreach ($users as $user) {
                fputcsv($file, [
                    $user->id,
                    $user->name,
                    $user->email,
                    $user->role,
                    $user->children_count,
                    $user->growth_records_count,
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

        $filename = 'analyses-export-' . date('Y-m-d-His') . '.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];

        $callback = function() use ($analyses) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['ID', 'User', 'Email', 'Height (cm)', 'Weight (kg)', 'Age', 'BMI', 'BMI Category', 'Date']);

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
                    $analysis->bmi_category,
                    $analysis->created_at->format('Y-m-d H:i:s'),
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Export growth records
     */
    public function exportGrowthRecords()
    {
        $records = GrowthRecord::with(['child', 'user'])->get();

        $filename = 'growth-records-export-' . date('Y-m-d-His') . '.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];

        $callback = function() use ($records) {
            $file = fopen('php://output', 'w');
            fputcsv($file, [
                'ID', 'Child Name', 'Parent', 'Record Date', 'Age (months)', 
                'Weight (kg)', 'Height (cm)', 'Head Circumference', 
                'Growth Status', 'Created Date'
            ]);

            foreach ($records as $record) {
                fputcsv($file, [
                    $record->id,
                    $record->child->name ?? 'N/A',
                    $record->user->name ?? 'N/A',
                    $record->record_date->format('Y-m-d'),
                    $record->age_months,
                    $record->actual_weight,
                    $record->actual_height,
                    $record->head_circumference,
                    $record->growth_status ?? 'N/A',
                    $record->created_at->format('Y-m-d H:i:s'),
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Export activity logs
     */
    public function exportActivityLogs()
    {
        $logs = ActivityLog::with('user')->get();

        $filename = 'activity-logs-export-' . date('Y-m-d-His') . '.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];

        $callback = function() use ($logs) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['ID', 'User', 'Action', 'Description', 'IP Address', 'Date']);

            foreach ($logs as $log) {
                fputcsv($file, [
                    $log->id,
                    $log->user->name ?? 'System',
                    $log->action,
                    $log->description,
                    $log->ip_address,
                    $log->created_at->format('Y-m-d H:i:s'),
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}