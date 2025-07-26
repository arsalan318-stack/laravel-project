<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;

class CategoryController extends Controller
{
    public function add_category(){
        return view('Admin.category.add_category');
    }

    public function manage_category(Request $request){
        $categories = Category::orderBy('id', 'desc')->get();
    /*  $search = $request->input('search');
      $perPage = $request->input('per_page', 2); // Default to 10
  
      $categories = Category::when($search, function ($query, $search) {
          return $query->where('name', 'like', "%$search%")
                       ->orWhere('description', 'like', "%$search%");
      })
      ->orderBy('id', 'desc')
      ->paginate($perPage)
      ->appends(['search' => $search, 'per_page' => $perPage]);*/
        return view('Admin.category.manage_category', compact('categories'));
    }

    public function store_category(Request $request){
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'status' => 'required|in:Published,Unpublished',
        ]);
    
        $imageName = null;
    if ($request->hasFile('image')) {
        // Get original name and make it unique
        $imageName = time() . '_' . $request->file('image')->getClientOriginalName();
        $request->file('image')->move(public_path('uploads/categories'), $imageName);
    }
        Category::create([
            'name' => $request->name,
            'description' => $request->description,
            'image' => $imageName,
            'status' => $request->status,
        ]);
     
        return redirect()->route('manage_category')->with('success', 'Category created successfully!');
    
    }


    public function edit_category($id)
{
    $category = Category::findOrFail($id);
    return view('Admin.category.edit_category', compact('category'));
}

public function delete_category($id)
{
    try{
    $category = Category::findOrFail($id);

    // Optionally delete image from storage
    //if ($category->image && file_exists(public_path('uploads/categories/' . $category->image))) {
     //   unlink(public_path('uploads/categories/' . $category->image));
   // }

    $category->delete();
    return redirect()->route('manage_category')->with('success', 'Category deleted successfully!');
    }
    catch(\Exception $e){

        return redirect()->route('manage_subcategory')->with('error', 'Failed to delete category.');
    }
}

public function update_category(Request $request, $id)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'description' => 'nullable|string',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        'status' => 'required|in:Published,Unpublished',
    ]);

    $category = Category::findOrFail($id);
    $category->name = $request->name;
    $category->description = $request->description;
    $category->status = $request->status;

    if ($request->hasFile('image')) {
        $imageName = time() . '.' . $request->image->extension();
        $request->image->move(public_path('uploads/categories'), $imageName);
        $category->image = $imageName;
    }

    $category->save();

    return redirect()->route('manage_category')->with('success', 'Category updated successfully.');
}
}
