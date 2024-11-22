<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Attraction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AttractionController extends BaseController
{
    public function index()
    {
        return Attraction::all();
    }

    public function showView()
    {
        return view('attractions');
    }

    // Создать новую достопримечательность
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'location' => 'required|string|max:255',
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $attraction = Attraction::create($request->all());
        return response()->json($attraction, 201);
    }

    // Получить конкретную достопримечательность
    public function show($id)
    {
        $attraction = Attraction::findOrFail($id);
        return response()->json($attraction);
    }

    // Обновить достопримечательность
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'location' => 'required|string|max:255',
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $attraction = Attraction::findOrFail($id);
        $attraction->update($request->all());
        return response()->json($attraction);
    }

    // Удалить достопримечательность
    public function destroy($id)
    {
        $attraction = Attraction::findOrFail($id);
        $attraction->delete();

        return response()->json(null, 204);
    }
}
