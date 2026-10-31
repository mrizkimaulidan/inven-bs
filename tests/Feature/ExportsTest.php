<?php

namespace Tests\Feature;

use App\Exports\BrandsExport;
use App\Exports\CommoditiesExport;
use App\Exports\CommodityFundingSourcesExport;
use App\Exports\CommodityLocationsExport;
use App\Exports\MaterialsExport;
use App\Exports\RolesExport;
use App\Exports\UsersExport;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExportsTest extends TestCase
{
    use RefreshDatabase;

    public function test_all_export_collections_can_be_loaded(): void
    {
        $exports = [
            new BrandsExport,
            new CommoditiesExport,
            new CommodityFundingSourcesExport,
            new CommodityLocationsExport,
            new MaterialsExport,
            new RolesExport,
            new UsersExport,
        ];

        foreach ($exports as $export) {
            $this->assertCount(0, $export->collection());
            $this->assertNotEmpty($export->columns());
        }
    }
}
