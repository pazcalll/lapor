<?php

use App\Models\Report;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
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
        Schema::table('reports', function (Blueprint $table) {
            $table->timestamp('deadline_at')->nullable()->after('status');
        });

        $report = Report::select('id', 'status')->get()->toArray();

        DB::beginTransaction();
        foreach ($report as $key => $value) {
            if ($value['status'] == Report::STATUS_FINISHED) {
                Report::where('id', $value['id'])->update([
                    'deadline_at' => now()
                ]);
            } else if ($value['status'] == Report::STATUS_PROGRESS) {
                Report::where('id', $value['id'])->update([
                    'deadline_at' => now()->addWeek()
                ]);
            }
        }
        DB::commit();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::table('reports', function (Blueprint $table) {
            $table->dropColumn('deadline_at');
        });
    }
};
