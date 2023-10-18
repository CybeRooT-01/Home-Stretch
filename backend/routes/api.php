<?php

use App\Http\Controllers\AbsenceController;
use App\Http\Controllers\AttacheController;
use App\Http\Controllers\ClasseController;
use App\Http\Controllers\CoursController;
use App\Http\Controllers\DemandeAnnulationController;
use App\Http\Controllers\InscriptionController;
use App\Http\Controllers\ModuleController;
use App\Http\Controllers\ProfesseurController;
use App\Http\Controllers\ResponsablePedagogiqueController;
use App\Http\Controllers\SalleController;
use App\Http\Controllers\SessionCoursController;
use Illuminate\Http\Request;
use App\Http\Resources\UserRessource;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\EtudiantController;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('/register',[UserController::class, 'store']);
Route::post('login', [AuthController::class, 'login']);


Route::middleware('auth:api')->group(function () {
  Route::get('user', function (Request $request) {
    return new UserRessource($request->user());
  });
    Route::get('/salles',[SalleController::class, 'index']);
    Route::post('/salles',[SalleController::class, 'store']);
    Route::get('/classes', [ClasseController::class, 'index']);
    Route::post('/classes', [ClasseController::class, 'store']);
    Route::get('inscription', [InscriptionController::class, 'index']);
    Route::get('/cours',[CoursController::class, 'index']);
    Route::post('/cours', [CoursController::class, 'store']);
    Route::post('/etudiants',[EtudiantController::class, 'inscription']);
    Route::get('/sessioncours',[SessionCoursController::class, 'index']);
    Route::post('/sessioncours',[SessionCoursController::class, 'store']);
    Route::put('/sessioncours/{id}', [SessionCoursController::class, 'update']);
    Route::get('/ResponsablePedagogiques', [ResponsablePedagogiqueController::class, 'index']);
    Route::post('/ResponsablePedagogiques', [ResponsablePedagogiqueController::class, 'store']);
    Route::get('/profs', [ProfesseurController::class, 'index']);
    Route::post('/profs', [ProfesseurController::class, 'store']);
    Route::get('/modules', [ModuleController::class, 'index']);
    Route::post('/modules', [ModuleController::class, 'store']);
    Route::get('/attaches', [AttacheController::class, 'index']);
    Route::post('/attaches', [AttacheController::class, 'store']);
    Route::post("/demandeAnnulation", [DemandeAnnulationController::class, 'store']);
    Route::get("/demandeAnnulation", [DemandeAnnulationController::class, 'index']);
    Route::delete("/demandeAnnulation/{id}", [DemandeAnnulationController::class, 'destroy'])->name("rejeterDemandeAnnulation");
    Route::put("/demandeAnnulation", [DemandeAnnulationController::class, 'update'])->name("accepterDemandeAnnulation");
    Route::post('/absence', [AbsenceController::class, 'store']);
    Route::get('/absence', [AbsenceController::class, 'index']);
    Route::match(['put', 'patch'], '/absence/{id}', [AbsenceController::class, 'update']);

//    Route::get('/user',[UserController::class, 'getCurrentUser']);

  Route::get('users', [UserController::class, 'allUsers']);
  Route::post('logout', function (Request $request) {
//      return $request->user();
    $request->user()->token()->revoke();
    return response()->json(['message' => 'Logged out'], 200);
  });
});
