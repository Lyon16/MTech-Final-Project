<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Customer;
use App\Models\Sale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class SalesController extends Controller
{
    // Display the Record Sale form
    public function create()
    {
        $products = Product::where('stock_quantity', '>', 0)
            ->orderBy('name')
            ->get();

        $customers = Customer::orderBy('full_name')->get();

        return view('sales.create', compact('products', 'customers'));
    }

    // Process and record a sale
    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id' => [
                'required',
                'integer',
                'exists:products,id',
            ],
            'customer_id' => [
                'nullable',
                'integer',
                'exists:customers,id',
            ],
            'quantity' => [
                'required',
                'integer',
                'min:1',
            ],
        ]);

        DB::transaction(function () use ($validated) {

            // Lock product row to prevent simultaneous overselling
            $product = Product::whereKey($validated['product_id'])
                ->lockForUpdate()
                ->firstOrFail();

            $quantity = $validated['quantity'];

            // Reject if requested quantity exceeds available stock
            if ($quantity > $product->stock_quantity) {
                throw ValidationException::withMessages([
                    'quantity' => 'Insufficient stock. Only ' .
                        $product->stock_quantity .
                        ' unit(s) available.',
                ]);
            }

            // Calculate total on the server
            $totalPrice = round(
                (float) $product->price * $quantity,
                2
            );

            // Save transaction
            Sale::create([
                'product_id' => $product->id,
                'customer_id' => $validated['customer_id'] ?? null,
                'sold_by' => auth()->id(),
                'quantity' => $quantity,
                'total_price' => $totalPrice,
                'created_at' => now(),
            ]);

            // Deduct stock
            $product->decrement('stock_quantity', $quantity);

        }, 3);

        return redirect()->route('sales.index')
            ->with('success', 'Sale recorded successfully!');
    }

    // Display sales history
    public function index()
    {
        $sales = Sale::with(['product', 'customer', 'staff'])
            ->orderByDesc('created_at')
            ->paginate(10);

        return view('sales.index', compact('sales'));
    }
}
