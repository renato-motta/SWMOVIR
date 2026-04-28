<?php

namespace Database\Seeders;

use App\Models\Identity;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class IdentitySeeder extends Seeder
{
    public function run(): void
    {
        $identities=[
            'Sin documento',
            'DNI',
            'Carnet de extranjeria',
            'RUC',
        ];

        foreach($identities as $identity){
            Identity::create([
                'name'=>$identity,
            ]);
        }
    }
}
