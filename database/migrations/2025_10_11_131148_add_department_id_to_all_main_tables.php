<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $tables = ['users', 'commodities', 'commodity_acquisitions', 'commodity_locations'];

        foreach ($tables as $tableName) {
            Schema::table($tableName, function (Blueprint $table) use ($tableName) {
                $table->foreignId('department_id')
                    ->nullable()
                    ->constrained('departments')
                    ->cascadeOnUpdate()
                    ->nullOnDelete()
                    ->after('id');
            });
        }
    }

    public function down(): void
    {
        $tables = ['users', 'commodities', 'commodity_acquisitions', 'commodity_locations'];

        foreach ($tables as $tableName) {
            Schema::table($tableName, function (Blueprint $table) {
                $table->dropConstrainedForeignId('department_id');
            });
        }
    }
};
