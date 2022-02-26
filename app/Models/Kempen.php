<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Kempen extends Model
{
    use HasFactory;
    protected $table = 'kempens';
    protected $guarded = ['id'];

    public function Type() {
        return $this->belongsTo('App\Models\Metadata', 'type_mtdt_id');
    }

    public function Sasaran() {
        return $this->belongsTo('App\Models\Metadata', 'sasaran_mtdt_id');
    }

    public function Kategori() {
        return $this->belongsTo('App\Models\Metadata', 'kategori_mtdt_id');
    }

    public function Vips() {
        return $this->hasMany('App\Models\KempenVip', 'kempen_id');
    }

    public function State() {
        $state = DB::connection('mic_bantuan')->table('dk_spr_negeri')->where('stateid', $this->stateid)->first();
        return $state->negeri;
    }

    public function Parlimen() {
        $parlimen = DB::connection('mic_bantuan')->table('dk_spr_parlimen')->where([
            'stateid' => $this->stateid,
            'parid' => $this->parid
        ])->first();
        return $parlimen->label1;
    }

    public function Dun() {
        $dun = DB::connection('mic_bantuan')->table('dk_spr_dun')->where([
            'stateid' => $this->stateid,
            'parid' => $this->parid,
            'dunid' => $this->dunid
        ])->first();
        return $dun->label1;
    }

    public function Dm() {
        $dm = DB::connection('mic_bantuan')->table('dk_spr_dm')->where([
            'stateid' => $this->stateid,
            'parid' => $this->parid,
            'dunid' => $this->dunid,
            'dmid' => $this->dmid
        ])->first();
        return $dm->label1;
    }

    public function User() {
        return $this->belongsTo('App\Models\User', 'user_id');
    }
}
