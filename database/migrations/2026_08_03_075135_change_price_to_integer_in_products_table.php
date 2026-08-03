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
        Schema::table('products', function (Blueprint $table) {
            $table->integer('price_temp')->nullable();
        });

        DB::statement('UPDATE products SET price_temp = ROUND(price)');

        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('price');
        });

        Schema::table('products', function (Blueprint $table) {
            $table->renameColumn('price_temp', 'price');
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->decimal('price_temp', 10, 2)->nullable();
        });

        DB::statement('UPDATE products SET price_temp = price');

        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('price');
        });

        Schema::table('products', function (Blueprint $table) {
            $table->renameColumn('price_temp', 'price');
        });
    }
};
