<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserRessource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all();
        return UserRessource::collection($users);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = null;
        DB::transaction(function () use ($request, &$user) {
            $user = User::create([
                'nom' => $request->nom,
                'password' => $request->password,
                'login' => $request->login,
                'role_id' => $request->role_id,
                'email' => $request->email,
            ]);
        });
        return new UserRessource($user);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return new UserRessource($user);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        //
    }

//    public function getCurrentUser(Request $request)
//    {
//        return new UserRessource($request->user());
//    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        DB::transaction(function () use ($request, &$user) {
            $user->update([
                'nom' => $request->nom,
                'password' => $request->password,
                'login' => $request->login,
            ]);
        });
        return new UserRessource($user);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();
    }
    public function allusers()
    {
        $users = User::all();
        return $users;
    }
}
