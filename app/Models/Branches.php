<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Branches extends Model
{
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
        'status',

    ];
}
