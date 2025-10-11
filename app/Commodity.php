<?php

namespace App;

use App\Scopes\DepartmentScope;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Number;

class Commodity extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'condition' => 'integer',
    ];

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
     * Get the commodity location associated with the commodity.
     */
    public function commodity_location()
    {
        return $this->belongsTo(CommodityLocation::class);
    }

    /**
     * Get the commodity acquisition associated with the commodity.
     */
    public function commodity_acquisition()
    {
        return $this->belongsTo(CommodityAcquisition::class);
    }

    /**
     * Format a date value to Indonesian date format (dd-mm-yyyy).
     */
    public function indonesian_format_date($value)
    {
        return Carbon::parse($value)->format('d-m-Y');
    }

    /**
     * Format a currency value to Indonesian currency format.
     */
    public function indonesian_currency($value)
    {
        return Number::format($value, 2);
    }

    /**
     * Get the name of the condition based on the condition code.
     */
    public function getConditionName()
    {
        return match ($this->condition) {
            1 => 'Baik',
            2 => 'Kurang Baik',
            3 => 'Rusak Berat',
            default => null
        };
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }
}
