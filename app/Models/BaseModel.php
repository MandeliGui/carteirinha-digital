<?php

namespace App\Models;

use App\Scope\UserScope;
use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model
{
    protected static function booted()
    {
        static::addGlobalScope(new UserScope());
    }
}
