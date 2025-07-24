<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;


class Members extends Model
{
protected $fillable = [
        'fullname',
        'member_id',
        'dob',
        'age',
        'alter_call',
        'gender',
        'marital_status',
        'occupation',
        'telephone',
        'spouse',
        'children',
        'city',
        'region',
        'house_address',
        'postal',
        'position',
        'department',
        'photo',
        'branch_name',
        'branch_id',
        'status',
        'created_by',
        'updated_by',
        'deleted_by',
        'deleted_at', // Soft delete field
    ];

    protected $casts = [
        'dob' => 'date',
        'children' => 'integer',
    ];

    protected $appends = ['photo_url'];

    public function getPhotoUrlAttribute()
    {
        return $this->photo ? Storage::url($this->photo) : null;
    }

    // Optional if you have a Branch model
    public function branch()
    {
        return $this->belongsTo(Branches::class, 'branch_id');
    }
}
