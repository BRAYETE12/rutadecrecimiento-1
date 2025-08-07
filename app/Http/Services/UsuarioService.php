<?php

namespace App\Http\Services;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UsuarioService
{

    public static function crearUsuario($request): User
    {
        if(Auth::check())
            return Auth::user();
        
        $user = new User();
        $user->identification = $request->user_identification;
        $user->name = $request->user_name;
        $user->lastname = $request->user_lastname;
        $user->email = $request->user_email;
        $user->como_se_entero = $request->como_se_entero;
        $user->password = bcrypt($request->user_password);
        $user->save();

        return $user;
    }
}