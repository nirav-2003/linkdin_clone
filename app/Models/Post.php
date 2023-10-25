<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $table = 'posts';
    protected $primaryKey = 'id';

    protected $fillable = ['postname'];

    public function likes()
    {
        return $this->hasMany(Like::class, 'post_id', 'id');
    }

    public function img()
    {
        return $this->hasMany(Images::class, 'post_id', 'id');
    }

    public function replay()
    {
        return $this->hasMany(replay::class, 'post_id', 'id');
    }
}
