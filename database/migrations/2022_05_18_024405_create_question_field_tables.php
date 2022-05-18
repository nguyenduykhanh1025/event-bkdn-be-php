<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuestionFieldTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('question_fields', function (Blueprint $table) {
            $table->id();

            $table->integer('event_id')->nullable();
            $table->string('type', 45)->default(null);
            $table->string('label', 255)->default(null);
            $table->text('description')->default(null);
            $table->string('value', 255)->default(null);
            $table->string('answers_correct', 255)->default(null);

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
        Schema::dropIfExists('question_fields');
    }
}
