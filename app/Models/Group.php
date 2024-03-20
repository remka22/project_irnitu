<?php

namespace App\Models;

use App\Http\Controllers\CenterCareer\Templates;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'groups';

    public function templates()
    {
        return $this->hasOne(Templates::class);
    }
}
