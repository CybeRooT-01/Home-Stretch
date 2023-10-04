<?php

namespace Database\Seeders;

use App\Models\Semestre;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SemestreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $semestres = [
            [
                'libelle' => 'S1',
                'annee_id' => 1,
            ],
            [
                'libelle' => 'S2',
                'annee_id' => 1,
            ],
            [
                'libelle' => 'S3',
                'annee_id' => 1,
            ],
        ];
        Semestre::insert($semestres);
    }
}
