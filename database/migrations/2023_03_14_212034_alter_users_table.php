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
        //
        Schema::table('users', function (Blueprint $table) {
            $userStatuses = [
                User::ACCOUNT_STATUS_ACTIVE,
                User::ACCOUNT_STATUS_INACTIVE
            ];

            $table->enum('status', $userStatuses)->default(User::ACCOUNT_STATUS_ACTIVE)->after('appointment_letter');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::dropIfExists('status');
    }
};
