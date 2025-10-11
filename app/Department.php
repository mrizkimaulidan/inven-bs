<?php
namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description'];

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function commodities()
    {
        return $this->hasMany(Commodity::class);
    }

    public function commodityAcquisitions()
    {
        return $this->hasMany(CommodityAcquisition::class);
    }

    public function commodityLocations()
    {
        return $this->hasMany(CommodityLocation::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }
}
