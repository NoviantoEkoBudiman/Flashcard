<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        if (! Schema::hasColumn('cards', 'card_last_answer_correct')) {
            Schema::table('cards', function (Blueprint $table) {
                $table->boolean('card_last_answer_correct')
                    ->nullable()
                    ->after('card_status');
                $table->index(
                    ['cards_categories_id', 'card_last_answer_correct', 'card_status'],
                    'cards_practice_filter_index'
                );
            });
        }
    }

    public function down()
    {
        if (Schema::hasColumn('cards', 'card_last_answer_correct')) {
            Schema::table('cards', function (Blueprint $table) {
                $table->dropIndex('cards_practice_filter_index');
                $table->dropColumn('card_last_answer_correct');
            });
        }
    }
};
