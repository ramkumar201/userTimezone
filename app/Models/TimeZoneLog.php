<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TimeZoneLog extends Model
{
    use HasFactory;

    protected $table = 'timezonelogs';

    const CREATED_AT = 'createdAt';
    const UPDATED_AT = 'updatedAt';

    protected $fillable = [
        'from', 'to', 'session_id'
    ];
}
