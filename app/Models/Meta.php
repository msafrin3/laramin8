<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Meta extends Model
{
    use HasFactory;

    protected $table = 'meta';
    protected $guarded = ['id'];

    public function Metadata() {
        return $this->hasMany('App\Models\Metadata', 'meta_id');
    }
}
