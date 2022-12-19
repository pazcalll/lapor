<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAddressDetail extends Model
{
    use HasFactory;
    protected $fillable = ['street', 'rt', 'rw', 'village', 'sub-district', 'user_id'];
}