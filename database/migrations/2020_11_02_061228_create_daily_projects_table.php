<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDailyProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('daily_projects', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id');
            $table->date('order_date');
            $table->text('address');
            $table->foreignId('province_id');
            $table->foreignId('city_id');
            $table->string('kind_project');
            $table->integer('daily_value')->nullable();
            $table->foreignId('worker_id')->nullable();
            $table->integer('daily_salary')->nullable();
            $table->date('start_date')->nullable();
            $table->date('finish_date')->nullable();
            $table->integer('project_value')->nullable();
            $table->integer('profit')->nullable();
            $table->text('description')->nullable();
            $table->enum('process', ['waiting', 'priced', 'deal', 'finish', 'failed']);
            $table->enum('status', ['OnProcess', 'OnProgress', 'Finished']);
            $table->softDeletes();
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
        Schema::dropIfExists('daily_projects');
    }
}
