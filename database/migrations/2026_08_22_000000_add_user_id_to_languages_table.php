<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        if (! Schema::hasColumn('languages', 'user_id')) {
            Schema::table('languages', function (Blueprint $table) {
                $table->unsignedBigInteger('user_id')->nullable()->after('languages_id');
                $table->foreign('user_id', 'languages_user_id_foreign')
                    ->references('id')
                    ->on('users');
                $table->unique(
                    ['user_id', 'languages_name'],
                    'languages_user_name_unique'
                );
            });
        }
    }

    public function down()
    {
        if (Schema::hasColumn('languages', 'user_id')) {
            Schema::table('languages', function (Blueprint $table) {
                $table->dropUnique('languages_user_name_unique');
                $table->dropForeign('languages_user_id_foreign');
                $table->dropColumn('user_id');
            });
        }
    }
};
