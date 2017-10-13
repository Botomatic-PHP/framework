<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

use \Botomatic\Engine\Core\Models\User;

/**
 * Class BotomaticCreateUsersTable
 */
class BotomaticCreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(User::TABLE, function (Blueprint $table) {

            $table->increments(User::ID)->unsigned();
            $table->string(User::FACEBOOK)->nullable();
            $table->string(User::FACEBOOK_PAGE)->nullable();

            $table->string(User::WEB_CONNECTOR)->nullable();
            $table->string(User::ALEXA)->nullable();

            $table->string(User::FIRST_NAME)->nullable();
            $table->string(User::LAST_NAME)->nullable();

            $table->string(User::EMAIL)->nullable();
            $table->string(User::PHONE)->nullable();
            $table->string(User::IMAGE)->nullable();

            $table->string(User::GENDER)->nullable();


            $table->string(User::LOCALE)->default('en_US');
            $table->string(User::TIMEZONE)->default(1);


            $table->dateTime(User::CREATED_AT);
            $table->dateTime(User::UPDATED_AT);
            $table->dateTime(User::DELETED_AT)->nullable()->default(NULL);

            $table->index(User::EMAIL, 'user_email');
            $table->index(User::PHONE, 'user_phone');
            $table->index(User::WEB_CONNECTOR, 'user_connector');
            $table->index(User::ALEXA, 'user_alexa');
            $table->index(User::LOCALE);
            $table->index(User::TIMEZONE);
            $table->index(User::FACEBOOK_PAGE);
            $table->index([User::FACEBOOK, User::FACEBOOK_PAGE]);
            $table->index(User::GENDER);

        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop(User::TABLE);
    }
}
