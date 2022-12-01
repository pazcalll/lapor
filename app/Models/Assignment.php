<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Assignment extends Model
{
    use HasFactory;
    use Notifiable;

    protected $fillable = ['user_id', 'report_id', 'additional'];

    public function officer()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function report()
    {
        return $this->belongsTo(Report::class, "report_id");
    }
}