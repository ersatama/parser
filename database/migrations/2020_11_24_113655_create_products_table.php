<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Contracts\ProductContract;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(ProductContract::TABLE, function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger(ProductContract::USER_ID)->nullable();
            $table->unsignedInteger(ProductContract::SKU)->nullable();
            $table->string(ProductContract::NAME)->nullable();
            $table->string(ProductContract::NOMENCLATURE)->nullable();
            $table->string(ProductContract::PROVIDER)->nullable();
            $table->string(ProductContract::PRICE_ALMATY)->nullable();
            $table->string(ProductContract::PRICE_NURSULTAN)->nullable();
            $table->string(ProductContract::PRICE_AKTOBE)->nullable();
            $table->string(ProductContract::PRICE_USKAMAN)->nullable();
            $table->string(ProductContract::PRICE_SHYMKENT)->nullable();
            $table->string(ProductContract::PRICE_KARAGANDA)->nullable();
            $table->string(ProductContract::PRICE_KYZYLORDA)->nullable();
            $table->string(ProductContract::PRICE_URALSK)->nullable();
            $table->string(ProductContract::PRICE_TALDYKORGAN)->nullable();
            $table->string(ProductContract::PRICE_AKTAU)->nullable();
            $table->string(ProductContract::PRICE_TARAZ)->nullable();
            $table->string(ProductContract::PRICE_SEMEY)->nullable();
            $table->string(ProductContract::PRICE_TURKESTAN)->nullable();
            $table->string(ProductContract::PRICE_ALMATY_ECLUB)->nullable();
            $table->string(ProductContract::PRICE_NURSULTAN_ECLUB)->nullable();
            $table->string(ProductContract::PRICE_AKTOBE_ECLUB)->nullable();
            $table->string(ProductContract::PRICE_USKAMAN_ECLUB)->nullable();
            $table->string(ProductContract::PRICE_SHYMKENT_ECLUB)->nullable();
            $table->string(ProductContract::PRICE_KARAGANDA_ECLUB)->nullable();
            $table->string(ProductContract::PRICE_KYZYLORDA_ECLUB)->nullable();
            $table->string(ProductContract::PRICE_URALSK_ECLUB)->nullable();
            $table->string(ProductContract::PRICE_TALDYKORGAN_ECLUB)->nullable();
            $table->string(ProductContract::PRICE_AKTAU_ECLUB)->nullable();
            $table->string(ProductContract::PRICE_TARAZ_ECLUB)->nullable();
            $table->string(ProductContract::PRICE_SEMEY_ECLUB)->nullable();
            $table->string(ProductContract::PRICE_TURKESTAN_ECLUB)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(ProductContract::TABLE);
    }
}
