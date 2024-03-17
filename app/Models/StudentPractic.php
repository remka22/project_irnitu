<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentPractic extends Model
{
    use HasFactory;
    protected $table = 'student_practic';
    public $timestamps = false;

    public function company(){
        return $this->hasOne(Company::class, 'company_id', 'id');
    }
    public function student(){
        return $this->hasOne(Student::class, 'student_id', 'id');
    }
}
