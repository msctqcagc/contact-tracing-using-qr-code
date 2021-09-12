<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DiseaseController extends Controller
{
    public function index() {
        return view('diseases.index');
    }
}
