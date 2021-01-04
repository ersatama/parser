<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Contracts\DetskiiMirContract;

class CreateDetskiiMirsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(DetskiiMirContract::TABLE, function (Blueprint $table) {
            $table->id();
            $table->bigInteger(DetskiiMirContract::PARENT_ID)->nullable();
            $table->string(DetskiiMirContract::URL);
            $table->string(DetskiiMirContract::NAME);
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
        Schema::dropIfExists(DetskiiMirContract::TABLE);
    }
}
