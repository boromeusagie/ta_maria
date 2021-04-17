<?php

namespace App\Http\Controllers;

use App\Kas;
use Illuminate\Http\Request;

class KasController extends Controller
{
    public function index()
    {
        $kas = Kas::all();
        return view('kas_index', ['kas' => $kas]);
    }
}
