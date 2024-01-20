<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommoditiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('commodities', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('school_operational_assistance_id');
            $table->unsignedBigInteger('commodity_location_id');
            $table->string('item_code')->unique();
            $table->string('register');
            $table->string('name');
            $table->string('brand');
            $table->string('material');
            $table->bigInteger('year_of_purchase');
            $table->tinyInteger('condition');
            $table->bigInteger('quantity');
            $table->bigInteger('price');
            $table->bigInteger('price_per_item');
            $table->longText('note')->nullable();
            $table->timestamps();

            $table->foreign('school_operational_assistance_id')->references('id')->on('school_operational_assistances')->onDelete('CASCADE');
            $table->foreign('commodity_location_id')->references('id')->on('commodity_locations')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('commodities');
    }
}
