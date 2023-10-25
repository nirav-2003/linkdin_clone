<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class replay extends Model
{
    use HasFactory;

    protected $table = 'replays';
    protected $primaryKey = 'id';

    protected $fillable = ['replay'];
}
