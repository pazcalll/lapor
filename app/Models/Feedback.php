<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Feedback extends Model
{
    protected $table = "feedbacks";
    use HasFactory;
    use Notifiable;
    protected $fillable = ['feedback', 'report_id', 'rating'];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}