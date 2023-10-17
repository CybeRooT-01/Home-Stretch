<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use App\Models\Absence;
use App\Models\Attache;
use App\Models\Classe;
use App\Models\Cours;
use App\Models\DemandeAnnulation;
use App\Models\Etudiant;
use App\Models\Module;
use App\Models\Professeur;
use App\Models\ResponsablePedagogique;
use App\Models\Salle;
use App\Models\SessionCours;
use App\Policies\AbsencePolicy;
use App\Policies\AttachePolicy;
use App\Policies\ClassePolicy;
use App\Policies\CoursPolicy;
use App\Policies\DemandeAnnulationPolicy;
use App\Policies\EtudiantPolicy;
use App\Policies\ModulePolicy;
use App\Policies\ProfPolicy;
use App\Policies\RPpolicy;
use App\Policies\SallePolicy;
use App\Policies\SessionCoursPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Salle::class => SallePolicy::class,
        Classe::class=> ClassePolicy::class,
        Cours::class=>CoursPolicy::class,
        Etudiant::class=>EtudiantPolicy::class,
        SessionCours::class=>SessionCoursPolicy::class,
        ResponsablePedagogique::class=>RPpolicy::class,
        Professeur::class=>ProfPolicy::class,
        Module::class=>ModulePolicy::class,
        Attache::class=>AttachePolicy::class,
        DemandeAnnulation::class=>DemandeAnnulationPolicy::class,
        Absence::class=>AbsencePolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        //
    }
}
