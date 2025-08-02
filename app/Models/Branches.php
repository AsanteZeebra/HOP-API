<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Branches extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'branch_name',
        'branch_id',
        'type', // Added type field
        'region',
        'district',
        'town',
        'area_head',
        'telephone',
        'email',
        'address',
        'created_by',
        'updated_by',
        'deleted_by',
        'status',

    ];

}
