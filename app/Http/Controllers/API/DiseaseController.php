<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\DiseaseResource;
use App\Models\Disease;
use Illuminate\Http\Request;

class DiseaseController extends Controller
{
    public function index() {
        $diseases = Disease::whereNull('deleted_at')
            ->orderBy('updated_at', 'desc')
            ->get();

        return response(json_encode(['diseases' => DiseaseResource::collection($diseases)]));
    }

    public function store(Request $request) {
        Disease::create([
            'name' => $request->name,
            'description' => $request->description
        ]);

        return response('', 201);
    }

    public function update($id, Request $request) {
        $disease = Disease::find($id);
        if ($disease) {
            $disease->name = $request->name;
            $disease->description = $request->description;
            $disease->save();
        }

        return response('');
    }

    public function destroy($id) {
        $disease = Disease::find($id);
        if ($disease) {
            $disease->timestamps = false;
            $disease->delete();
        }

        return response('');
    }
}
