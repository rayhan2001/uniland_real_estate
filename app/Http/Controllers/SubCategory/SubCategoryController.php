<?php

namespace App\Http\Controllers\SubCategory;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\SubCategory;

class SubCategoryController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        $sub_category = new SubCategory();
        $sub_category->category_id = $request->category_id;
        $sub_category->name = $request->name;
        if ($request->hasFile('icon')) { 
            $image = $request->file('icon');
            $name = time() . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('images/sub-categories/icon');
            $image->move($destinationPath, $name);
            $sub_category->icon = $name;
        }
        $sub_category->save();

        return response()->json(['message' => 'Subcategory created successfully'], 200);
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        $sub_category = SubCategory::find($request->id);
        $sub_category->category_id = $request->category_id;
        $sub_category->name = $request->name;
        if ($request->hasFile('icon')) { 
            $image = $request->file('icon');
            $name = time() . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('images/sub-categories/icon');
            $image->move($destinationPath, $name);
            $sub_category->icon = $name;
        }
        $sub_category->status = $request->status;
        $sub_category->save();

        return response()->json(['message' => 'Subcategory updated successfully'], 200);
    }

    public function destroy($id)
    {
        $sub_category = SubCategory::find($id);
        $sub_category->delete();
        return response()->json(['message' => 'Subcategory deleted successfully'], 200);
    }

    public function allSubCategory()
    {
        $subcategories = SubCategory::with('category')->get();
        return response()->json(['data' => $subcategories], 200);
    }
}
