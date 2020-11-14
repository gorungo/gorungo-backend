<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOsmsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('osms', function (Blueprint $table) {
            $table->increments('id');
            $table->string('boundingbox', 255)->nullable();
            $table->string('display_name', 255);
            $table->string('icon', 255)->nullable();
            $table->float('importance')->nullable();
            $table->string('lat', 10);
            $table->string('lon', 10);
            $table->string('licence', 200)->nullable();
            $table->unsignedInteger('osm_id');
            $table->string('osm_type', 50);
            $table->unsignedInteger('place_id');
            $table->string('type', 50);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('osms');
    }
}
