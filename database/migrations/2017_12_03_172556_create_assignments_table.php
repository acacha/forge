<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateAssignmentsTable
 */
class CreateAssignmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assignments', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('repository_uri')->nullable();
            $table->enum('repository_type',['github'])->nullable();
            $table->string('forge_site')->nullable();
            $table->enum('forge_server',['github'])->nullable();
            $table->timestamps();
        });

        Schema::create('assignables', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('assignment_id');
            $table->morphs('assignable');

            $table->timestamps();

            $table->foreign('assignment_id')->references('id')->on('assignments')->onDelete('cascade');
        });

        Schema::create('assignators', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('assignment_id');
            $table->morphs('assignator');

            $table->timestamps();

            $table->foreign('assignment_id')->references('id')->on('assignments')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('assignators');
        Schema::dropIfExists('assignables');
        Schema::dropIfExists('assignments');
    }
}
