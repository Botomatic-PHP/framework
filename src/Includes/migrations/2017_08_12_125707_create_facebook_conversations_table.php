<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

use \Botomatic\Engine\Facebook\Models\Conversation\Collection;
use \Botomatic\Engine\Facebook\Models\Conversation\Locale;
use \Botomatic\Engine\Facebook\Models\Conversation;

class CreateFacebookConversationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(Conversation::TABLE, function (Blueprint $table) {

            $table->increments(Conversation::ID)->unsigned();

            $table->integer(Conversation::COLLECTION)->unsigned();
            $table->string(Conversation::KEY)->unique();
            $table->string(Conversation::DESCRIPTION);

            $table->dateTime(Conversation::CREATED_AT);
            $table->dateTime(Conversation::UPDATED_AT);

            $table->index([Conversation::COLLECTION, Conversation::KEY]);
            $table->index(Conversation::KEY);
        });

        Schema::create(Collection::TABLE, function (Blueprint $table) {

            $table->increments(Collection::ID)->unsigned();

            $table->string(Collection::NAME);
            $table->string(Collection::DESCRIPTION);

            $table->dateTime(Collection::CREATED_AT);
            $table->dateTime(Collection::UPDATED_AT);

        });

        Schema::create(Locale::TABLE, function (Blueprint $table) {

            $table->increments(Locale::ID)->unsigned();

            $table->integer(Locale::CONVERSATION_ID);
            $table->string(Locale::LOCALE);
            $table->string(Locale::TEXT);

            $table->index([Locale::CONVERSATION_ID, Locale::LOCALE], 'fb_conversation_locale_conv_id');

            $table->dateTime(Locale::CREATED_AT);
            $table->dateTime(Locale::UPDATED_AT);

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop(Conversation::TABLE);
        Schema::drop(Collection::TABLE);
        Schema::drop(Locale::TABLE);
    }
}
