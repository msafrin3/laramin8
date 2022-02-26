<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ApiController extends Controller
{
    public function getParlimen(Request $request) {
        try {
            $parlimen = DB::connection('mic_bantuan')->table('dk_spr_parlimen')->where([
                'stateid' => $request->input('stateid')
            ])->get();
            return response()->json(['success' => true, 'data' => $parlimen]);
        } catch(\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    public function getDun(Request $request) {
        try {
            $dun = DB::connection('mic_bantuan')->table('dk_spr_dun')->where([
                'stateid' => $request->input('stateid'),
                'parid' => $request->input('parid')
            ])->get();
            return response()->json(['success' => true, 'data' => $dun]);
        } catch(\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    public function getDm(Request $request) {
        try {
            $dm = DB::connection('mic_bantuan')->table('dk_spr_dm')->where([
                'stateid' => $request->input('stateid'),
                'parid' => $request->input('parid'),
                'dunid' => $request->input('dunid')
            ])->get();
            return response()->json(['success' => true, 'data' => $dm]);
        } catch(\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage]);
        }
    }
}
