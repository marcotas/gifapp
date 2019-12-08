<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as EloquentModel;

class ApplicationModel extends EloquentModel
{
    protected function serializeDate(\DateTimeInterface $date)
    {
        return $date->format(\DateTime::ATOM);
    }
}
