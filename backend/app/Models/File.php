<?php

namespace App\Models;

use Illuminate\Support\Carbon;

/**
 * @property int    $id
 * @property string $name
 * @property string $type
 * @property string $path
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class File extends ApplicationModel
{
    protected $fillable = [
        'name',
        'type',
        'path',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
    ];
}
