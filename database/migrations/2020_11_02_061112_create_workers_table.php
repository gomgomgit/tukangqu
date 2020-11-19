<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWorkersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('workers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('birth_place');
            $table->date('birth_date');
            $table->string('email');
            $table->string('phone_number', 22);
            $table->string('address');
            $table->integer('rt');
            $table->integer('rw');
            $table->foreignId('province_id');
            $table->foreignId('city_id');
            $table->foreignId('district_id');
            $table->foreignId('village_id');
            $table->foreignId('worker_kind_id');
            $table->foreignId('specialist_id');
            $table->string('experience');
            $table->string('self_photo');
            $table->string('id_card_photo');
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
        Schema::dropIfExists('workers');
    }
}
