<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SessionController extends Controller
{
    public function createSession(Request $request): string
    {
        // session();
        $request->session()->put('userId', 'Guwah');
        $request->session()->put('isMember', true); 
        return 'Session Created'; 
    }

    public function getSesion(Request $request): string
    {
        $userId = $request->session()->get('userId', 'guest');
        $isMember = $request->session()->get('isMember', false);

        return "User ID: $userId, Is Member: $isMember";
    }
}
