<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeacherScore extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'teacher_score';

    public function groups()
    {
        return $this->hasMAny(GroupScore::class);
    }
}
