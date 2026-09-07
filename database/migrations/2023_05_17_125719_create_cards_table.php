<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cards', function (Blueprint $table) {
            $table->increments('cards_id');
            $table->unsignedInteger('cards_categories_id');
            $table->foreign('cards_categories_id')->references('categories_id')->on('categories');
            $table->string('cards_question');
            $table->string('cards_answer');
            $table->boolean('card_status')->default(false);
            $table->boolean('card_last_answer_correct')->nullable();
            $table->timestamps();
            $table->index(
                ['cards_categories_id', 'card_last_answer_correct', 'card_status'],
                'cards_practice_filter_index'
            );
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cards');
    }
};
