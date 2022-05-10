<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Session;

class UserController extends Controller
{
    public function Login()
    {
        return view('auth.view_SeConnecter');
    }
    public function Inscrire()
    {
        return view('auth.view_Inscrire');
    }
    public function ajouterUser(Request $request)
    {
        $request->validate([
            "nom" => 'required',
            "prenom" => 'required',
            "username" => 'required',
            // unique in a certain table
            "email" => 'required|email|unique:users',
            "password" => 'required',

        ]);
        $user = new User();
        $user->Nom = $request->nom;
        $user->Prenom = $request->prenom;
        $user->Username = $request->username;
        $user->Email = $request->email;
        $user->Password = Hash::make($request->password);
        $res  = $user->save();
        if ($res) {
            return back()->with("success", " Vous etes inscris");
        } else {
            return back()->with("fail", "Something wentv wrong");
        }


        echo "value poster ";
    }
    public function loginUser(Request $request)
    {
        $request->validate([
            "email" => 'required|email|unique:users',
            "password" => 'required',

        ]);
        $user = User::where('email', '=', $request->email)->first();
        if ($user) {
            if (Hash::check($request->password, $user->password)) {
                echo "is this working ????";
                // return redirect('view_Acceuil');
            } else {
                return back()->with("fail", "Something wentv wrong");
            }
        } else {
            return back()->with("fail", "Something wentv wrong");
        }
    }
}