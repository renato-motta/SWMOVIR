<?php

namespace Database\Seeders;

use App\Models\Warehouse;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class WarehouseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Warehouse::create([
            'name'=>'Almacen Principal',
            'location'=>'Jr. Las Torres 345, Lima',
        ]);

        Warehouse::create([
            'name'=>'Almacén de Repuestos',
            'location'=>'Av. El Sol 110, Lima',
        ]);

        Warehouse::create([
            'name'=>'Almacén de Devoluciones',
            'location'=>'Jr. Los Ficus 500, Lince',
        ]);

        Warehouse::create([
            'name'=>'Taller de Mantenimiento',
            'location'=>'Jr. Los Claveles 234, Lima',
        ]);
    }
}

