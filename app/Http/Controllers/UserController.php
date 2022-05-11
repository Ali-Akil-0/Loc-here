<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Client;
use App\Models\Partenaire;

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
        $res = null;
        $request->validate([
            "nom" => 'required',
            "prenom" => 'required',
            "username" => 'required',
            "email" => 'required|email',
            "password" => 'required',
        ]);
        echo $request->type;
        echo $request->type;
        echo $request->type;
        echo $request->type;
        echo $request->type;

        if ($request->type == "Client") {
            $client = new Client();
            $client->NomClint = $request->nom;
            $client->PrenomClient = $request->prenom;
            $client->UsernameClient = $request->username;
            $client->EmailClient = $request->email;
            $client->PasswordClient = Hash::make($request->password);
            $res  = $client->save();
        } else if ($request->type == "Partenaire") {
            $partenaire = new Partenaire();
            $partenaire->NomPartenaire = $request->nom;
            $partenaire->PrenomPartenaire = $request->prenom;
            $partenaire->UsernamePartenaire = $request->username;
            $partenaire->EmailPartenaire = $request->email;
            $partenaire->PasswordPartenaire = Hash::make($request->password);
            $res  = $partenaire->save();
        }
        if ($res) {
            return redirect('acceuil');
        } else {
            return back()->with("fail", "$request->type, idk what's the problem");
        }


        echo "value poster ";
    }
    public function loginUser(Request $request)
    {
        $request->validate([
            "email" => 'required',
            "password" => 'required',
        ]);
        $user = Client::where('EmailClient', '=', $request->email)->first();
        if ($user) {
            if (Hash::check($request->password, $user->PasswordClient)) {
                return view('view_Acceuil', ['client' => $user]);
            } else {

                return back()->with("fail", "client,$request->password,$user->PasswordClient");
            }
        } else {
            $user2 = Partenaire::where('EmailPartenaire', '=', $request->email)->first();
            if ($user2) {
                if (Hash::check($request->password, $user2->PasswordPartenaire)) {
                    return view('view_Acceuil', ['partenaire' => $user2]);
                } else {
                    return back()->with("fail", "partenaire $request->password,$user2->PasswordPartenaire");
                }
            } else {
                return back()->with("fail", "Incorrect Email or password");
            }
        }
    }
    public function plusDeProduits($id, $type)
    {
        if ($type == "client") {
            $user2 = Client::where('id', '=', $id)->first();
            if ($user2) {
                return view('view_Acceuil', ['user' => $user2, 'type' => $type]);
            }
        } elseif ($type == "partenaire") {
            $user2 = Partenaire::where('id', '=', $id)->first();

            return view('view_Acceuil', ['user' => $user2, 'type' => $type]);
        } else {
            return view('view_Annonces');
        }
    }
}