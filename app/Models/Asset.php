<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asset extends Model
{
    use HasFactory;

    protected $fillable = [
        'department_id',
        'brand',
        'model',
        'device_name',
        'os',
        'serial_number',
        'status',
        'asset_type', // Make sure this column exists in the DB
        'user_id',
        'active',
        'location',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function supportRequests()
    {
        return $this->hasMany(SupportRequest::class);
    }
    public function department()
    {
        return $this->belongsTo(Department::class);
    }
}
