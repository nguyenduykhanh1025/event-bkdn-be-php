<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();

            $table->string('title', 255)->default(null);
            $table->string('type', 45)->default(null);
            $table->integer('count_need_participate')->default(null);
            $table->integer('count_participated')->nullable();
            $table->integer('count_registered')->nullable();
            $table->dateTime('start_at')->default(null);
            $table->dateTime('end_at')->default(null);
            $table->string('address', 255)->default(null);
            $table->text('description')->default(null);
            $table->text('description_participant')->default(null);
            $table->text('description_required')->default(null);
            $table->text('images_str')->default(null);
            $table->string('status', 45)->default(null);
            $table->boolean('is_active')->default(true);

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
        Schema::dropIfExists('event_tables');
    }
}
