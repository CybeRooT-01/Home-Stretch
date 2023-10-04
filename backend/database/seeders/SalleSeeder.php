<?php

namespace Database\Seeders;

use App\Models\Salle;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SalleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $Salles = [
            [
                "nom" => "Salle 1",
                "capacite" => 10,
                "numero" => "1"
            ],
            [
                "nom" => "Salle 2",
                "capacite" => 5,
                "numero" => "2"
            ],
            [
                "nom" => "Salle 3",
                "capacite" => 15,
                "numero" => "3"
            ],
        ];
        Salle::insert($Salles);
    }
}
