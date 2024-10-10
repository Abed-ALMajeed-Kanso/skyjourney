<?php

namespace App\Http\Controllers; // Ensure this is correct

use App\Models\Model; // Replace 'Model' with your actual model name
use Illuminate\Http\Request;

class ModelController extends Controller // Make sure 'Controller' is correctly imported
{
    public function store(Request $request)
    {
        // Validate and create the model
        $model = Model::create($request->all());
        return response()->json($model, 201);
    }

    public function update(Request $request, $id)
    {
        // Find and update the model
        $model = Model::findOrFail($id);
        $model->update($request->all());
        return response()->json($model, 200);
    }

    public function destroy($id)
    {
        // Find and delete the model
        $model = Model::findOrFail($id);
        $model->delete();
        return response()->json(null, 204);
    }
}
