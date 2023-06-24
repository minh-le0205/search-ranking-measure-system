<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SearchEngines extends Model
{
    use HasFactory;

    protected $table = 'search_engines';

    protected $primaryKey = 'id';

    protected $hidden = [
        'updated_at',
        'deleted_at',
    ];

    protected $casts = [
        'updated_at' => 'datetime:Y-m-d H:i:s',
        'deleted_at' => 'datetime:Y-m-d H:i:s',
        'created_at' => 'datetime:Y-m-d H:i:s',
    ];
}
