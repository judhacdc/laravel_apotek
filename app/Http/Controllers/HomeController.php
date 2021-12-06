<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $auth = Auth::user();
        $products = Product::with('User')->paginate(5);
        return view('home',[
            'auth' => $auth,
            'products' => $products
        ]);
    }

    public function show($id){
        $product = Product::where('id', $id)->first();
        return view('detail',[
            'product' => $product
        ]);
    }

    public function search(Request $request){
        $keyword = $request->search;
        $products = Product::with('User')->where('nama', 'like', '%'. $keyword . '%')->paginate(6);
        return view('welcome', [
            'products' => $products,
        ]);
    }
}
