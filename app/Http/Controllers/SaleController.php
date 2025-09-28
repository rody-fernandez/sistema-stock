<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\SaleItem;
use App\Models\Product;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SaleController extends Controller
{
    public function index()
    {
        $sales = Sale::with('customer')->latest()->paginate(10);
        return view('sales.index', compact('sales'));
    }

    public function create()
    {
        $customers = Customer::all();
        $products  = Product::all();
        return view('sales.create', compact('customers','products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'products'    => 'required|array',
            'products.*.id' => 'required|exists:products,id',
            'products.*.quantity' => 'required|integer|min:1'
        ]);

        DB::transaction(function () use ($request) {
            $sale = Sale::create([
                'customer_id' => $request->customer_id,
                'total' => 0
            ]);

            $total = 0;
            foreach ($request->products as $item) {
                $product = Product::find($item['id']);
                $qty = $item['quantity'];
                $price = $product->price;

                // reducir stock
                if ($product->stock < $qty) {
                    throw new \Exception("Stock insuficiente para {$product->name}");
                }
                $product->decrement('stock', $qty);

                // crear item
                SaleItem::create([
                    'sale_id'   => $sale->id,
                    'product_id'=> $product->id,
                    'quantity'  => $qty,
                    'price'     => $price,
                ]);

                $total += $price * $qty;
            }

            $sale->update(['total' => $total]);
        });

        return redirect()->route('sales.index')->with('success','Venta registrada con éxito');
    }

    public function show(Sale $sale)
    {
        $sale->load('customer','items.product');
        return view('sales.show', compact('sale'));
    }
}
