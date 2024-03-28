<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GroupScore extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'group_score';

    public function teacher_score()
    {
        return $this->hasOne(TeacherScore::class, 'id', 'teacher_score_id');
    }

    public function groups()
    {
        return $this->hasOne(Group::class, 'id', 'group_id');
    }
}
