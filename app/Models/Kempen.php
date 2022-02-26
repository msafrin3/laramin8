<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kempen extends Model
{
    use HasFactory;
    protected $table = 'kempens';
    protected $guarded = ['id'];

    public function Type() {
        return $this->belongsTo('App\Models\MetaData', 'type_mtdt_id');
    }

    public function Sasaran() {
        return $this->belongsTo('App\Models\MetaData', 'sasaran_mtdt_id');
    }

    public function Kategori() {
        return $this->belongsTo('App\Models\MetaData', 'kategori_mtdt_id');
    }
}
