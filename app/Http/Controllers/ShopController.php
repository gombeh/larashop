<?php

namespace App\Http\Controllers;

use App\Category;
use App\Product;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pagination = 5;
        $categories = Category::all();
        if(request()->category) {
            $products = Product::with('categories')->whereHas('categories', function($query){
                $query->where('slug', request()->category);
            }) ;
            $categoryName = optional($categories->where('slug', request()->category)->first())->name;
        }else {
            $products = Product::with('categories')->where('featured', true);
            $categoryName = 'Featured';
        }

        if(request()->sort == 'low_high') {
            $products = $products->orderBy('price')->paginate($pagination);
        }else if(request()->sort == 'high_low') {
            $products = $products->orderBy('price', 'DESC')->paginate($pagination);
        }else {
            $products = $products->paginate($pagination);
        }

        return view('shop')->with([
            'products' =>  $products,
            'categories' => $categories,
            'categoryName' => $categoryName
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $slug
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $product = Product::where('slug', $slug)->firstOrFail();
        $mightAlsoLike = Product::where('slug', '!=', $slug)->mightAlsoLike()->get();
        return view('product')->with([
            'product' => $product,
            'mightAlsoLike' => $mightAlsoLike
            ]);
    }

    public function search(Request $request) {
        $request->validate([
            'query' => 'required|min:3'
        ]);
        // $products = Product::where('name', 'like', "%{$request->input('query')}%")
        //                     ->orWhere('details', 'like', "%{$request->input('query')}%")
        //                     ->orWhere('description', 'like', "%{$request->input('query')}%")
        //                     ->paginate(10);

        $products = Product::search($request->input('query'))->paginate(10);
        return view('search-result')->with('products', $products);
    }

    public function searchAlgolia(){
        return view('search-result-algolia');
    }

}
