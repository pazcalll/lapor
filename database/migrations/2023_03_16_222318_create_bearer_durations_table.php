<?php

use App\Models\BearerDuration;
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
        Schema::create('bearer_durations', function (Blueprint $table) {
            $table->id();
            $table->integer('customer_id');
            $table->string('year_start');
            $table->string('year_end');
            $table->timestamps();

            $table->foreign('customer_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
        });

        $userIds = User::where('role', User::ROLE_CUSTOMER)->select('id')->get();
        $userIds = Arr::flatten($userIds->toArray());
        foreach ($userIds as $key => $id) {
            BearerDuration::create([
                'customer_id' => $id,
                'year_start' => '2014',
                'year_end' => '2019'
            ]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bearer_durations');
    }
};
