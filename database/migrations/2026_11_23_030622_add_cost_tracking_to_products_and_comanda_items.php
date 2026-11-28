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
        Schema::table('products', function (Blueprint $table): void {
            $table->decimal('cost_price', 10, 2)->nullable();
        });
        Schema::table('comanda_items', function (Blueprint $table): void {
            $table->decimal('unit_cost', 10, 2)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('comanda_items', function (Blueprint $table): void {
            $table->dropColumn('unit_cost');
        });
        Schema::table('products', function (Blueprint $table): void {
            $table->dropColumn('cost_price');
        });
    }
};
