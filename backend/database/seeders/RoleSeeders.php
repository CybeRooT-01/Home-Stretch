<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeders extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            [
                'libelle' => 'RP',
                'description' => 'Responsable Pédagogique'
            ],
            [
                'libelle' => 'Professeur',
                'description' => 'Enseignant dans ODC'
            ],
            [
                'libelle' => 'Etudiant',
                'description' => 'Apprenant dans ODC'
            ],
            [
                'libelle' => 'Attache',
                'description' => 'surveillant dans ODC'
            ],
        ];
        Role::insert($roles);
    }
}
