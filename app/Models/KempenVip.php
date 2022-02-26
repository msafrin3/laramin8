<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KempenVip extends Model
{
    use HasFactory;
    protected $table = 'kempen_vips';
    protected $guarded = ['id'];

    public function Kempen() {
        return $this->belongsTo('App\Models\Kempen', 'kempen_id');
    }
}
