<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\Product;
use App\Models\Supplier;
use App\Models\User;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $this->call([
            IdentitySeeder::class, 
            CategorySeeder::class,
            WarehouseSeeder::class,
            SupplierSeeder::class,
            ReasonSeeder::class,
            RoleSeeder::class,
        ]);
        
        User::factory()->create([
            'name' => 'admin',
            'email' => 'admin@rickstore.com',
            'password'=>bcrypt('12345678'),
        ])->assignRole('admin');

        //al crear el producto quiero q le pase la fabrica q hemos creado 
        //para q funcione debemos indicarle a nuestro modelo que son las fabricas

        Customer::factory(50)->create();
        // Supplier::factory(3)->create();
        
        //Product::factory(100)->create(); 
    
    }
}
