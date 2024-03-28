<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Command;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CommandController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //if the user is an admin or superuser, show all commands
        if (auth()->user()->privilege === 'admin' || auth()->user()->privilege === 'superuser') {

            $commands = Command::latest()->paginate(10);
            return view('commands.index', compact('commands'));
        }else{
            //if the user is a regular user, show only the commands assigned to them
            $commands = Command::where('user_id', Auth::id())->latest()->paginate(10);
            return view('commands.index', compact('commands'));
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //sending the products to the view
        $products = Product::all();
        $clients = Client::all();
        return view('commands.create', compact('products', 'clients'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'client' => 'required|string',
            'products' => 'required|array',
            'products.*.name' => 'required|string',
            'products.*.quantity' => 'required|integer|min:1',
        ]);

        $totalPrice = 0;
        $productsArray = [];
        $products = $request->input('products');
        foreach ($products as $productData) {
            $quantity = $productData['quantity'];

            //getting the product 
            $productName = $productData['name'];
            $product = Product::where('name', $productName)->first();

            //checking if the product is available in stock
            if ($product->current_stock < $quantity) {
                return response()->json(['error' => "La quantité de " . $productName . " n'est pas disponible en stock"]);
            }
            $totalPrice += $quantity * $product->price;

            // Reduce the stock of the product
            $product->current_stock -= $quantity;

            //adding to the sold products
            $product->sold += $quantity;
            $product->save();

            // Add the product to the products array for the command
            $productsArray[] = [
                'id' => $product->id,
                'quantity' => $quantity,
            ];
        }
        $command = new Command();

        $client = Client::find($request->client);
        $command->client()->associate($client);
        $command->user_id = Auth::id();
        $command->total_price = $totalPrice;
        $command->type = 'pending';
        $command->products = $productsArray;
        $command->save();

        Session::flash('success', 'Commande ajoutée avec succès');
        return response()->json(['success' => true]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // getting the command
        $command = Command::find($id);

        //getting the products
        $productsData = $command->products;
        // Get the product IDs from the productsData array
        $productIds = array_column($productsData, 'id');

        // Fetch the products from the database based on the product IDs
        $products = Product::whereIn('id', $productIds)->get();
        $productsWithQuantities = [];
        foreach ($productsData as $productData) {
            $productId = $productData['id'];
            $quantity = $productData['quantity'];
            $product = $products->where('id', $productId)->first();
            if ($product) {
                $productsWithQuantities[] = [
                    'product' => $product,
                    'quantity' => $quantity
                ];
            }
        }
        return view('commands.show', compact('command', 'productsWithQuantities'));
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

    /**
     * Confirm the command
     */
    public function confirm(Request $request, Command $command){
        $command->update(['type' => 'done']);
        Session::flash('success', 'Commande confirmée avec succès');
        return redirect()->back();
    }

    /**
     * Cancel the command
     */
    public function cancel(Request $request, Command $command){
        $command->update(['type' => 'cancelled']);
        Session::flash('success', 'Commande annulée avec succès');
        return redirect()->back();
    }
}
