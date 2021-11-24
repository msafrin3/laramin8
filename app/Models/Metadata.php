<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Metadata extends Model
{
    use HasFactory;

    protected $table = 'meta_data';
    protected $guarded = ['id'];

    public function Meta() {
        return $this->belongsTo('App\Models\Meta', 'meta_id');
    }
}
