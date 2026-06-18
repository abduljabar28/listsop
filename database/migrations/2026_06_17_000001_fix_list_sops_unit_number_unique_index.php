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
        Schema::table('list_sops', function (Blueprint $table) {
            $table->dropUnique('list_sops_number_unique');
            $table->unique(['work_unit', 'number'], 'list_sops_work_unit_number_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('list_sops', function (Blueprint $table) {
            $table->dropUnique('list_sops_work_unit_number_unique');
            $table->unique('number', 'list_sops_number_unique');
        });
    }
};
