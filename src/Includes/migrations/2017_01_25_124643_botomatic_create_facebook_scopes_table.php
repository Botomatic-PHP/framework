<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

use Botomatic\Engine\Facebook\Models\Scope;


/**
 * Class BotomaticCreateFacebookScopesTable
 */
class BotomaticCreateFacebookScopesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(Scope::TABLE, function (Blueprint $table) {

            $table->increments(Scope::ID)->unsigned();

            $table->integer(Scope::SESSION)->unique()->unsigned();
            $table->binary(Scope::SCOPE);

            $table->dateTime(Scope::TIMEOUT)->nullable();
            $table->dateTime(Scope::CREATED_AT);
            $table->dateTime(Scope::UPDATED_AT);

            $table->index([Scope::SESSION, Scope::TIMEOUT]);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop(Scope::TABLE);
    }
}