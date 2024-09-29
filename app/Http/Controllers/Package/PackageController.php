<?php

namespace App\Http\Controllers\Package;

use App\Http\Controllers\Controller;
use App\Models\Package;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class PackageController extends Controller
{
    public function allPackages()
    {
        $packages = Package::all();
        return response()->json(['data' => $packages], 200);
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|unique:agents|max:255',
            'price' => 'required|numeric',

        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $package = new Package();
        $package->name = $request->name;
        $package->price = $request->price;
        $package->limit = $request->limit;
        $package->no_of_property = $request->no_of_property;
        $package->no_of_adds = $request->no_of_adds;
        $package->save();

        return response()->json(['message' => 'Package created successfully'], 200);
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|unique:agents|max:255',
            'price' => 'required|numeric',

        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $package = Package::find($request->id);
        $package->name = $request->name;
        $package->price = $request->price;
        $package->limit = $request->limit;
        $package->no_of_property = $request->no_of_property;
        $package->no_of_adds = $request->no_of_adds;
        $package->save();

        return response()->json(['message' => 'Package updated successfully'], 200);
    }

    public function destroy($id)
    {
        $package = Package::find($id);
        $package->delete();
        return response()->json(['message' => 'Package Deleted Successfully'], 200);
    }
}
