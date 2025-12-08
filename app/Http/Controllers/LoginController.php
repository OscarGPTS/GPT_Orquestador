<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LoginController extends Controller
{
    /**
     * Mostrar vista de login
     */
    public function show()
    {
        return view('login');
    }
}
