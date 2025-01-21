<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TermsOfUse extends Controller
{
    public function index()
    {
        return view('terms-of-use');
    }

    public function politica()
    {
        $data = [
            'user' => User::find(1),
            'config' => $config = DB::table('consulting_environments')->where('id', '=', 1)->first()
        ];

        return view('politica', $data);
    }
}
