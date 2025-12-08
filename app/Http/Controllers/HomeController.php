<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Redirige a la página de login
     */
    public function index()
    {
        return redirect()->route('login');
    }
}
