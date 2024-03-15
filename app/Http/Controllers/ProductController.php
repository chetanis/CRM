<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('Products.create');
    }

    //store a new product
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'price' => 'nullable|numeric|regex:/^\d+(\.\d{1,2})?$/',
            'description' => 'nullable|string',
            'current_stock' => 'nullable|numeric',
            'minimum_stock' => 'nullable|numeric',
            'category' => 'nullable|string'
        ]);

        // Create a new product instance
        $product = new Product();

        // Assign form data to the product instance
        $product->name = $request->input('name');
        $product->price = $request->input('price');
        $product->description = $request->input('description');
        $product->current_stock = $request->input('current_stock');
        $product->minimum_stock = $request->input('minimum_stock');
        $product->category = $request->input('category');

        // Save the product to the database
        $product->save();

        // Redirect back with a success message
        return redirect()->back()->with('success', 'Produit ajouter!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
