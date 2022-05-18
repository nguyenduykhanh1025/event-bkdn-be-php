<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuestionFiledAnswerTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('question_filed_answers', function (Blueprint $table) {
            $table->id();
            $table->string('created_by', 255)->default('');
            $table->string('updated_by', 255)->default('');
            $table->integer('question_filed_id')->nullable();
            $table->integer('event_id')->nullable();
            $table->integer('participant_id')->nullable();
            $table->text('answers')->default(null);

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
        Schema::dropIfExists('question_filed_answers');
    }
}
