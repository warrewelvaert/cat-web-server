<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CatsDetails extends Model
{
    use HasFactory;

    protected $fillable = [
        'language',
        'name',
        'description',
        'origin',
        'temperament',
        'wikipedia_url'
    ];
}
