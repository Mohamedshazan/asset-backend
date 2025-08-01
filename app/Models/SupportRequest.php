<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupportRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'asset_id',
        'issue',          // changed from subject/description to issue
        'status',
        'priority',
        'resolution',
        'resolved_by',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function asset()
    {
        return $this->belongsTo(Asset::class);
    }

    public function resolver()
    {
        return $this->belongsTo(User::class, 'resolved_by');
    }
}
