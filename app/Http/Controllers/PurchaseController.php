<?php

namespace App\Http\Controllers;

use App\Models\Purchase;
use App\Models\PurchaseDetail;
use App\Models\Product;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PurchaseController extends Controller
{
    public function index()
    {
        $purchases = Purchase::with('supplier','user')->latest()->paginate(10);
        return view('purchases.index', compact('purchases'));
    }

    public function create()
    {
        $suppliers = Supplier::all();
        $products  = Product::all();
        return view('purchases.create', compact('suppliers','products'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'supplier_id'       => 'required|exists:suppliers,id',
            'products'          => 'required|array|min:1',
            'products.*.id'     => 'required|exists:products,id|distinct',
            'products.*.qty'    => 'required|integer|min:1',
            'products.*.price'  => 'required|numeric|min:0',
        ]);

        DB::transaction(function() use ($data) {
            $purchase = Purchase::create([
                'supplier_id' => $data['supplier_id'],
                'user_id'     => auth()->id(),
                'date'        => now(),
                'total'       => 0,
            ]);

            $total = 0;

            foreach ($data['products'] as $item) {
                $product  = Product::query()->findOrFail($item['id']);
                $quantity = (int) $item['qty'];
                $unitPrice = (float) $item['price'];
                $subtotal = $quantity * $unitPrice;
                $total   += $subtotal;

                PurchaseDetail::create([
                    'purchase_id' => $purchase->id,
                    'product_id'  => $product->id,
                    'quantity'    => $quantity,
                    'unit_price'  => $unitPrice,
                    'subtotal'    => $subtotal,
                ]);

                // actualizar stock
                $product->increment('stock', $quantity);
            }

            $purchase->update(['total' => $total]);
        });

        return redirect()->route('purchases.index')->with('success', 'Compra registrada correctamente');
    }

    public function show(Purchase $purchase)
    {
        $purchase->load('supplier','details.product');
        return view('purchases.show', compact('purchase'));
    }
}
