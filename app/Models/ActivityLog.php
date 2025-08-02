<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
      protected $fillable = [
        'username',
        'action',
        'table_name',
        'record_id',
        'description',
    ];
}
