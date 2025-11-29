<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Claim;
use App\Models\Item;
use App\Models\Notification;
use App\Models\Alert;

class ClaimController extends Controller
{
    public function store(Request $request)
    {
        if (!Auth::check()) {
            return response()->json(['success' => false, 'message' => 'User not authenticated'], 401);
        }

        $validated = $request->validate([
            'item_id' => 'required|integer|exists:items,item_id',
            'full_name' => 'required|string|max:255',
            'contact_details' => 'required|string|max:255',
            'description' => 'nullable|string',
            'unique_identifier' => 'nullable|string|max:255',
            'photo' => 'nullable|image|max:2048',
            'location' => 'required|string|max:255',
            'add_location' => 'nullable|string|max:255',
            'item_name' => 'nullable|string|max:255',
        ]);

        try {
            $claim = Claim::createClaim($validated, $request);

            // Notify the user who submitted the claim
            Notification::create([
                'user_id' => $claim->user_id,
                'title' => 'Claim Submitted',
                'message' => 'Your claim for "' . ($claim->item_name ?? 'Unnamed Item') . 
                    '" has been submitted successfully.',
                'type' => 'claim_submitted',
                'is_read' => false,
                'related_id' => $claim->claim_id,
                'related_type' => Claim::class,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Claim submitted successfully. You will be notified once it is processed.',
                'item' => [
                    'id' => $claim->claim_id,
                    'item_id' => $claim->item_id,
                    'item_name' => $claim->item_name ?? 'Unnamed Item',
                    'full_name' => $claim->full_name,
                    'status' => $claim->status ?? 'pending',
                ],
            ]);
        } catch (\Exception $e) {
            \Log::error('Claim submission error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Server error: '
             . $e->getMessage()], 500);
        }
    }


    /**
     * Approve a claim.
     */
    public function approveClaim(Request $request, $id)
    {
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }

        $claim = Claim::where('claim_id', $id)->first();
        if (!$claim) {
            return response()->json(['success' => false, 'message' => 'Claim not found'], 404);
        }

        try {
            $claim->update(['status' => 'approved']);

            // Notify user
            Notification::create([
                'user_id' => $claim->user_id,
                'title' => 'Claim Approved',
                'message' => 'Your claim for "' . $claim->item_name . '" has been approved.',
                'type' => 'claim_approved',
                'is_read' => false,
                'related_id' => $claim->claim_id,
                'related_type' => Claim::class,
            ]);

            // Alert admin
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
            return response()->json(['success' => false, 'message' => 'Server error'], 500);
        }
    }

    /**
     * Reject and delete a claim.
     */
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
            // Notify user
            Notification::create([
                'user_id' => $claim->user_id,
                'title' => 'Claim Rejected',
                'message' => 'Your claim for "' . $claim->item_name . '" has been rejected and removed.',
                'type' => 'claim_rejected',
                'is_read' => false,
                'related_id' => $claim->claim_id,
                'related_type' => Claim::class,
            ]);

            // Alert admin
            Alert::create([
                'user_id' => Auth::id(),
                'title' => 'Claim Rejected',
                'message' => 'You rejected and deleted the claim for "' . $claim->item_name . '".',
                'type' => 'claim_rejected',
                'status' => 'rejected',
                'label' => 'claim',
                'is_read' => false,
                'related_id' => $claim->claim_id,
                'related_type' => Claim::class,
            ]);

            // Delete claim
            $claim->delete();

            return response()->json(['success' => true, 'message' => 'Claim rejected and deleted']);
        } catch (\Exception $e) {
            \Log::error('Reject claim error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Server error'], 500);
        }
    }

    /**
     * Get claim status (for polling).
     */
    public function getClaimStatus(Request $request, $id)
    {
        if (!Auth::check()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $claim = Claim::where('claim_id', $id)->first();
        if (!$claim) {
            return response()->json(['error' => 'Claim not found'], 404);
        }

        return response()->json([
            'id' => $claim->claim_id,
            'status' => $claim->status,
            'item_name' => $claim->item_name,
            'full_name' => $claim->full_name,
        ]);
    }

    /**
     * Show claim details.
     */
    public function showClaim(Request $request, $id)
    {
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $claim = Claim::with('user')->where('claim_id', $id)->first();
        if (!$claim) {
            return response()->json(['error' => 'Claim not found'], 404);
        }

        return response()->json([
            'claim_id' => $claim->claim_id,
            'item_name' => $claim->item_name,
            'full_name' => $claim->full_name,
            'contact_details' => $claim->contact_details,
            'description' => $claim->description,
            'unique_identifier' => $claim->unique_identifier,
            'photo' => $claim->photo_path,
            'location' => $claim->location,
            'add_location' => $claim->add_location,
            'status' => $claim->status,
            'user' => $claim->user,
        ]);
    }

    public function claimItem(Request $request, $id)
    {
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }

        $claim = Claim::find($id);
        if (!$claim) {
            return response()->json(['success' => false, 'message' => 'Claim not found'], 404);
        }

        $item = Item::find($claim->item_id);  // Get associated item

        try {
            // Notify claimant
            Notification::create([
                'user_id' => $claim->user_id,
                'title' => 'Item Claimed',
                'message' => 'Your claim for "' . $claim->item_name . '" has been processed and the item has been claimed.',
                'type' => 'claim_claimed',
                'is_read' => false,
                'related_id' => $claim->claim_id,
                'related_type' => Claim::class,
            ]);

            // Alert admin
            Alert::create([
                'user_id' => Auth::id(),
                'title' => 'Item Claimed',
                'message' => 'You marked the claim for "' . $claim->item_name . '" as claimed and removed the item and claim.',
                'type' => 'claim_claimed',
                'status' => 'claimed',
                'label' => 'claim',
                'is_read' => false,
                'related_id' => $claim->claim_id,
                'related_type' => Claim::class,
            ]);

            // Delete item and claim
            if ($item) {
                $item->delete();
            }
            $claim->delete();

            return response()->json(['success' => true, 'message' => 'Item claimed and removed']);
        } catch (\Exception $e) {
            \Log::error('Claim item error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Server error'], 500);
        }
    }

}
