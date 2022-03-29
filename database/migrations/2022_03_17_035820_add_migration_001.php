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

        Schema::create('unit_types', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('key_es');
            $table->string('key_en');
            $table->boolean('active')->default(true);
        });

        Schema::create('services_catalog', function (Blueprint $table) {
            $table->id();
            $table->string('name_es');
            $table->string('name_en');
            $table->float('basic_price');
            $table->float('express_price');
            $table->unsignedBigInteger('unit_type_id');
            $table->boolean('active')->default(true);
            $table->timestamps();

            $table->foreign('unit_type_id')->references('id')->on('unit_types')
                ->onDelete("cascade")
                ->onUpdate("cascade");
        });

        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->enum('status', ['PENDING', 'ACCEPTED', 'ON PROGRESS', 'FINISHED', 'CANCELED'])->default('PENDING');
            $table->text('address');
            $table->text('reference');
            $table->boolean('express')->default(false);
            $table->dateTime('dt_request')->nullable();
            $table->dateTime('dt_start')->nullable();
            $table->dateTime('dt_finish')->nullable();
            $table->dateTime('dt_canceled')->nullable();
            $table->boolean('canceled')->default(false);
            $table->float('subtotal');
            $table->float('tax');
            $table->float('total');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')
                ->onDelete("cascade")
                ->onUpdate("cascade");
        });

        Schema::create('services_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('service_id')->nullable();
            $table->unsignedBigInteger('service_catalog_id')->nullable();
            $table->float('quantity');

            $table->foreign('service_id')->references('id')->on('services')
                ->onDelete("cascade")
                ->onUpdate("cascade");
            $table->foreign('service_catalog_id')->references('id')->on('services_catalog')
                ->onDelete("cascade")
                ->onUpdate("cascade");
        });

        Schema::create('configurations', function (Blueprint $table) {
            $table->id();
            $table->string('key');
            $table->text('description')->nullable();
            $table->string('value');
            $table->boolean('active')->default(true);
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
        Schema::dropIfExists('services_details');
        Schema::dropIfExists('services');
        Schema::dropIfExists('services_catalog');
        Schema::dropIfExists('unit_types');
        Schema::dropIfExists('configurations');
    }
}
