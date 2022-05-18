<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuestionSelectOptionTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('question_select_options', function (Blueprint $table) {
            $table->id();

            $table->string('created_by', 255)->default('');
            $table->string('updated_by', 255)->default('');
            $table->integer('question_filed_id')->nullable();
            $table->string('label', 255)->default('');
            $table->string('value', 255)->default('');


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
        Schema::dropIfExists('question_select_options');
    }
}
