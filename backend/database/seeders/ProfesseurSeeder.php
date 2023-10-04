<?php

namespace Database\Seeders;

use App\Models\Professeur;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProfesseurSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $professeurs = [
            [
                'nomComplet' => 'Moussa Sow',
                "specialite" => "Informatique",
                "grade" => "L1",
                ],
            [
                'nomComplet'=>'Demba Diop',
                "specialite" => "Marketing",
                "grade" => "L2",
                ],
            [
                'nomComplet'=>'Moussa Diop',
                "specialite" => "Comptabilité",
                "grade" => "L3",
                ],
        ];
        Professeur::insert($professeurs);
    }
}
