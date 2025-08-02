<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pastor extends Model
{

 protected $fillable = [
        'fullname',
        'pastor_code',
        'title', // Added type field
        'dob',
        'marital_status',
        'spouse',
        'children',
        'telephone',
        'branch',
        'from_date',
        'to_date',
        'next_of_kin',
        'emergency_contact',
        'photo',
        'created_by',
        'updated_by',
        'deleted_by',
        'status',


    ];

}
