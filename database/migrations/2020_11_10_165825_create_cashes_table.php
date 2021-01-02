<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCashesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cashes', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->date('date');
            $table->enum('category', ['in', 'out', 'owe', 'pay']);
            $table->integer('money_in')->default(0);
            $table->integer('money_out')->default(0);
            $table->foreignId('project_id')->nullable();
            $table->enum('project_type', ['daily', 'contract'])->nullable();
            $table->text('description')->nullable();
            $table->foreignId('user_id')->nullable();
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
        Schema::dropIfExists('cashes');
    }
}
