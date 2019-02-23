<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('services', function (Blueprint $table) {
            $table->increments('id');
            $table->string('id_string');
            $table->integer('user_id');
            $table->integer('category_id');
            $table->integer('view_count')->default(0);
            $table->text('description');
            $table->integer('budget');
            $table->integer('id_lga')->nullable();
            $table->integer('id_state')->nullable();
            $table->string('slug');
            $table->string('landmark')->nullable();
            $table->string('priority')->default('normal');
            $table->string('attachment')->nullable();
            $table->string('photo')->default('service.png');
            $table->string('title');
            $table->string('remote');
            $table->string('contract');
            $table->tinyInteger('status')->default(0);
            $table->timestamp('start_date');
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
        Schema::dropIfExists('services');
    }
}
