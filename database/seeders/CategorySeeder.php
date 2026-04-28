<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories=[
            [
                'name'=> 'Relojes de Cuarzo',
                'description'=> 'Relojes que usan un cristal de cuarzo para medir el tiempo. Son precisos y de bajo mantenimiento.',
            ],

            [
                'name'=> 'Relojes Deportivos',
                'description'=> 'Diseñados para actividades físicas, con características como resistencia al agua, cronómetros y materiales duraderos.',
            ],

            [
                'name'=> 'Smartwatches',
                'description'=> 'Relojes inteligentes que se conectan a un smartphone, ofreciendo funciones como monitoreo de salud, GPS y notificaciones.',
            ],

            [
                'name'=> 'Relojes de Bolsillo',
                'description'=> 'Relojes clásicos y vintage que se llevan con una cadena. Suelen tener un diseño tradicional y un mecanismo manual.',
            ],
        ];
        
        foreach($categories as $category){
            Category::create($category);
        }
    }
}
