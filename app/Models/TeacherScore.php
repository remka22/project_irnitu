<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeacherScore extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'teacher_score';
    protected $fillable = [
        'score',
    ];

    public function group_scores()
    {
        return $this->hasMany(GroupScore::class);
    }

    public function teacher(){
        return $this->hasOne(Teachers::class, 'id', 'teacher_id');
    }
}
