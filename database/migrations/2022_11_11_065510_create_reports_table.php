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
        Schema::create('reports', function (Blueprint $table) {
            $table->integer('id')->primary();
            $table->string('referral');
            $table->integer('facility_id')->nullable();
            $table->string('location');
            $table->string('issue');
            $table->string('proof_file');
            $table->enum('status', ['MENUNGGU', 'DIPROSES', 'SELESAI']);
            $table->timestamps();

            $table->foreign('facility_id')->references('id')->on('facilities')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reports');
    }
};