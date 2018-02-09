<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateTaggableTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $connection = config('taggable.connection');

        Schema::connection($connection)->table('taggable_tags', function (Blueprint $table) {
            $table->unsignedInteger('parent_id')->nullable();
            $table->foreign('parent_id')->references('id')->on('taggable_tags')->onDelete('null');
            $table->index('parent_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $connection = config('taggable.connection');

        Schema::connection($connection)->table('taggable_tags', function (Blueprint $table) {
            $table->dropForeign('taggable_tags_parent_id_foreign');
        });
    }
}
