<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\SaleItem;
use App\Models\Product;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

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
        $data = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'products'    => 'required|array|min:1',
            'products.*.id' => 'required|exists:products,id|distinct',
            'products.*.quantity' => 'required|integer|min:1',
        ]);

        $items = collect($data['products'])
            ->map(function (array $item, int $index) {
                $product = Product::query()->find($item['id']);

                if (!$product) {
                    throw ValidationException::withMessages([
                        "products.$index.id" => "El producto seleccionado ya no está disponible.",
                    ]);
                }

                $quantity = (int) $item['quantity'];

                if ($product->stock < $quantity) {
                    throw ValidationException::withMessages([
                        "products.$index.quantity" => "Stock insuficiente para {$product->name}. Disponible: {$product->stock}",
                    ]);
                }

                return [
                    'product' => $product,
                    'quantity' => $quantity,
                    'price' => (float) $product->price,
                ];
            });

        DB::transaction(function () use ($data, $items) {
            $sale = Sale::create([
                'customer_id' => $data['customer_id'],
                'total' => 0,
            ]);

            $total = 0;

            foreach ($items as $item) {
                $product = $item['product'];
                $quantity = $item['quantity'];
                $price = $item['price'];

                $product->decrement('stock', $quantity);

                SaleItem::create([
                    'sale_id'   => $sale->id,
                    'product_id'=> $product->id,
                    'quantity'  => $quantity,
                    'price'     => $price,
                ]);

                $total += $price * $quantity;
            }

            $sale->update(['total' => $total]);
        });

        return redirect()
            ->route('sales.index')
            ->with('success','Venta registrada con éxito');
    }

    public function show(Sale $sale)
    {
        $sale->load('customer','items.product');
        return view('sales.show', compact('sale'));
    }
}
