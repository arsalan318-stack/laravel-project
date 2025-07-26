<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use App\Category;
use App\User;
use App\About;
use App\Product;


class AdminController extends Controller
{
    public function index(){
        $users = User::count();
        $products = Product::count();
        $categories = Category::count();
        return view('Admin.dashboard',compact('users','products','categories'));
    }
    public function manage_user(){
        $users = User::all();
        return view('Admin.manage_user',compact('users'));
    }
    
    public function ban($id)
    {
        $user = User::findOrFail($id);
        $user->is_banned = true;
        $user->save();
    
        return back()->with('success', 'User banned successfully.');
    }
    
    public function unban($id)
    {
        $user = User::findOrFail($id);
        $user->is_banned = false;
        $user->save();
    
        return back()->with('success', 'User unbanned successfully.');
    }

    public function about(){
        $about = about::first();
        return view('Admin.about',compact('about'));
    }

    public function store_about(Request $request){
        $request->validate([
            'about_us' => 'required',
            'privacy_policy' => 'required',
            'terms_condition' => 'required',
            'faq' => 'required',
            'phone' => 'required',
            'email' => 'required|string|max:255',
            'address' => 'required',
            'facebook' => 'required|string|max:255',
            'youtube' => 'required|string|max:255',
            'twitter' => 'required|string|max:255',
            'instagram' => 'required|string|max:255',
            'image.*' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $about = new About();
        $about->about_us = $request->about_us;
        $about->privacy_policy = $request->privacy_policy;
        $about->terms_condition = $request->terms_condition;
        $about->faq = $request->faq;
        $about->phone = $request->phone;
        $about->email = $request->email;
        $about->address = $request->address;
        $about->facebook = $request->facebook;
        $about->youtube = $request->youtube;
        $about->twitter = $request->twitter;
        $about->instagram = $request->instagram;

        if($request->hasFile('image')){
            $destination='uploads/logo/'.$about->image;
            if(File::exists($destination)){
                File::delete($destination);
            }
            $file=$request->file('image');
            $filename=$file->getClientOriginalName();
            $file->move('uploads/logo/',$filename);
            $about->image=$filename;
        }
        $about->save();

    return redirect()->back()->with('success', 'About posted successfully!');
    }

    public function update_about(Request $request,$id){
        $request->validate([
            'about_us' => 'required',
            'privacy_policy' => 'required',
            'terms_condition' => 'required',
            'faq' => 'required',
            'phone' => 'required',
            'email' => 'required|string|max:255',
            'address' => 'required',
            'facebook' => 'required|string|max:255',
            'youtube' => 'required|string|max:255',
            'twitter' => 'required|string|max:255',
            'instagram' => 'required|string|max:255',
            'image.*' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $about = About::findOrFail($id);
        $about->about_us = $request->about_us;
        $about->privacy_policy = $request->privacy_policy;
        $about->terms_condition = $request->terms_condition;
        $about->faq = $request->faq;
        $about->phone = $request->phone;
        $about->email = $request->email;
        $about->address = $request->address;
        $about->facebook = $request->facebook;
        $about->youtube = $request->youtube;
        $about->twitter = $request->twitter;
        $about->instagram = $request->instagram;

        if($request->hasFile('image')){
            $destination='uploads/logo/'.$about->image;
            if(File::exists($destination)){
                File::delete($destination);
            }
            $file=$request->file('image');
            $filename=$file->getClientOriginalName();
            $file->move('uploads/logo/',$filename);
            $about->image=$filename;
        }
        $about->update();

    return redirect()->back()->with('success', 'About Updated successfully!');
    }

}
