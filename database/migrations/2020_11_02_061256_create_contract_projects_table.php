<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContractProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contract_projects', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id');
            $table->date('order_date');
            $table->text('address');
            $table->foreignId('province_id');
            $table->foreignId('city_id');
            $table->string('kind_project');
            $table->date('survey_date')->nullable();
            $table->time('survey_time')->nullable();
            $table->foreignId('surveyer_id')->nullable();
            $table->integer('approximate_value')->nullable();
            $table->integer('project_value')->nullable();
            $table->foreignId('worker_id')->nullable();
            $table->date('start_date')->nullable();
            $table->date('finish_date')->nullable();
            $table->integer('profit')->nullable();
            $table->text('description')->nullable();
            $table->enum('process', ['waiting', 'scheduled', 'surveyed', 'deal', 'done', 'finish', 'failed']);
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
        Schema::dropIfExists('contract_projects');
    }
}
