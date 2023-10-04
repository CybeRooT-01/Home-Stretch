<?php

namespace Database\Seeders;

use App\Models\Cours;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CoursSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cours = [
            ["quota_horaire_globale" => 10,
                "module_id" => 1,
                "professeur_id" => 1
            ],
            ["quota_horaire_globale" => 5,
                "module_id" => 2,
                "professeur_id" => 2
            ],
            ["quota_horaire_globale" => 15,
                "module_id" => 3,
                "professeur_id" => 3
            ],
        ];
        Cours::insert($cours);
    }
}
