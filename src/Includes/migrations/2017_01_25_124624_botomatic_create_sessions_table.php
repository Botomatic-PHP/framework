<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

use Botomatic\Engine\Core\Models\Session;

/**
 * Class BotomaticCreateSessionsTable
 */
class BotomaticCreateSessionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(Session::TABLE, function (Blueprint $table) {

            $table->increments(Session::ID)->unsigned();

            $table->string(Session::SESSION)->unique();
            $table->integer(Session::USER_ID)->unsigned();
            $table->integer(Session::PLATFORM)->nullable()->unsigned();

            $table->dateTime(Session::CREATED_AT);
            $table->dateTime(Session::UPDATED_AT);

            $table->index(Session::SESSION);
            $table->index(Session::USER_ID);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop(Session::TABLE);
    }
}
