<?php

use App\Models\User;
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
        Schema::create('users', function (Blueprint $table) {
            $table->integer('id')->autoIncrement();
            $table->string('name');
            $table->enum('gender', [User::GENDER_PRIA, User::GENDER_WANITA])->default(User::GENDER_PRIA);
            $table->string('username')->unique();
            $table->string('password');
            $table->enum('role', [User::ROLE_ADMIN, User::ROLE_CUSTOMER, User::ROLE_OPD, User::ROLE_REGENT]);
            $table->string('phone')->nullable();
            $table->text('appointment_letter')->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
};
