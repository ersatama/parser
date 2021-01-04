<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Contracts\MagnumProductContract;

class CreateMagnumProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(MagnumProductContract::TABLE, function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger(MagnumProductContract::PRODUCT_ID)->nullable();
            $table->unsignedBigInteger(MagnumProductContract::MAGNUM_ID)->nullable();
            $table->string(MagnumProductContract::URL);
            $table->string(MagnumProductContract::NAME);
            $table->string(MagnumProductContract::PRICE_ALMATY)->nullable();
            $table->string(MagnumProductContract::PRICE_NURSULTAN)->nullable();
            $table->string(MagnumProductContract::PRICE_AKTOBE)->nullable();
            $table->string(MagnumProductContract::PRICE_USKAMAN)->nullable();
            $table->string(MagnumProductContract::PRICE_SHYMKENT)->nullable();
            $table->string(MagnumProductContract::PRICE_KARAGANDA)->nullable();
            $table->string(MagnumProductContract::PRICE_KYZYLORDA)->nullable();
            $table->string(MagnumProductContract::PRICE_URALSK)->nullable();
            $table->string(MagnumProductContract::PRICE_TALDYKORGAN)->nullable();
            $table->string(MagnumProductContract::PRICE_AKTAU)->nullable();
            $table->string(MagnumProductContract::PRICE_TARAZ)->nullable();
            $table->string(MagnumProductContract::PRICE_SEMEY)->nullable();
            $table->string(MagnumProductContract::PRICE_TURKESTAN)->nullable();
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
        Schema::dropIfExists(MagnumProductContract::TABLE);
    }
}
