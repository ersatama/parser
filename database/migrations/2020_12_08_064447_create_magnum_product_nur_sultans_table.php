<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Contracts\MagnumProductNursultanContract;

class CreateMagnumProductNurSultansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(MagnumProductNursultanContract::TABLE, function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger(MagnumProductNursultanContract::PRODUCT_ID)->nullable();
            $table->unsignedBigInteger(MagnumProductNursultanContract::MAGNUM_ID)->nullable();
            $table->string(MagnumProductNursultanContract::URL);
            $table->string(MagnumProductNursultanContract::NAME);
            $table->string(MagnumProductNursultanContract::PRICE_ALMATY)->nullable();
            $table->string(MagnumProductNursultanContract::PRICE_NURSULTAN)->nullable();
            $table->string(MagnumProductNursultanContract::PRICE_AKTOBE)->nullable();
            $table->string(MagnumProductNursultanContract::PRICE_USKAMAN)->nullable();
            $table->string(MagnumProductNursultanContract::PRICE_SHYMKENT)->nullable();
            $table->string(MagnumProductNursultanContract::PRICE_KARAGANDA)->nullable();
            $table->string(MagnumProductNursultanContract::PRICE_KYZYLORDA)->nullable();
            $table->string(MagnumProductNursultanContract::PRICE_URALSK)->nullable();
            $table->string(MagnumProductNursultanContract::PRICE_TALDYKORGAN)->nullable();
            $table->string(MagnumProductNursultanContract::PRICE_AKTAU)->nullable();
            $table->string(MagnumProductNursultanContract::PRICE_TARAZ)->nullable();
            $table->string(MagnumProductNursultanContract::PRICE_SEMEY)->nullable();
            $table->string(MagnumProductNursultanContract::PRICE_TURKESTAN)->nullable();
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
        Schema::dropIfExists(MagnumProductNursultanContract::TABLE);
    }
}
