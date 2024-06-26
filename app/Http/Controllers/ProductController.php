<?php

namespace App\Http\Controllers;

use App\Models\Log;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::latest()->paginate(10);
        return view(
            'Products.index',
            [
                'products' => $products
            ]
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        return view('Products.create', compact('categories'));
    }

    //store a new product
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'price' => 'required|numeric|regex:/^\d+(\.\d{1,2})?$/',
            'description' => 'nullable|string',
            'current_stock' => 'required|numeric',
            'minimum_stock' => 'required|numeric',
            'category_id' => 'required|exists:categories,id',
            'purchase_price' => 'required|numeric|regex:/^\d+(\.\d{1,2})?$/'
        ]);

        // Create a new product instance
        $product = new Product();

        // Assign form data to the product instance
        $product->name = $request->input('name');
        $product->price = $request->input('price');
        $product->description = $request->input('description');
        $product->current_stock = $request->input('current_stock');
        $product->minimum_stock = $request->input('minimum_stock');
        $product->category_id = $request->category_id;
        $product->purchase_price = $request->input('purchase_price');
        // Save the product to the database
        $product->save();

        //create log
        Log::CreateLog('Créer produit', 'Produit cree: ' . $product->name);

        // Redirect back with a success message
        return redirect()->back()->with('success', 'Produit ajouter!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::all();
        return view('Products.show', compact('product', 'categories'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $product = Product::findOrFail($id);

        $request->validate([
            'name' => 'required|string',
            'price' => 'required|numeric|regex:/^\d+(\.\d{1,2})?$/',
            'description' => 'nullable|string',
            'current_stock' => 'required|numeric',
            'minimum_stock' => 'required|numeric',
            'category_id' => 'required|int',
            'purchase_price' => 'required|numeric|regex:/^\d+(\.\d{1,2})?$/'
        ]);


        try {
            //check if he updated the stock
            if ($request->input('current_stock') != $product->current_stock) {
                //check if he added or subtracted stock
                if ($request->input('current_stock') > $product->current_stock) {
                    $product->addStock($request->input('current_stock') - $product->current_stock);
                } else {
                    $product->subtractStock($product->current_stock - $request->input('current_stock'));
                }
            }
            // Explicitly set the category_id before updating other attributes
            $product->category_id = $request->input('category_id');

            // Update other product attributes
            $product->update($request->except('category_id'));
            
            //create log
            Log::CreateLog('modifier produit', 'Produit modifie: ' . $product->name);
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
        //create log
        Log::CreateLog('supprimer produit', 'Produit supprime: ' . $product->name);
        return redirect()->route('products.index')->with('success', 'Produit supprimé avec succès !');
    }

    //add stock to a product
    public function addStock(Request $request, string $id)
    {
        $product = Product::findOrFail($id);
        $request->validate([
            'quantity' => 'required|numeric|min:1'
        ]);

        $product->addStock($request->input('quantity'));

        //create log
        Log::CreateLog('ajouter stock', 'Produit: ' . $product->name . ' quantite: ' . $request->input('quantity'));
        return redirect()->back()->with('success', 'Stock ajouté avec succès !');
    }

    //search for a product
    public function search(Request $request)
    {
        $search = $request->input('search');

        $products = Product::where('name', 'like', "%{$search}%")->paginate(10);

        return view('Products.index', ['products' => $products]);
    }
}
