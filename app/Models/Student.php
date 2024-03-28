<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'students';

    public function group()
    {
        return $this->hasOne(Group::class, 'id', 'group_id');
    }

    public function otchet()
    {
        return $this->hasOne(StudentOtchet::class, 'student_id', 'id');
    }
}
