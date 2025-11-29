<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use App\Models\Alert;

class Claim extends Model
{
    use HasFactory;

    protected $primaryKey = 'claim_id';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'user_id',
        'item_id',
        'item_name',
        'full_name',
        'contact_details',
        'description',
        'unique_identifier',
        'photo_path',
        'location',
        'add_location',
        'status',
        'approved_at',
        'ip_address',
    ];

    // Relationship to User.
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Relationship to Item.
    public function item()
    {
        return $this->belongsTo(Item::class, 'item_id');
    }

    // Create a new claim with associated alert.
    public static function createClaim($data, $request)
    {
        if ($request->hasFile('photo')) {
            $data['photo_path'] = $request->file('photo')->store('claim_photos', 'public');
        }

        $data['user_id'] = Auth::id();
        $data['status'] = 'pending';
        $data['ip_address'] = $request->ip();

        $claim = static::create($data);

        Alert::create([
            'user_id' => Auth::id(),
            'title' => 'Claim Submitted',
            'message' => 'Your claim for "' . ($claim->item_name ?? 'an item') . '" is pending review.',
            'type' => 'claim_submitted',
            'status' => 'pending',
            'label' => 'claim',
            'related_id' => $claim->claim_id,
            'related_type' => static::class,
        ]);

        return $claim;
    }
}