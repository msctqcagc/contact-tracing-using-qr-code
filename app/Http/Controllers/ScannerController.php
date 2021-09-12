<?php

namespace App\Http\Controllers;

use App\Models\Barangay;
use Illuminate\Http\Request;

class ScannerController extends Controller
{
    public function index() {
        $barangays = Barangay::whereNull('deleted_at')
            ->where('is_active', true)
            ->orderBy('name')
            ->get();

        return view('scanners.index')
            ->with('barangays', $barangays);
    }
}
