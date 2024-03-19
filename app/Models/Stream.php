<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stream extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'streams';

    public function groups()
    {
        return $this->hasMany(group::class);
    }
}

