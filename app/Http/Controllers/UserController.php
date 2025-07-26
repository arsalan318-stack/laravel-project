<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use illuminate\Support\Facades\Auth;
use App\User;
use App\Category;
use App\SubCategory;
use App\Product;
use Illuminate\Support\Facades\File;


class UserController extends Controller
{
    public function index(){
        $newProducts = Product::orderBy('id', 'desc')->where('status','=','active')->take(6)->get();
        $featuredProducts = Product::where('type', 'featured')->where('status','=','active')->get();
        $randomProducts = Product::inRandomOrder()->where('status','=','active')->limit(6)->get();        
        return view('Users.index',compact('newProducts','featuredProducts','randomProducts'));
    }

    public function profile(){
        $data=Auth::user();
        return view('Users.profile',compact('data'));
    }

    public function profileupdate(Request $request){
        $request->validate([
            'fname' =>'required|alpha',
            'lname' =>'required|alpha',
            'phone' =>'required|digits:11',
            'cnic' =>'required|digits:13',
            'tel' =>'required|digits:11',
            'address' =>'required',
            'postcode' =>'required',
            'city' =>'required|alpha',
            'gender' =>'required',
            'dob' =>'required',
            'country' =>'required|alpha',
        ]);
        $user_id=Auth::user()->id;
        $user = User::findorfail($user_id);
        $user->fname = $request->input('fname');
        $user->lname = $request->input('lname');
        $user->phone = $request->input('phone');
        $user->cnic = $request->input('cnic');
        $user->tel = $request->input('tel');
        $user->address = $request->input('address');
        $user->postcode = $request->input('postcode');
        $user->city = $request->input('city');
        $user->gender = $request->input('gender');
        $user->dob = $request->input('dob');
        $user->country = $request->input('country');
        
        if($request->hasFile('image')){
            $destination='uploads/profiles/'.$user->image;
            if(File::exists($destination)){
                File::delete($destination);
            }
            $file=$request->file('image');
            $filename=$file->getClientOriginalName();
            $file->move('uploads/profiles/',$filename);
            $user->image=$filename;
        }
        $user->update();
       // dd($user);
       // print_r($user);
        return redirect()->back()->with('status','profile updated');
    }

    public function post_ad(){
        $categories = Category::where('status','=','published')->get();
        return view('Users.post_ad',compact('categories'));
    }

    public function store_ad(Request $request)
{
    $request->validate([
        'category_id' => 'required|exists:categories,id',
        //'type' => 'required',
        'title' => 'required|string|max:255',
        'description' => 'required',
        'price' => 'required|string|max:255',
        'seller_name' => 'required|string|max:255',
        'phone' => 'required',
        'location' => 'required',
        //'ad_type' => 'required',
        'payment_method' => 'required',
        'images.*' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
    ]);

    $ad = new Product();
    $ad->user_id = auth()->id(); 
    $ad->category_id = $request->category_id;
    $ad->subcategory_id = $request->subcategory_id;
    $ad->type = $request->type;
    $ad->title = $request->title;
    $ad->features = $request->input('custom'); // Saves as JSON
    $ad->description = $request->description;
    $ad->price = $request->price;
    $ad->seller_name = $request->seller_name;
    $ad->phone = $request->phone;
    $ad->hide_phone = $request->has('hide_phone');
    $ad->location = $request->location;
    $ad->ad_type = $request->ad_type;
    $ad->payment_method = $request->payment_method;

    if($request->hasFile('image1')){
        $destination='uploads/products/'.$ad->image1;
        if(File::exists($destination)){
            File::delete($destination);
        }
        $file=$request->file('image1');
        $filename=$file->getClientOriginalName();
        $file->move('uploads/products/',$filename);
        $ad->image1=$filename;
    }
    if($request->hasFile('image2')){
        $destination='uploads/products/'.$ad->image2;
        if(File::exists($destination)){
            File::delete($destination);
        }
        $file=$request->file('image2');
        $filename=$file->getClientOriginalName();
        $file->move('uploads/products/',$filename);
        $ad->image2=$filename;
    }

    if($request->hasFile('image3')){
        $destination='uploads/products/'.$ad->image3;
        if(File::exists($destination)){
            File::delete($destination);
        }
        $file=$request->file('image3');
        $filename=$file->getClientOriginalName();
        $file->move('uploads/products/',$filename);
        $ad->image3=$filename;
    }

    $ad->save();

    return redirect()->back()->with('success', 'Ad posted successfully!');
}

public function getSubcategories($id)
{
    $subcategories = Subcategory::where('category_id', $id)->get();

    return response()->json($subcategories);
}

public function get_products($id){
    $categories = Category::where('status','=','published')->take(10)->get();
    $products = Product::where('subcategory_id','=',$id)->where('status','=','active')->orderBy('id','desc')->paginate(6);
    return view('Users.all_products',compact('products','categories'));
}

public function sort_asc($id){
    $products = Product::where('subcategory_id','=',$id)->where('status','=','active')->orderBy('price','asc')->paginate(6);
    return view('Users.all_products',compact('products'));
}

public function sort_dsc($id){
    $products = Product::where('subcategory_id','=',$id)->where('status','=','active')->orderBy('price','desc')->paginate(6);
    return view('Users.all_products',compact('products'));
}

public function get_category_products($id){
    $categories = Category::where('status','=','published')->withCount('products')->take(10)->get();
    $products = Product::where('category_id','=',$id)->where('status','=','active')->orderBy('id','desc')->paginate(6);
    return view('Users.all_products',compact('products','categories'));
}

public function search(Request $request){

    $categories = Category::where('status','=','published')->take(10)->get();
    
    $query = Product::query();

    if ($request->filled('location')) {
        $query->where('location', $request->location);
    }

    if ($request->filled('category')) {
        $query->Orwhere('category_id', $request->category);
    }

    if ($request->filled('key-word')) {
        $query->Orwhere('title', 'like', '%' . $request->input('key-word') . '%');
    }

    $products = $query->paginate(6);

    return view('Users.all_products', compact('products','categories'));
}

public function get_product_details($id){
    // Get the main product
    $products = Product::findOrFail($id); // Better than where()->first()

    // Get other products by the same user (excluding this one)
    $userAds = Product::where('user_id', $products->user_id)
                      ->where('id', '!=', $products->id)
                      ->latest()
                      ->take(10)
                      ->get();
    
    return view('Users.product_details', [
        'products' => $products,   // singular name, since it's one product
        'userAds' => $userAds    // collection of other ads
    ]);
}
public function my_ads(){
    $user = Auth::user();
    $ad = Product::where('user_id',$user->id)->orderBy('id','desc')->paginate(4);
    return view('Users.my_ads',compact('ad'));
}

public function get_subcategory_fields($id)
{
    try{
    $subcategory = Subcategory::with('fields')->findOrFail($id);

    return view('Users.dynamic_fields', compact('subcategory'));
    }catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()], 500);
    }

}


}
