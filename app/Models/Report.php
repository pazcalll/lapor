<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Report extends Model
{
    use HasFactory;
    use Notifiable;
    protected $fillable = ['referral', 'facility_id', 'user_id', 'issue', 'proof_file', 'status'];

    const STATUS_WAITING = 'MENUNGGU DIVERIFIKASI';
    const STATUS_PROGRESS = 'SEDANG DIPROSES';
    const STATUS_REJECTED = 'DITOLAK';
    const STATUS_FINISHED = 'LAPORAN TELAH SELESAI';

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function assignment()
    {
        return $this->belongsTo(Assignment::class, 'id', 'report_id');
        // return $this->hasOne(Assignment::class,'report_id','id')->withTrashed();
    }

    public function reporter()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function facility()
    {
        return $this->hasOne(Facility::class, 'id', 'facility_id');
    }

    public function reportFile()
    {
        return $this->hasMany(ReportFile::class);
    }

    public function reportLocation()
    {
        return $this->hasOne(ReportLocation::class);
    }

    public function feedback()
    {
        return $this->belongsTo(Feedback::class, 'id', 'report_id');
    }
}
