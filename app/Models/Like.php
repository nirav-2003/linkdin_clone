<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    use HasFactory;

    protected $table = "likes";
    protected $primaryKey = "id";

    // public function likes()
    // {
    //     return $this->belongsTo(Post::class, 'post_id', 'id');
    // }
}
