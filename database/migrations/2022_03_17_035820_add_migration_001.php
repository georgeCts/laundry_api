<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMigration001 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /* Schema::create('locations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('name');
            $table->text('address');
            $table->text('reference');
            $table->timestamps();
 
            $table->foreign('user_id')->references('id')->on('users');
        }); */

        Schema::create('services_catalog', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->float('basic_price');
            $table->float('express_price');
            $table->string('unit_type');
            $table->boolean('active')->default(true);
            $table->timestamps();
        });

        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('status')->default('SOLICITUD');
            $table->text('address');
            $table->text('reference');
            $table->boolean('express')->default(false);
            $table->dateTime('dt_request')->nullable();
            $table->dateTime('dt_start')->nullable();
            $table->dateTime('dt_finish')->nullable();
            $table->dateTime('dt_canceled')->nullable();
            $table->float('subtotal');
            $table->float('tax');
            $table->float('total');

            $table->foreign('user_id')->references('id')->on('users');
        });

        Schema::create('services_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('service_id')->nullable();
            $table->unsignedBigInteger('service_catalog_id')->nullable();
            $table->float('quantity');

            $table->foreign('service_id')->references('id')->on('services');
            $table->foreign('service_catalog_id')->references('id')->on('services_catalog');
        });

        Schema::create('configurations', function (Blueprint $table) {
            $table->id();
            $table->string('key');
            $table->text('description')->nullable();
            $table->string('value');
            $table->timestamps();
            $table->boolean('active')->default(true);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('services_catalog');
        Schema::dropIfExists('services');
        Schema::dropIfExists('services_details');
        Schema::dropIfExists('configurations');
    }
}
