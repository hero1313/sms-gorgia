<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('lastname');
            $table->string('id_number');
            $table->integer('number')->nullable();
            $table->integer('gender');
            $table->integer('department')->nullable();
            $table->string('position')->nullable();
            $table->integer('branch_id')->nullable();
            $table->date('birthday')->format('d/m/Y')->nullable();
            $table->date('start_date')->format('d/m/Y')->nullable();
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
        Schema::dropIfExists('employees');
    }
};
