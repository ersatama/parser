<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Contracts\DetskiiMirProductContract;

class CreateDetskiiMirProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(DetskiiMirProductContract::TABLE, function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger(DetskiiMirProductContract::PRODUCT_ID)->nullable();
            $table->string(DetskiiMirProductContract::SELF_ID)->nullable();
            $table->string(DetskiiMirProductContract::CODE)->nullable();
            $table->string(DetskiiMirProductContract::NAME)->nullable();
            $table->string(DetskiiMirProductContract::PRICE_ALMATY)->nullable();
            $table->string(DetskiiMirProductContract::PRICE_NURSULTAN)->nullable();
            $table->string(DetskiiMirProductContract::PRICE_AKTOBE)->nullable();
            $table->string(DetskiiMirProductContract::PRICE_USKAMAN)->nullable();
            $table->string(DetskiiMirProductContract::PRICE_SHYMKENT)->nullable();
            $table->string(DetskiiMirProductContract::PRICE_KARAGANDA)->nullable();
            $table->string(DetskiiMirProductContract::PRICE_KYZYLORDA)->nullable();
            $table->string(DetskiiMirProductContract::PRICE_URALSK)->nullable();
            $table->string(DetskiiMirProductContract::PRICE_TALDYKORGAN)->nullable();
            $table->string(DetskiiMirProductContract::PRICE_AKTAU)->nullable();
            $table->string(DetskiiMirProductContract::PRICE_TARAZ)->nullable();
            $table->string(DetskiiMirProductContract::PRICE_SEMEY)->nullable();
            $table->string(DetskiiMirProductContract::PRICE_TURKESTAN)->nullable();
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
        Schema::dropIfExists(DetskiiMirProductContract::TABLE);
    }
}
