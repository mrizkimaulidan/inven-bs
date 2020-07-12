<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CommodityLocation extends Model
{
    protected $guarded = [];

    public function commodities()
    {
        return $this->hasMany(Commodity::class);
    }
}
