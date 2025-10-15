<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\Product;
use App\Models\Supplier;
use Illuminate\Database\Seeder;

class BasicDataSeeder extends Seeder
{
    public function run(): void
    {
        $suppliers = [
            ['name' => 'Proveedor Central', 'email' => 'contacto@central.com', 'phone' => '021-111-111', 'address' => 'Asunción'],
            ['name' => 'Mayorista Sur', 'email' => 'ventas@sur.com', 'phone' => '0981-222-222', 'address' => 'Encarnación'],
        ];

        foreach ($suppliers as $supplier) {
            Supplier::updateOrCreate(
                ['email' => $supplier['email']],
                $supplier
            );
        }

        $customers = [
            ['name' => 'Juan Pérez', 'email' => 'juan@example.com', 'phone' => '0981-123-456', 'address' => 'Asunción'],
            ['name' => 'María López', 'email' => 'maria@example.com', 'phone' => '0982-654-321', 'address' => 'Luque'],
        ];

        foreach ($customers as $customer) {
            Customer::updateOrCreate(
                ['email' => $customer['email']],
                $customer
            );
        }

        $products = [
            ['name' => 'Teclado Mecánico', 'price' => 350000, 'stock' => 10],
            ['name' => 'Mouse Inalámbrico', 'price' => 150000, 'stock' => 25],
            ['name' => 'Monitor 24"', 'price' => 1200000, 'stock' => 8],
        ];

        foreach ($products as $product) {
            Product::updateOrCreate(
                ['name' => $product['name']],
                $product
            );
        }
    }
}
