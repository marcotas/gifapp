<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection as SupportCollection;
use Laravel\Passport\HasApiTokens;

/**
 * @property int               $id
 * @property string            $name
 * @property string            $email
 * @property string            $password
 * @property string            $remember_token
 * @property Carbon            $email_verified_at
 * @property Carbon            $created_at
 * @property Carbon            $updated_at
 * @property SupportCollection $favorite_gifs
 * @property Collection        $searchHistories
 */
class User extends Authenticatable
{
    use Notifiable, HasApiTokens;

    protected $fillable = [
        'name',
        'email',
        'password',
        'favorite_gifs',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $dates = [
        'email_verified_at',
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'favorite_gifs' => 'collection',
    ];

    protected function serializeDate(\DateTimeInterface $date)
    {
        return $date->format(\DateTime::ATOM);
    }

    public function searchHistories(): HasMany
    {
        return $this->hasMany(SearchHistory::class);
    }
}
