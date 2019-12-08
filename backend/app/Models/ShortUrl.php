<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * @property int    $id
 * @property string $long
 * @property string $short
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class ShortUrl extends Model
{
    protected $fillable = [
        'long',
    ];

    protected $appends = ['short'];

    public static function findByCode($code): self
    {
        return self::findOrFail(bidecrypt($code));
    }

    public function getShortAttribute()
    {
        $code = biencrypt($this->id);

        return route('short-url.redirect', compact('code'));
    }
}
