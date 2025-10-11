<?php

namespace App\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Support\Facades\Auth;

class DepartmentScope implements Scope
{
    public function apply(Builder $builder, Model $model)
    {
       if (Auth::check() && $user = Auth::user()) {
            if ($user->department_id) {
                // Terapkan filter berdasarkan department_id pengguna yang login
                $builder->where($model->getTable() . '.department_id', $user->department_id);
            }
        }
    }
}