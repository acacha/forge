<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateServersTable
 */
class CreateServersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('servers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('ipAddress');
            $table->integer('forge_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->enum('state', ['pending','valid'])->default('pending');
            $table->string('token')->nullable();
            $table->timestamps();

            $table->unique(['user_id', 'forge_id']);
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('servers');
    }
}
