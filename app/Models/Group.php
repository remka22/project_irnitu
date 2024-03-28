<?php

namespace App\Models;

use App\Models\Template;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'groups';

    public function templates()
    {
        return $this->hasOne(Template::class);
    }

    public function stream()
    {
        return $this->hasOne(Stream::class);
    }
}
