<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Claim;
use Illuminate\Support\Facades\Auth;
use App\Models\Notification;
use App\Models\Alert;
use App\Models\User;
use App\Services\SmartMatchingService;

class ItemController extends Controller
{
    // Store a new item report (notifications for new submissions - unchanged)
    public function store(Request $request)
    {
        $validated = $request->validate([
            'item_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category' => 'required|string|max:255',
            'date_reported' => 'nullable|date',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'report_type' => 'required|string|max:100',
            'location' => 'required|string|max:255',
            'add_location' => 'nullable|string|max:255',
        ]);

        try {
            $item = Item::createReport($validated, Auth::id());
            
            // Smart matching: Find potential matches and create alerts
            $matches = SmartMatchingService::findMatches($item);
            SmartMatchingService::createMatchAlerts($item, $matches);
            
            // Notify all admins of new report
            $admins = User::where('role', 'admin')->get();
            foreach ($admins as $admin) {
                Notification::create([
                    'user_id' => $admin->user_id,
                    'title' => 'New Report Submitted',
                    'message' => 'A new ' . ucfirst($validated['report_type']) . ' report for "' . $validated['item_name'] . '" has been submitted.',
                    'type' => 'report_submitted',
                    'is_read' => false,
                    'related_id' => $item->item_id,
                    'related_type' => Item::class,
                ]);
            }
            
            return response()->json([
                'success' => true,
                'message' => 'Report submitted successfully!',
                'item' => $item,
                'matches' => !empty($matches) ? $matches : null,  // Flag to trigger overlay
            ], 201);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['success' => false, 'errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()], 500);
        }
    }

    // Display the dashboard with item data
    public function dashboard()
    {
        $counts = Item::getCategoryCounts();
        
        // Filter recent items: Only approved for users, all for admins
        $recentItemsQuery = Item::with('user')->latest();
        if (Auth::check() && Auth::user()->role !== 'admin') {
            $recentItemsQuery->where('status', 'approved');
        }
        $recentItems = $recentItemsQuery->take(10)->get();
        $reports = collect();
        $claims = collect();
        if (Auth::check() && Auth::user()->role === 'admin') {
            $reports = Item::with('user')->latest()->get();
            $claims = Claim::with('user')->latest()->get();
        }
        return view('pages.dashboard', compact('counts', 'recentItems', 'reports', 'claims'));
    }

    // Approve a report
    public function approveReport(Request $request, $id)
    {
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }

        $item = Item::where('item_id', $id)->first();
        if (!$item) {
            return response()->json(['success' => false, 'message' => 'Report not found'], 404);
        }

        try {
            $item->status = 'approved';
            $item->save();
            
            // Notify the user who submitted the report
            Notification::create([
                'user_id' => $item->user_id,
                'title' => 'Report Approved',
                'message' => 'Your report for "' . $item->item_name . '" has been approved.',
                'type' => 'report_approved',
                'is_read' => false,
                'related_id' => $item->item_id,
                'related_type' => Item::class,
            ]);
            
            // Alert the admin who approved (status update)
            Alert::create([
                'user_id' => Auth::id(),
                'title' => 'Report Approved',
                'message' => 'You approved the report for "' . $item->item_name . '".',
                'type' => 'report_approved',
                'status' => 'approved',
                'label' => 'report',
                'is_read' => false,
                'related_id' => $item->item_id,
                'related_type' => Item::class,
            ]);
            
            return response()->json(['success' => true, 'message' => 'Report approved']);
        } catch (\Exception $e) {
            \Log::error('Approve report error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Server error: ' . $e->getMessage()], 500);
        }
    }

    // Reject a report
    public function rejectReport(Request $request, $id)
    {
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }

        $item = Item::where('item_id', $id)->first();
        if (!$item) {
            return response()->json(['success' => false, 'message' => 'Report not found'], 404);
        }

        try {
            $item->status = 'rejected';
            $item->save();
            
            // Notify the user who submitted the report
            Notification::create([
                'user_id' => $item->user_id,
                'title' => 'Report Rejected',
                'message' => 'Your report for "' . $item->item_name . '" has been rejected.',
                'type' => 'report_rejected',
                'is_read' => false,
                'related_id' => $item->item_id,
                'related_type' => Item::class,
            ]);
            
            // Alert the admin who rejected (status update)
            Alert::create([
                'user_id' => Auth::id(),
                'title' => 'Report Rejected',
                'message' => 'You rejected the report for "' . $item->item_name . '".',
                'type' => 'report_rejected',
                'status' => 'rejected',
                'label' => 'report',
                'is_read' => false,
                'related_id' => $item->item_id,
                'related_type' => Item::class,
            ]);
            
            return response()->json(['success' => true, 'message' => 'Report rejected']);
        } catch (\Exception $e) {
            \Log::error('Reject report error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Server error: ' . $e->getMessage()], 500);
        }
    }

    // Delete a report
    public function deleteReport(Request $request, $id)
    {
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }

        $item = Item::where('item_id', $id)->first();
        if (!$item) {
            return response()->json(['success' => false, 'message' => 'Report not found'], 404);
        }

        try {
            $item->delete();
            
            // Notify the user who submitted the report
            Notification::create([
                'user_id' => $item->user_id,
                'title' => 'Report Deleted',
                'message' => 'Your report for "' . $item->item_name . '" has been deleted.',
                'type' => 'report_deleted',
                'is_read' => false,
                'related_id' => $item->item_id,
                'related_type' => Item::class,
            ]);
            
            // Alert the admin who deleted (status update)
            Alert::create([
                'user_id' => Auth::id(),
                'title' => 'Report Deleted',
                'message' => 'You deleted the report for "' . $item->item_name . '".',
                'type' => 'report_deleted',
                'status' => 'deleted',
                'label' => 'report',
                'is_read' => false,
                'related_id' => $item->item_id,
                'related_type' => Item::class,
            ]);
            
            return response()->json(['success' => true, 'message' => 'Report deleted']);
        } catch (\Exception $e) {
            \Log::error('Delete report error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Server error: ' . $e->getMessage()], 500);
        }
    }

    // Approve a claim
    public function approveClaim(Request $request, $id)
    {
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }

        $claim = Claim::find($id);
        if (!$claim) {
            return response()->json(['success' => false, 'message' => 'Claim not found'], 404);
        }

        try {
            $claim->status = 'approved';
            $claim->save();
            
            // Notify the user who submitted the claim
            Notification::create([
                'user_id' => $claim->user_id,
                'title' => 'Claim Approved',
                'message' => 'Your claim for "' . $claim->item_name . '" has been approved.',
                'type' => 'claim_approved',
                'is_read' => false,
                'related_id' => $claim->claim_id,
                'related_type' => Claim::class,
            ]);
            
            // Alert the admin who approved (status update)
            Alert::create([
                'user_id' => Auth::id(),
                'title' => 'Claim Approved',
                'message' => 'You approved the claim for "' . $claim->item_name . '".',
                'type' => 'claim_approved',
                'status' => 'approved',
                'label' => 'claim',
                'is_read' => false,
                'related_id' => $claim->claim_id,
                'related_type' => Claim::class,
            ]);
            
            return response()->json(['success' => true, 'message' => 'Claim approved']);
        } catch (\Exception $e) {
            \Log::error('Approve claim error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Server error: ' . $e->getMessage()], 500);
        }
    }

    // Reject a claim
    public function rejectClaim(Request $request, $id)
    {
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }

        $claim = Claim::find($id);
        if (!$claim) {
            return response()->json(['success' => false, 'message' => 'Claim not found'], 404);
        }

        try {
            $claim->status = 'rejected';
            $claim->save();
            
            // Notify the user who submitted the claim
            Notification::create([
                'user_id' => $claim->user_id,
                'title' => 'Claim Rejected',
                'message' => 'Your claim for "' . $claim->item_name . '" has been rejected.',
                'type' => 'claim_rejected',
                'is_read' => false,
                'related_id' => $claim->claim_id,
                'related_type' => Claim::class,
            ]);
            
            // Alert the admin who rejected (status update)
            Alert::create([
                'user_id' => Auth::id(),
                'title' => 'Claim Rejected',
                'message' => 'You rejected the claim for "' . $claim->item_name . '".',
                'type' => 'claim_rejected',
                'status' => 'rejected',
                'label' => 'claim',
                'is_read' => false,
                'related_id' => $claim->claim_id,
                'related_type' => Claim::class,
            ]);
            
            return response()->json(['success' => true, 'message' => 'Claim rejected']);
        } catch (\Exception $e) {
            \Log::error('Reject claim error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Server error: ' . $e->getMessage()], 500);
        }
    }

    // Delete a claim
    public function deleteClaim(Request $request, $id)
    {
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }

        $claim = Claim::find($id);
        if (!$claim) {
            return response()->json(['success' => false, 'message' => 'Claim not found'], 404);
        }

        try {
            $claim->delete();
            
            // Notify the user who submitted the claim
            Notification::create([
                'user_id' => $claim->user_id,
                'title' => 'Claim Deleted',
                'message' => 'Your claim for "' . $claim->item_name . '" has been deleted.',
                'type' => 'claim_deleted',
                'is_read' => false,
                'related_id' => $claim->claim_id,
                'related_type' => Claim::class,
            ]);
            
            // Alert the admin who deleted (status update)
            Alert::create([
                'user_id' => Auth::id(),
                'title' => 'Claim Deleted',
                'message' => 'You deleted the claim for "' . $claim->item_name . '".',
                'type' => 'claim_deleted',
                'status' => 'deleted',
                'label' => 'claim',
                'is_read' => false,
                'related_id' => $claim->claim_id,
                'related_type' => Claim::class,
            ]);
            
            return response()->json(['success' => true, 'message' => 'Claim deleted']);
        } catch (\Exception $e) {
            \Log::error('Delete claim error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Server error: ' . $e->getMessage()], 500);
        }
    }

    // Show item details for overlay
    public function showItem(Request $request, $id)
    {
        if (!Auth::check()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
        $item = Item::with('user')->find($id);
        if (!$item) {
            return response()->json(['error' => 'Item not found'], 404);
        }
        return response()->json([
            'item_id' => $item->item_id,
            'item_name' => $item->item_name,
            'description' => $item->description,
            'category' => $item->category,
            'photo' => $item->photo,
            'report_type' => $item->report_type,
            'location' => $item->location,
            'add_location' => $item->add_location,
            'date_reported' => $item->date_reported,
            'status' => $item->status,
            'user' => $item->user,
        ]);
    }

    // Get analytics data: Filter to approved items for users, all for admins
    public function getAnalyticsData()
    {
        $itemQuery = Item::query();
        if (Auth::check() && Auth::user()->role !== 'admin') {
            $itemQuery->where('status', 'approved');
        }

        $lostCount = (clone $itemQuery)->where('report_type', 'lost')->count();
        $foundCount = (clone $itemQuery)->where('report_type', 'found')->count();
        $totalReports = (clone $itemQuery)->where('status', 'approved')->count();  // Changed: Now counts approved items only
        $pendingReports = Claim::where('status', 'pending')->count();  // Changed: Now counts pending claims
        $totalClaims = Claim::count();
        // Removed: $successfulClaims and $successRate calculations

        $topLocations = (clone $itemQuery)->selectRaw('location, COUNT(*) as count')
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
                'lost' => (clone $itemQuery)->where('category', $cat)->where('report_type', 'lost')->count(),
                'found' => (clone $itemQuery)->where('category', $cat)->where('report_type', 'found')->count(),
            ];
        }

        $categoryDistribution = [];
        foreach ($categories as $cat) {
            $categoryDistribution[] = [
                'category' => $cat,
                'count' => (clone $itemQuery)->where('category', $cat)->count(),
            ];
        }

        $recentItems = (clone $itemQuery)->with('user')->latest()->take(5)->get();
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

        $data = [
            'lostCount' => $lostCount,
            'foundCount' => $foundCount,
            // Removed: 'successRate' => $successRate,
            'totalReports' => $totalReports,
            'pendingReports' => $pendingReports,
            'topLocations' => $topLocations,
            'chartData' => $chartData,
            'categoryDistribution' => $categoryDistribution,
            'recentActivity' => $recentActivity,
        ];

        return response()->json($data);  // Return JSON response for API
    }
}
