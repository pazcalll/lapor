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
        Schema::create('report_files', function (Blueprint $table) {
            $table->integer('id')->autoIncrement();
            $table->text('proof_file');
            $table->integer('report_id');
            $table->timestamps();

            $table->foreign('report_id')->references('id')->on('reports')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('report_files');
    }
};