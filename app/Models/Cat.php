<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cat extends Model
{
    use HasFactory;

    protected $fillable = ['image_url', 'lifespan'];

    public function detail()
    {
        return $this->hasMany(CatsDetails::class, 'id');
    }
}
