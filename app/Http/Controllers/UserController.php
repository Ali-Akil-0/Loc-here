<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Client;
use App\Models\Partenaire;
use app\Models\Annonce;
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
            $AnnoncesPremium =  new User();
            return $AnnoncesPremium;
            return redirect('acceuil', ["AnnoncesPremium", $AnnoncesPremium]);
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
    public function plusDeProduits(Request $request)
    {
        $request->validate([
            "id" => 'required',
            "type" => 'required',
        ]);
        // echo "here";
        // echo $request->id;
        // echo $request->type;

        if ($request->type == "client") {
            // echo "client";
            $user2 = Client::where('id', '=', $request->id)->first();
            if ($user2) {
                return view('view_Annonces', ['user' => $user2, 'type' => "client"]);
            } else {
                echo "problemClient";
            }
        } elseif ($request->type == "partenaire") {
            // echo "partenaire";

            $user2 = Partenaire::where('id', '=', $request->id)->first();

            return view('view_Annonces', ['user' => $user2, 'type' => "partenaire"]);
        } else {
            echo "problem";
            return view('view_Annonces');
        }
    }
    public function annonce(Request $request)
    {
        $request->validate([
            "id" => 'required',
            "type" => 'required',
            "idAnnonce" => 'required',
        ]);
        // echo "here";
        // echo $request->idAnnonce;
        // echo $request->type;


        if ($request->type == "client") {
            // echo "client";
            $user2 = Client::where('id', '=', $request->id)->first();
            if ($user2) {
                return view('view_Annonce', ['user' => $user2, 'type' => "client", "Annonce" => $request->idAnnonce]);
            } else {
                echo "problemClient";
            }
        } elseif ($request->type == "partenaire") {
            // echo "partenaire";

            $user2 = Partenaire::where('id', '=', $request->id)->first();

            return view('view_Annonce', ['user' => $user2, 'type' => "partenaire", "Annonce" => $request->idAnnonce]);
        } else {
            echo "problem";
            return view('view_Annonce');
        }
    }
}