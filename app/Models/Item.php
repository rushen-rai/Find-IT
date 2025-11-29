<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use App\Models\Notification;

class Item extends Model
{
    use HasFactory;

    protected $primaryKey = 'item_id';

    protected $fillable = [
        'user_id',
        'item_name',
        'description',
        'category',
        'date_reported',
        'photo',
        'prio_flag',
        'report_type',
        'location',
        'add_location',
        'admin_approved',
        'status',
    ];

    protected $casts = [
        'date_reported' => 'datetime',
    ];

    // Relationship to User.
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Create a new item report with notification (changed from alert).
    public static function createReport($data, $userId)
    {
        $data['user_id'] = $userId;
        $data['admin_approved'] = false;
        $data['status'] = 'active';
        $data['date_reported'] = $data['date_reported'] ?? now();
        $data['prio_flag'] = static::determinePriority($data);

        if (isset($data['photo']) && $data['photo']) {
            $data['photo'] = $data['photo']->store('uploads', 'public');
        }

        $item = static::create($data);

        try {
            Notification::create([  // Changed from Alert to Notification
                'user_id' => $userId,
                'title' => 'Report Submitted',
                'message' => 'Your ' . ucfirst($data['report_type']) . ' report for "' . $data['item_name'] . '" is pending approval.',
                'type' => 'report_submitted',
                'is_read' => false,
                'related_id' => $item->item_id,
                'related_type' => static::class,
            ]);
        } catch (\Exception $e) {
            \Log::error('Failed to create notification for report: ' . $e->getMessage());
        }

        return $item;
    }

    // Determine priority based on category and description.
    public static function determinePriority($data)
    {
        $highPriorityCategories = ['Emergency', 'Danger', 'Medical'];

        if (in_array(strtolower($data['category']), array_map('strtolower', $highPriorityCategories))) {
            return 'High';
        }

        if (
            strtolower($data['report_type']) === 'lost' &&
            (str_contains(strtolower($data['description'] ?? ''), 'id') ||
             str_contains(strtolower($data['description'] ?? ''), 'wallet'))
        ) {
            return 'High';
        }

        return 'Normal';
    }

    // Get category counts.
    public static function getCategoryCounts()
    {
        $categories = [
            'Electronics & Gadgets',
            'Bags & Accessories',
            'Clothing & Wearables',
            'Documents & IDs',
            'School Supplies',
            'Personal Items'
        ];

        $counts = [];
        foreach ($categories as $category) {
            $counts[$category] = static::where('category', $category)->count();
        }

        return $counts;
    }

    // Get analytics data.
    public static function getAnalyticsData()
    {
        $lostCount = static::where('report_type', 'lost')->count();
        $foundCount = static::where('report_type', 'found')->count();
        $totalReports = static::count();
        $pendingReports = static::where('status', 'pending')->count();
        $totalClaims = Claim::count();
        $approvedClaims = Claim::where('status', 'approved')->count();

        $topLocations = static::selectRaw('location, COUNT(*) as count')
            ->groupBy('location')
            ->orderBy('count', 'desc')
            ->take(5)
            ->get()
            ->map(fn($loc) => ['location' => $loc->location, 'count' => $loc->count]);

        $categories = [
            'Electronics & Gadgets',
            'Bags & Accessories',
            'Clothing & Wearables',
            'Documents & IDs',
            'School Supplies',
            'Personal Items'
        ];

        $chartData = [];
        foreach ($categories as $cat) {
            $chartData[] = [
                'category' => $cat,
                'lost' => static::where('category', $cat)->where('report_type', 'lost')->count(),
                'found' => static::where('category', $cat)->where('report_type', 'found')->count(),
            ];
        }

        $categoryDistribution = [];
        foreach ($categories as $cat) {
            $categoryDistribution[] = [
                'category' => $cat,
                'count' => static::where('category', $cat)->count(),
            ];
        }

        $recentItems = static::with('user')->latest()->take(5)->get();
        $recentClaims = Claim::with('user', 'item')->latest()->take(5)->get();
        $recentActivity = collect([...$recentItems, ...$recentClaims])
            ->sortByDesc('created_at')
            ->take(5)
            ->map(function ($item) {
                $isItem = $item instanceof Item;
                return [
                    'type' => $isItem ? 'report' : 'claim',
                    'status' => $item->status,
                    'label' => $isItem ? $item->report_type : 'claim',
                    'item_name' => $isItem ? $item->item_name : ($item->item_name ?? 'Unnamed Item'),
                    'user' => $item->user->name ?? 'Unknown',
                    'location' => $item->location,
                    'date' => $item->created_at->format('M d, Y'),
                    'description' => substr($item->description ?? 'No description', 0, 50) . '...',
                ];
            });

        return [
            'lostCount' => $lostCount,
            'foundCount' => $foundCount,
            'totalReports' => $totalReports,
            'pendingReports' => $pendingReports,
            'topLocations' => $topLocations,
            'chartData' => $chartData,
            'categoryDistribution' => $categoryDistribution,
            'recentActivity' => $recentActivity,
        ];
    }
}