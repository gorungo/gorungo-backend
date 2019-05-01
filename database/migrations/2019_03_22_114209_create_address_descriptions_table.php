<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAddressDescriptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('address_descriptions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('address_id')->unsigned();
            $table->integer('locale_id')->unsigned();
            $table->string('country',2);
            $table->string('administrative_area',100)->comment('State / Province / Region (ISO code when available)');
            $table->string('sub_administrative_area',100)->comment('County / District (unused)');
            $table->string('locality',100)->comment('City / Town');
            $table->string('postal_code',10)->comment('Postal code / ZIP Code');
            $table->string('thoroughfare',100)->comment('Street address');
            $table->string('premise',100)->comment('Apartment, Suite, Box number, etc.');
            $table->string('sub_premise',100)->comment('Apartment, Suite, Box number, etc.');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('address_descriptions');
    }
}
