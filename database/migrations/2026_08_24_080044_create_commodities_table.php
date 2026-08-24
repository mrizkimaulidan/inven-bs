<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('commodities', function (Blueprint $table) {
            $table->foreignId('commodity_funding_source_id')->constrained();
            $table->foreignId('commodity_location_id')->constrained();
            $table->foreignId('created_by')->constrained('users', 'id');
            $table->foreignId('updated_by')->nullable()->constrained('users', 'id');

            $table->string('item_code')->unique();
            $table->string('qr_code')->unique()->nullable();

            $table->string('name');
            $table->string('brand');
            $table->string('material');
            $table->year('purchase_year');
            $table->tinyInteger('condition');

            $table->integer('quantity');
            $table->decimal('total_price', 15, 2);
            $table->decimal('unit_price', 15, 2);
            $table->text('notes')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('commodities');
    }
};
