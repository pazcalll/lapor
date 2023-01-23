<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerPosition extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    const POSITION = ['Ketua RT', 'Ketua RW'];
}