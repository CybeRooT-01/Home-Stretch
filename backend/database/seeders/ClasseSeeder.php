<?php

namespace Database\Seeders;

use App\Models\Classe;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ClasseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $classes = [
            [
                "libelle" => "L1",
                "filiere" => "Informatique",
                "niveau" => "1",
            ],
            [
                "libelle" => "L2",
                "filiere" => "Marketing",
                "niveau" => "2",
            ],
            [
                "libelle" => "L3",
                "filiere" => "Comptabilité",
                "niveau" => "3",
            ],
        ];
        Classe::insert($classes);
    }
}
