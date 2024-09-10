<?php

namespace App\Http\Controllers\Category;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Category;

class CategoryController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        $category = new Category();
        $category->name = $request->name;
        if ($request->hasFile('icon')) { 
            $image = $request->file('icon');
            $name = time() . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('images/categories/icon');
            $image->move($destinationPath, $name);
            $category->icon = $name;
        }
        $category->save();

        return response()->json(['message' => 'Category created successfully'], 200);
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        $category = Category::find($request->id);
        $category->name = $request->name;
        if ($request->hasFile('icon')) { 
            $image = $request->file('icon');
            $name = time() . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('images/categories/icon');
            $image->move($destinationPath, $name);
            $category->icon = $name;
        }
        $category->status = $request->status;
        $category->save();

        return response()->json(['message' => 'Category updated successfully'], 200);
    }

    public function destroy($id)
    {
        $category = Category::find($id);
        if ($category->icon){
            unlink($category->icon);
        }
        $category->delete();
        return response()->json(['message' => 'Category deleted successfully'], 200);
    }

    public function allCategory()
    {
        $categories = Category::all();
        return response()->json(['data' => $categories], 200);
    }
}
