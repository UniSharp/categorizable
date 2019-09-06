<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategorizableTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $connection = config('categorizable.connection');

        Schema::connection($connection)->create('categories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');

            $table->nestedSet();
            $table->timestamps();
        });

        Schema::connection($connection)->create('categorizable', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('category_id');
            $table->nullableMorphs('categorizable');

            $table->index('categorizable_type', 'categorizable_id');
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
        $connection = config('categorizable.connection');

        if (Schema::connection($connection)->hasTable('categories')) {
            Schema::connection($connection)->drop('categories');
        }

        if (Schema::connection($connection)->hasTable('categorizable')) {
            Schema::connection($connection)->drop('categorizable');
        }
    }
}
