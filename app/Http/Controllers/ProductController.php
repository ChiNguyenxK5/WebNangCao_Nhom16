<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pizza;

class ProductController extends Controller
{
    public function adminIndex()
    {
        $products = Pizza::all();
        return view('admin.dashboard', compact('products'));
    }

    public function index()
    {
        $products = Pizza::all();
        return response()->json(['success' => true, 'products' => $products]);
    }

    public function store(Request $request)
    {
        $product = Pizza::create($request->all());
        return response()->json(['success' => true, 'product' => $product]);
    }

    public function update(Request $request, Pizza $product)
    {
        $product->update($request->all());
        return response()->json(['success' => true, 'product' => $product]);
    }

    public function destroy(Pizza $product)
    {
        $product->delete();
        return response()->json(['success' => true]);
    }
}