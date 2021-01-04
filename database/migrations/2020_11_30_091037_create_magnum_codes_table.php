<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Contracts\MagnumCodeContract;

class CreateMagnumCodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(MagnumCodeContract::TABLE, function (Blueprint $table) {
            $table->id();
            $table->bigInteger(MagnumCodeContract::PRODUCT_ID);
            $table->bigInteger(MagnumCodeContract::PARENT_ID)->nullable();
            $table->string(MagnumCodeContract::NAME);
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
        Schema::dropIfExists(MagnumCodeContract::TABLE);
    }
}
