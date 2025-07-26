<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use App\SubCategory;
use App\DynamicField;
class SubcategoryController extends Controller
{
    public function add_subcategory(){
        $category = Category::all();
        return view('Admin.subcategory.add_subcategory',compact('category'));
    }

    public function store_subcategory(Request $request){
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'status' => 'required|in:Published,Unpublished',
        ]);
    
        $imageName = null;
    if ($request->hasFile('image')) {
        // Get original name and make it unique
        $imageName = time() . '_' . $request->file('image')->getClientOriginalName();
        $request->file('image')->move(public_path('uploads/subcategories'), $imageName);
    }
    $subcategory = SubCategory::create([
            'category_id'=>$request->category_id,
            'name' => $request->name,
            'description' => $request->description,
            'image' => $imageName,
            'status' => $request->status,
        ]);
        // Save dynamic fields
    if ($request->has('fields')) {
        foreach ($request->fields as $field) {
            if (empty($field['field_name'])) continue;

            DynamicField::create([
                'subcategory_id' => $subcategory->id,
                'field_name' => $field['field_name'],
                'field_type' => $field['field_type'],
                'field_options' => $field['field_type'] === 'select'
                    ? array_map('trim', explode(',', $field['field_options'] ?? ''))
                    : null,
            ]);
        }
    }

        return redirect()->route('manage_subcategory')->with('success', 'SubCategory created successfully!');
    
    }
    public function manage_subcategory(Request $request){
        $subcategories = SubCategory::orderBy('id', 'desc')->get();
        return view('Admin.subcategory.manage_subcategory', compact('subcategories'));
    }

    public function delete_subcategory($id)
{
    try{
    $subcategory = SubCategory::findOrFail($id);

    // Optionally delete image from storage
    //if ($category->image && file_exists(public_path('uploads/categories/' . $category->image))) {
     //   unlink(public_path('uploads/categories/' . $category->image));
   // }

    $subcategory->delete();
    return redirect()->route('manage_subcategory')->with('success', 'SubCategory deleted successfully!');
    }
    catch(\Exception $e){

        return redirect()->route('manage_subcategory')->with('error', 'Failed to delete Subcategory.');
    }
}

public function edit_subcategory($id)
{
    $subcategory = SubCategory::findOrFail($id);
    $category = Category::all();
    return view('Admin.subcategory.edit_subcategory', compact('subcategory','category'));
}

public function update_subcategory(Request $request, $id)
{
    $request->validate([
        'category_id' => 'required|exists:categories,id',
        'name' => 'required|string|max:255',
        'description' => 'nullable|string',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        'status' => 'required|in:Published,Unpublished',
    ]);

    $subcategory = SubCategory::findOrFail($id);
    $subcategory->category_id= $request->category_id;
    $subcategory->name = $request->name;
    $subcategory->description = $request->description;
    $subcategory->status = $request->status;

    if ($request->hasFile('image')) {
        $imageName = time() . '.' . $request->image->extension();
        $request->image->move(public_path('uploads/subcategories'), $imageName);
        $subcategory->image = $imageName;
    }

    $subcategory->save();
       // Save dynamic fields
       if ($request->has('fields')) {
        foreach ($request->fields as $field) {
            if (empty($field['field_name'])) continue;

            DynamicField::updateOrCreate([
                'subcategory_id' => $subcategory->id,
                'field_name' => $field['field_name'],
                'field_type' => $field['field_type'],
                'field_options' => $field['field_type'] === 'select'
                    ? array_map('trim', explode(',', $field['field_options'] ?? ''))
                    : null,
            ]);
        }
    }
    return redirect()->route('manage_subcategory')->with('success', 'SubCategory updated successfully.');
}

}
