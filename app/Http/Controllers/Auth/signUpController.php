<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\DB;


class signUpController extends Controller
{
    public function __invoke(Request $request)
    {
        //needs validation
        $user = new User;
        $user->nom = $request->nom;
        $user->prenom = $request->prenom;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->pays = $request->pays;
        $user->tel = $request->tel;
        $user->save();
        DB::insert('insert into role_user values (?,?)',[$user->id,$request->role]);
        if ($request->role==1) {
            $user->username = $request->username;
            $user->save();
        }
        return response()->json([
            'email'=>$user->email,
            'password'=>$request->password
        ]);
    }
}
