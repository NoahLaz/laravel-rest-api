<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(Product::latest()->get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $verifiedData = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'price' => 'required|numeric',
        ]);

        $product = Product::create($verifiedData);

        return response()->json($product, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        return response()->json($product);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (Product::destroy($id)) {
            return response()->json(['message' => 'Product deleted successfully'], 200);
        }
        return response()->json(['message' => 'Product not found'], 404);
    }

    /**
     * Search the specified resource from storage.
     *
     * @param  Str  $name
     * @return \Illuminate\Http\Response
     */
    public function search($name)
    {
        $products = Product::where('name', 'like', '%' . $name . '%')->get();
        if ($products->count() > 0) {
            return response()->json($products, 200);
        }

        return response()->json(['message' => 'Product not found'], 404);
    }
}
