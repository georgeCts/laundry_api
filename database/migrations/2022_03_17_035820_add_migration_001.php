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
            $table->enum('status', ['PENDING', 'ACCEPTED', 'ON PROGRESS', 'FINISHED', 'CANCELLED'])->default('PENDING');
            $table->text('address');
            $table->text('reference');
            $table->boolean('express')->default(false);
            $table->dateTime('dt_request')->nullable();
            $table->dateTime('dt_start')->nullable();
            $table->dateTime('dt_end')->nullable();
            $table->dateTime('dt_finalized')->nullable();
            $table->dateTime('dt_cancelled')->nullable();
            $table->boolean('cancelled')->default(false);
            $table->boolean('delivered')->default(false);
            $table->boolean('use_dollars')->default(false);
            $table->float('subtotal')->default(0);
            $table->float('tax')->default(0);
            $table->float('total')->default(0);
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')
                ->onDelete("cascade")
                ->onUpdate("cascade");
        });

        Schema::create('services_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('service_id')->nullable();
            $table->unsignedBigInteger('service_catalog_id')->nullable();
            $table->float('quantity')->default(0);
            $table->float('total')->default(0);

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

        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('code', 6);
            $table->float('discount', 4);
            $table->boolean('special')->default(false);
            $table->integer('quantity');
            $table->timestamps();
            $table->boolean('active')->default(true);

            $table->foreign('user_id')->references('id')->on('users')
                ->onDelete("cascade")
                ->onUpdate("cascade");
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
        Schema::dropIfExists('coupons');
    }
}
