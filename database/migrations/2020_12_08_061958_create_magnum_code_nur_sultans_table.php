<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Contracts\MagnumCodeNurSultanContract;

class CreateMagnumCodeNurSultansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(MagnumCodeNurSultanContract::TABLE, function (Blueprint $table) {
            $table->id();
            $table->bigInteger(MagnumCodeNurSultanContract::PRODUCT_ID);
            $table->bigInteger(MagnumCodeNurSultanContract::PARENT_ID)->nullable();
            $table->string(MagnumCodeNurSultanContract::NAME);
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
        Schema::dropIfExists(MagnumCodeNurSultanContract::TABLE);
    }
}
