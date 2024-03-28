<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeacherScore extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'teacher_score';

    public function group_score()
    {
        return $this->hasMany(GroupScore::class);
    }

    public function teachers(){
        return $this->hasOne(Teachers::class, 'id', 'teacher_id');
    }
}
