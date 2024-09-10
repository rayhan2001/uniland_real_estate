<?php

namespace App\Http\Controllers\Propertie;

use App\Http\Controllers\Controller;
use App\Models\Propertie;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class PropertieController extends Controller
{
    public function index()
    {
        return view('propertie.index');
    }

    public function store(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'type' => 'required',
            'price' => 'required',
            'location' => 'required',
            'images' => 'required',
            'beds' => 'required',
            'bath' => 'required',
            'area' => 'required',
        ]);

        if ($validation->fails()) {
            return response()->json($validation->errors(), 422);
        }

        $propertie = new Propertie();
        $propertie->title = $request->title;
        $propertie->favorite = $request->favorite;
        $propertie->type = $request->type;
        $propertie->price = $request->price;
        $propertie->price_for = $request->price_for;
        $propertie->location = $request->location;
        if ($request->hasFile('images')) { 
            $files = $request->file('images');
            $images = [];
            foreach ($files as $file) {
                $name = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                array_push($images, $name);
                $destinationPath = public_path('images/propertie');
                $file->move($destinationPath, $name);
            }
            $propertie->image = json_encode($images);
        }
        $propertie->beds = $request->beds;
        $propertie->bath = $request->bath;
        $propertie->area = $request->area;
        $propertie->added_by = $request->added_by;
        $propertie->description = $request->description;
        $propertie->gas = $request->gas;
        $propertie->status = $request->status;
        $propertie->is_deleted = $request->is_deleted;
        $propertie->visible_status = $request->visible_status;
        $propertie->save();

        return response()->json(['message'=> 'Propertie created successfully'],200);
    }

    public function update(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'id' => 'required|exists:properties,id',
            'title' => 'required|string|max:255',
            'type' => 'required',
            'price' => 'required',
            'location' => 'required',
            'beds' => 'required',
            'bath' => 'required',
            'area' => 'required',
        ]);

        if ($validation->fails()) {
            return response()->json($validation->errors(), 422);
        }

        $propertie = Propertie::find($request->id);
        if (!$propertie) {
            return response()->json(['message' => 'Property not found'], 404);
        }

        $propertie->title = $request->title;
        $propertie->favorite = $request->favorite;
        $propertie->type = $request->type;
        $propertie->price = $request->price;
        $propertie->price_for = $request->price_for;
        $propertie->location = $request->location;

        if ($request->hasFile('images')) { 
            $files = $request->file('images');
            $images = [];
            foreach ($files as $file) {
                $name = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                array_push($images, $name);
                $destinationPath = public_path('images/propertie');
                $file->move($destinationPath, $name);
            }
            $propertie->image = json_encode($images);
        }

        $propertie->beds = $request->beds;
        $propertie->bath = $request->bath;
        $propertie->area = $request->area;
        $propertie->added_by = $request->added_by;
        $propertie->description = $request->description;
        $propertie->gas = $request->gas;
        $propertie->status = $request->status;
        $propertie->is_deleted = $request->is_deleted;
        $propertie->visible_status = $request->visible_status;

        $propertie->save();

        return response()->json(['message'=> 'Propertie updated successfully'], 200);
    }

    public function destroy($id)
    {
        $propertie = Propertie::find($id);
        if ($propertie->image){
            unlink($propertie->image);
        }
        $propertie->delete();
        return response()->json(['message' => 'Property deleted successfully'], 200);
    }

    public function allData()
    {
        $propertie = Propertie::all();
        return response()->json(['data' => $propertie], 200);
    }
}
