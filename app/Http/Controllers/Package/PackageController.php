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
        $packages = Package::all()->map(function ($package) {
            return [
                'id' => $package->id,
                'package_name' => $package->package_name,
                'price' => $package->price,
                'frequency' => $package->frequency,
                'no_of_adds'=> $package->no_of_adds,
                'status' => $package->status,
                'features' => [
                    'property_limit' => $package->property_limit,
                    'agent_profile' => $package->agent_profile, 
                    'agency_profile' => $package->agency_profile,
                    'featured_properties' => $package->featured_properties,
                ],
            ];
        });
    
        return response()->json(['data' => $packages], 200);
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'package_name' => 'required',
            'price' => 'required',

        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $package = new Package();
        $package->package_name = $request->package_name;
        $package->price = $request->price;
        $package->frequency = $request->frequency;
        $package->property_limit = $request->property_limit;
        $package->no_of_adds = $request->no_of_adds;
        $package->agent_profile = $request->agent_profile;
        $package->featured_properties = $request->featured_properties;
        $package->agency_profile = $request->agency_profile;
        $package->save();

        return response()->json(['message' => 'Package created successfully'], 200);
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'package_name' => 'required',
            'price' => 'required',

        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $package = Package::find($request->id);
        $package->package_name = $request->package_name;
        $package->price = $request->price;
        $package->frequency = $request->frequency;
        $package->property_limit = $request->property_limit;
        $package->no_of_adds = $request->no_of_adds;
        $package->agent_profile = $request->agent_profile;
        $package->featured_properties = $request->featured_properties;
        $package->agency_profile = $request->agency_profile;
        $package->status = $request->status;
        $package->save();

        return response()->json(['message' => 'Package updated successfully'], 200);
    }

    public function destroy($id)
    {
        $package = Package::find($id);
        $package->is_delete = 1;
        $package->delete();
        return response()->json(['message' => 'Package Deleted Successfully'], 200);
    }

    // For agent
    public function getPackages()
    {
        try {
            $packages = Package::where('status', 'active')->orderBy('id', 'desc')
                                ->get()
                                ->map(function ($package) {
                return [
                    'id' => $package->id,
                    'package_name' => $package->package_name,
                    'price' => $package->price,
                    'frequency' => $package->frequency,
                    'no_of_adds' => $package->no_of_adds,
                    'status' => $package->status,
                    'features' => [
                        'property_limit' => $package->property_limit,
                        'agent_profile' => $package->agent_profile, 
                        'agency_profile' => $package->agency_profile,
                        'featured_properties' => $package->featured_properties,
                    ],
                ];
            });

            if ($packages->isEmpty()) {
                return response()->json(['message' => 'No active packages found.'], 404);
            }

            return response()->json(['data' => $packages], 200);

        } catch (\Exception $e) {
            return response()->json(['error' => 'Something went wrong.'], 500);
        }
    }
}
