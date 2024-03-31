<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\Client;
use App\Models\Command;
use App\Models\Product;
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
        //if the user is an admin or superuser, show all commands
        if (auth()->user()->privilege === 'admin' || auth()->user()->privilege === 'superuser') {

            $commands = Command::latest()->paginate(10);
            return view('commands.index', compact('commands'));
        } else {
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

        $command = Command::find($id);
        $command->delete();
        Session::flash('success', "Commande supprimée avec succès.");
        return redirect()->intended(session()->pull('previous_url', '/'));
    }

    /**
     * Confirm the command
     */
    public function confirm(Request $request, Command $command)
    {
        $command->update(['type' => 'done']);
        $sale = new Sale();
        $sale->command()->associate($command);
        $sale->user_id = Auth::id();
        $sale->save();
        Session::flash('success', 'Commande confirmée avec succès');
        return redirect()->back();
    }

    /**
     * Cancel the command
     */
    public function cancel(Request $request, Command $command)
    {
        $command->update(['type' => 'cancelled']);
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
