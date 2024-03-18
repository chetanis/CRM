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
        $products = Product::latest()->paginate(10);
        return view('Products.index',
            [
                'products' => $products
            ]);
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
        $product = Product::findOrFail($id);
        return view('Products.show', ['product' => $product]);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
{
    $product = Product::findOrFail($id);

    $request->validate([
        'name' => 'required|string',
        'price' => 'nullable|numeric|regex:/^\d+(\.\d{1,2})?$/',
        'description' => 'nullable|string',
        'current_stock' => 'nullable|numeric',
        'minimum_stock' => 'nullable|numeric',
        'category' => 'nullable|string'
    ]);

    try {
        $product->update($request->all());
        return redirect()->back()->with('success', 'Produit mis à jour avec succès !');
    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Failed to update product. Please try again.');
    }
}


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product = Product::findOrFail($id);
        $product->delete();
        return $this->index();
    }

    //add stock to a product
    public function addStock(Request $request, string $id)
    {
        $product = Product::findOrFail($id);
        $request->validate([
            'quantity' => 'required|numeric|min:1'
        ]);

        $product->addStock($request->input('quantity'));
        return redirect()->back()->with('success', 'Stock ajouté avec succès !');
    }

    //search for a product
    public function search(Request $request)
    {
        $search = $request->input('search');

        $products = Product::where('name', 'like', "%{$search}%")->
        orWhere('category', 'like', "%{$search}%")->paginate(10);

        return view('Products.index', ['products' => $products]);
    }
}
