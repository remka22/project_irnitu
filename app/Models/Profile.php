<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'profiles';

    public function streams_b()
    {
        $year = date("Y") - 4;
        if (date("m") > 9) {
            $year++;
        }
        return $this->hasMany(Stream::class)
            ->whereNotIn('profile_id', [1])
            ->where('name', 'like', '%б-%')
            ->where('year', '>=', $year)
            ->orderBy('name');
    }

    public function streams_m()
    {
        $year = date("Y") - 2;
        if (date("m") > 9){
        $year++;
        }
        return $this->hasMany(Stream::class)
            ->whereNotIn('profile_id', [1])
            ->where('name', 'like', '%м-%')
            ->where('year', '>=', $year)
            ->orderBy('name');
    }
    public function streams_z()
    {
        $year = date("Y") - 5;
        if (date("m") > 9){
        $year++;
        }
        return $this->hasMany(Stream::class)
            ->whereNotIn('profile_id', [1])
            ->where('name', 'like', '%з-%')
            ->where('year', '>=', $year)
            ->orderBy('name');
    }
}
