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
        $user->adresse = $request->addresse;
        $user->tel = $request->tel;
        $user->id_status = 1;
        $user->save();
        DB::insert('insert into role_user values (?,?)',[$user->id,$request->role]);
        if ($request->role==1) {
            DB::insert('insert into freelancers(user_id) values(?)',[$user->id]);
        }else if ($request->role==2) {
            DB::insert('insert into clients(user_id) values(?)',[$user->id]);
        }
        return response()->json([
            'email'=>$user->email,
            'password'=>$request->password
        ]);
    }
}
