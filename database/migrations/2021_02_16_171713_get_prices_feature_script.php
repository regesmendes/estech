<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class GetPricesFeatureScript extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared(file_get_contents('database/getPricesFeature.sql'));
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("DROP PROCEDURE `importPrices`;");
        DB::statement("DROP PROCEDURE `getPrices`;");
        DB::statement("ALTER TABLE `products` DROP INDEX `products_idx_sku`;");
        DB::statement("ALTER TABLE `accounts` DROP INDEX `accounts_idx_external_ref`;");
        DB::statement("ALTER TABLE `prices` DROP INDEX `prices_idx_account_id`;");
        DB::statement("ALTER TABLE `prices` DROP INDEX `prices_idx_product_id`;");
    }
}
