<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BearerDuration extends Model
{
    use HasFactory;

    protected $fillable = ['customer_id', 'year_start', 'year_end'];

    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }
}
