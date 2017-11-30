<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use \Botomatic\Engine\Core\Models\Logs;

class CreateLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(Logs::TABLE, function (Blueprint $table) {

            $table->increments(Logs::ID)->unsigned();

            $table->integer(Logs::USER_ID)->unsigned();
            $table->tinyInteger(Logs::PLATFORM)->unsigned();
            $table->tinyInteger(Logs::SENT)->unsigned();
            $table->text(Logs::MESSAGE);

            $table->dateTime(Logs::CREATED_AT);

            $table->index([Logs::USER_ID, Logs::PLATFORM]);
            $table->index(Logs::PLATFORM);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop(Logs::TABLE);
    }
}
