<?php

namespace App\Http\Controllers;

use App\Models\Log;
use App\Models\Sale;
use App\Models\Client;
use App\Models\Command;
use App\Models\Product;
use App\Models\ProductNotif;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Session;


class CommandController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $commands = Command::getAccessibleCommands()->filter(request(['type','client']))->paginate(10);

        $filter = [request(['type'][0]), request(['client'][0])];
        // dd($filter);
        return view('commands.index', compact('commands', 'filter'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //sending the products to the view
        $products = Product::all();
        //get the clients that the user can access
        $clients = Client::getAccessibleClients()->get();
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
            'products.*.id' => 'required|string',
            'products.*.quantity' => 'required|integer|min:1',
            'payment_method' => 'required|string',
        ]);

        $client = Client::find($request->client);
        if (!$client) {
            return response()->json(['error' => 'Client not found.'], 404);
        }
        $command = Command::create([
            'client_id' => $client->id,
            'user_id' => Auth::id(),
            'total_price' => 0, // Initial value, will be updated later
            'type' => 'pending',
            'payment_method' => $request->payment_method,
        ]);
        $totalPrice = 0;
        // $productsArray = [];
        $products = $request->input('products');

        foreach ($products as $product) {
            $productModel = Product::find($product['id']);
            $priceAtSale = $productModel->price;
            $quantity = $product['quantity'];
            //checking if the product is available in stock
            if ($productModel->current_stock < $quantity) {
                return response()->json(['error' => "La quantité de " . $productModel->name . " n'est pas disponible en stock"]);
            }
            // Reduce the stock of the product
            $productModel->subtractStock($quantity);
            //adding to the sold products
            $productModel->on_hold += $quantity;

            $productModel->save();
            $command->products()->attach($product['id'], [
                'quantity' => $quantity,
                'price_at_sale' => $priceAtSale,
            ]);
            $totalPrice += $quantity * $priceAtSale;
        }

        $command->update(['total_price' => $totalPrice]);

        //create log
        Log::CreateLog("Creer commande.", "Client concerné: " . $client->first_name . ' ' . $client->last_name . ", commande n°: " . $command->id);

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
        // Store the previous URL in the session
        session()->put('previous_url', url()->previous());

        // getting the products with quantities
        $productsWithQuantities = $command->productsAndQuantities;

        if ($command->type === 'done') {
            $sale = Sale::where('command_id', $command->id)->first();
            return view('commands.show', compact('command', 'productsWithQuantities', 'sale'));
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
     * delete the command 
     */
    public function destroy(string $id)
    {
        $command = Command::with('products')->find($id);

        if (!$command) {
            Session::flash('error', "Commande non trouvée.");
            return redirect()->intended(session()->pull('previous_url', '/'));
        }

        // Add the products to the stock
        $products = $command->products;
        foreach ($products as $product) {
            $quantity = $product->pivot->quantity;
            $product->addStock($quantity);
            $product->on_hold -= $quantity;
            $product->save();
        }

        $command->delete();

        // Create log
        Log::CreateLog("Supprimer commande.", "Commande n°: " . $command->id);

        Session::flash('success', "Commande supprimée avec succès.");
        return redirect()->intended(session()->pull('previous_url', '/'));
    }

    /**
     * Confirm the command
     */
    public function confirm(Request $request, Command $command)
    {
        $command->update(['type' => 'done']);
        $command->products->each(function ($product) {
            $product->on_hold -= $product->pivot->quantity;
            $product->sold += $product->pivot->quantity;
            $product->save();
        });
        $sale = new Sale();
        $sale->command()->associate($command);
        $sale->user_id = Auth::id();
        $sale->save();

        // Create log
        Log::CreateLog("Confirmer commande.", "Commande n°: " . $command->id);
        Session::flash('success', 'Commande confirmée avec succès');
        return redirect()->back();
    }

    /**
     * Cancel the command
     */
    public function cancel(Request $request, Command $command)
    {
        // Add the products to stock
        $products = $command->products;
        foreach ($products as $product) {
            $quantity = $product->pivot->quantity;
            $product->addStock($quantity);
            $product->on_hold -= $quantity;
            $product->sold -= $quantity;
            $product->save();
        }

        // Update the command
        $command->update(['type' => 'cancelled']);

        // Create log
        Log::CreateLog("Annuler commande.", "Commande n°: " . $command->id);
        Session::flash('success', 'Commande annulée avec succès');
        return redirect()->back();
    }

    //view invoice
    public function viewInvoice(Request $request, Sale $sale)
    {
        $pdf = App::make('dompdf.wrapper');
        $html = View::make('invoice.generate-invoice', ['sale' => $sale])->render();
        $pdf->loadHTML($html);
        return $pdf->stream();
    }

    //download invoice
    public function downloadInvoice(Request $request, Sale $sale)
    {
        $data = ['sale' => $sale];
        $pdf = Pdf::loadView('invoice.generate-invoice', $data);
        return $pdf->download('facture N° ' . $sale->id . '-' . $sale->created_at->format('Y') . '.pdf');
    }
}
