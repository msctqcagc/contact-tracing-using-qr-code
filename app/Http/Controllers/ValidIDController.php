<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ValidIDController extends Controller
{
    public function index() {
        return view('valid-ids.index');
    }
}
