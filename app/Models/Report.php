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
    protected $fillable = ['referral', 'facility_id', 'user_id', 'location', 'issue', 'proof_file', 'status'];

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
}