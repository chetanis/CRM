<?php

namespace App\Http\Controllers;

use App\Models\Log;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CategoryController extends Controller
{
    public function index()
    {
        $categoris = Category::with('products')->get();
        $list = [];
        foreach ($categoris as $category) {
            $list[] = [
                'category' => $category,
                'products' => $category->products->count()
            ];
        }
        return view('Products.category', compact('list'));
    }

    //store the category
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
        ]);

        $category = new Category();
        $category->name = $request->input('name');
        $category->save();

        //create log
        Log::CreateLog('Créer categorie', 'categorie ajoutee: ' . $category->name);

        Session::flash('success', 'Catégorie ajoutée avec succès');

        return redirect()->route('categories.index');
    }

    //update category
    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|string',
        ]);

        $category->name = $request->input('name');
        $category->save();

        //create log
        Log::CreateLog('modifier categorie', 'categorie modifie: ' . $category->name);

        Session::flash('success', 'Catégorie modifiée avec succès');

        return redirect()->route('categories.index');
    }
}
