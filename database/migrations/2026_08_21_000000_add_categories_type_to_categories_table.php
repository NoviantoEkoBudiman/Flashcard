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
        if (! Schema::hasColumn('categories', 'categories_type')) {
            Schema::table('categories', function (Blueprint $table) {
                $table->unsignedTinyInteger('categories_type')
                    ->default(1)
                    ->after('categories_name');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasColumn('categories', 'categories_type')) {
            Schema::table('categories', function (Blueprint $table) {
                $table->dropColumn('categories_type');
            });
        }
    }
};
