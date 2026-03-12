<?php

namespace App\Scope;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use JetBrains\PhpStorm\NoReturn;

class UserScope implements Scope
{
    #[NoReturn]
    public function apply(Builder $builder, Model $model): void
    {

        $userId = auth()->user()->id;
        if ($userId !== null) {
            $builder->where('user_id', $userId);
        }
    }
}
