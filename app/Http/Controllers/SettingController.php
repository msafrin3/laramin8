<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SettingController extends Controller
{
    
    public function setTheme(Request $request) {
        setcookie('laraveladmintheme', $request['theme'], time() + 86400 * 30);
    }

}
