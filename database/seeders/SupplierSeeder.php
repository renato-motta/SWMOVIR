<?php

namespace Database\Seeders;

use App\Models\Supplier;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SupplierSeeder extends Seeder
{
    public function run(): void{
        $suppliers = [
            [
                'identity_id' => '2', 
                'document_number' => '12345678',
                'name' => 'Proveedor',
                'email' => 'proveedor@gmail.com',
                'phone' => '999999999',

            ],
        ];

        foreach ($suppliers as $supplier) {
            Supplier::create($supplier);
        }
    }
}