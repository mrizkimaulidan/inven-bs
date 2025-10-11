<?php

namespace App\Observers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class DepartmentObserver
{
     public function creating(Model $model): void
    {
        // Cek jika pengguna login dan memiliki department_id
        if (Auth::check() && $user = Auth::user()) {
            if ($user->department_id) {
                // Atur department_id pada model yang sedang dibuat
                $model->department_id = $user->department_id;
            }
        }
    }
}
