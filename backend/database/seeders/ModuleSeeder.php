<?php

namespace Database\Seeders;

use App\Models\Module;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ModuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $modules = [
            [
                'libelle' => 'Module 1',
            ],
            [
                'libelle' => 'Module 2',
            ],
            [
                'libelle' => 'Module 3',
            ]
        ];
        Module::insert($modules);
    }
}
