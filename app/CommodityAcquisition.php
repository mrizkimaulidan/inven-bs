<?php

namespace App;

use App\Scopes\DepartmentScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommodityAcquisition extends Model
{
    use HasFactory;

    protected $guarded = [];


    /**
     * Boot the model event booting process.
     * @return void
     */
   protected static function booted(): void
    {
        static::addGlobalScope(new DepartmentScope);

        // Otomatis isi department_id saat membuat data baru
        static::creating(function ($model) {
            if (auth()->check() && auth()->user()->department_id) {
                $model->department_id = auth()->user()->department_id;
            }
        });
    }

    /**
     * Get the commodities associated with the commodity location.
     */
    public function commodities()
    {
        return $this->hasMany(Commodity::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }
}
