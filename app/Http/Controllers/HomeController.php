<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use App\Product;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth' => 'verified']);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(){
        $newProducts = Product::where('user_id', '1')->where('status','=','active')->get();
        $featuredProducts = Product::where('type', 'featured')->where('status','=','active')->get();
        $randomProducts = Product::inRandomOrder()->where('status','=','active')->limit(6)->get();        
        return view('Users.index',compact('newProducts','featuredProducts','randomProducts'));
    }
}
