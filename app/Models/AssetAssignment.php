<?php



namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AssetAssignment extends Model
{
    protected $fillable = [
        'asset_id',
        'user_id',
        'assigned_at',
        'unassigned_at',
    ];

    public $timestamps = false; // Only if you're manually handling time columns
}


