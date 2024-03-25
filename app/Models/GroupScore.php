<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GroupScore extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'score-group';

    public function teachers()
    {
        return $this->hasOne(TeacherScore::class, 'id', 'teacher_score_id');
    }
}
