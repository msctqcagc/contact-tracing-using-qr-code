<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\BarangayResource;
use App\Models\Barangay;
use Illuminate\Http\Request;

class BarangayController extends Controller
{
    public function index() {
        $barangays = Barangay::whereNull('deleted_at')
            ->orderBy('updated_at', 'desc')
            ->get();

        return response(json_encode(['barangays' => BarangayResource::collection($barangays)]));
    }

    public function store(Request $request) {
        Barangay::create([
            'name' => $request->name,
            'chairman' => $request->chairman,
            'chairman_contact_number' => $request->chairman_contact_number,
            'is_active' => (!$request->has('is_active')) ? false : true
        ]);

        return response('', 201);
    }

    public function update($id, Request $request) {
        $barangay = Barangay::find($id);
        if ($barangay) {
            $barangay->name = $request->name;
            $barangay->chairman = $request->chairman;
            $barangay->chairman_contact_number = $request->chairman_contact_number;
            $barangay->is_active = (!$request->has('is_active')) ? false : true;
            $barangay->save();
        }

        return response('');
    }

    public function destroy($id) {
        $barangay = Barangay::find($id);
        if ($barangay) {
            $barangay->timestamps = false;
            $barangay->delete();
        }

        return response('');
    }
}
