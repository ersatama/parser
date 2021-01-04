<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Contracts\UserContract;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(UserContract::TABLE, function (Blueprint $table) {
            $table->id();
            $table->string(UserContract::NAME);
            $table->string(UserContract::EMAIL)->unique();
            $table->timestamp(UserContract::EMAIL_VERIFIED_AT)->nullable();
            $table->string(UserContract::PASSWORD);
            $table->rememberToken();
            $table->foreignId(UserContract::CURRENT_TEAM_ID)->nullable();
            $table->text(UserContract::PROFILE_PHOTO_PATH)->nullable();
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
        Schema::dropIfExists(UserContract::TABLE);
    }
}
