<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Template extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'templates';

    protected $fillable = [
        'decanat_check',
    ];
}
