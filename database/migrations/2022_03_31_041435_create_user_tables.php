<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('email', 45)->unique();
            $table->string('password', 255);
            $table->string('last_name', 255)->nullable();
            $table->string('first_name', 255)->nullable();
            $table->boolean('is_active')->default(true);
            $table->dateTime('last_time_login')->useCurrent();
            $table->string('phone_number', 12);
            $table->dateTime('birth_date')->nullable();
            $table->string('avatar', 255)->nullable();
            $table->text('info_description')->nullable();
            $table->string('id_student', 45)->nullable();

            $table->string('created_by', 255)->default('');
            $table->string('updated_by', 255)->default('');

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
        Schema::dropIfExists('users');
    }
}
