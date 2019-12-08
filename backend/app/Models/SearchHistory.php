<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * @property int    $id
 * @property string $text
 * @property int    $hits
 * @property int    $user_id
 * @property Carbon $updated_at
 * @property Carbon $created_at
 * @property User   $user
 */
class SearchHistory extends ApplicationModel
{
    protected $fillable = [
        'text',
        'hits',
        'user_id',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function hit()
    {
        $this->update(['hits' => $this->hits + 1]);
    }
}
