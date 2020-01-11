<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBaseTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('groups', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('owner_id');
            $table->string('name');
            $table->boolean('can_join')->default(true);
            $table->timestamps();

            $table->foreign('owner_id')->references('id')->on('users');
        });

        Schema::create('group_users', function (Blueprint $table) {
            $table->unsignedBigInteger('group_id');
            $table->unsignedBigInteger('user_id');

            $table->primary([ 'group_id', 'user_id' ]);
        });

        Schema::create('prompts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('group_id');
            $table->string('prompt');
            $table->timestamps();

            $table->foreign('group_id')->references('id')->on('groups');
        });

        Schema::create('prompt_answers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('group_id');
            $table->unsignedBigInteger('prompt_id');
            $table->date('date');
            $table->string('prompt');
            $table->string('answer');
            $table->string('url')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('group_id')->references('id')->on('groups');
            $table->foreign('prompt_id')->references('id')->on('prompts');
        });

        Schema::create('core_feelings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->string('feeling');
            $table->string('url')->nullable();
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->integer('order')->default(0);
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('groups');
        Schema::dropIfExists('group_users');
        Schema::dropIfExists('prompts');
        Schema::dropIfExists('prompt_answers');
        Schema::dropIfExists('core_feelings');
    }
}
