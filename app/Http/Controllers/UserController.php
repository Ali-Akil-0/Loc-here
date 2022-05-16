<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Client;
use App\Models\Partenaire;
use app\Models\Annonce;
use Exception;
use Hamcrest\Core\HasToString;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\InfoClient;



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
        $user = null;
        $user2 = null;

        if ($request->type == "Client") {
            $client = new Client();
            $client->NomClint = $request->nom;
            $client->PrenomClient = $request->prenom;
            $client->UsernameClient = $request->username;
            $client->EmailClient = $request->email;
            $client->PasswordClient = Hash::make($request->password);
            $res  = $client->save();
            $user = Client::where('EmailClient', '=', $request->email)->first();
        } else if ($request->type == "Partenaire") {
            $partenaire = new Partenaire();
            $partenaire->NomPartenaire = $request->nom;
            $partenaire->PrenomPartenaire = $request->prenom;
            $partenaire->UsernamePartenaire = $request->username;
            $partenaire->EmailPartenaire = $request->email;
            $partenaire->PasswordPartenaire = Hash::make($request->password);
            $res  = $partenaire->save();
            $user2 = Partenaire::where('EmailPartenaire', '=', $request->email)->first();
        }
        if ($res) {
            // $AnnoncesPremium =  new User();
            // echo $AnnoncesPremium->IdAnnonce;
            // echo $AnnoncesPremium;
            $AnnoncesPremium =  new User();
            $annonces =  $AnnoncesPremium->getAnnoncesPremium();
            $villes =  $AnnoncesPremium->getVille();
            $categories =  $AnnoncesPremium->getCategorie();
            $ville = json_decode(json_encode($villes), true);
            $categorie = json_decode(json_encode($categories), true);
            $annonce = (array)$annonces;

            if ($request->type == "Client") {
                return view('view_Acceuil', ['client' => $user, 'annonces' => $annonces, 'villes' => $ville, 'categories' => $categorie]);
            } else {
                return view('view_Acceuil', ['partenaire' => $user2, 'annonces' => $annonce, 'villes' => $ville, 'categories' => $categorie]);
            }

            // return view('view_Acceuil', ["AnnoncesPremium", $AnnoncesPremium]);
        } else {
            return back()->with("fail", "$request->type, there is a problem");
        }
    }

    public function dashboard()
    {
        $count = DB::table('reclamation')->count();
        $count2 = DB::table('annonce')->count();
        $count3 = DB::table('partenaires')->count();
        return view('dashboard', ['countrec' => $count], ['countann' => $count2], ['countpart' => $count3]);
    }


    public function loginUser(Request $request)
    {

        $request->validate([
            "email" => 'required',
            "password" => 'required',
        ]);
        $AnnoncesPremium =  new User();
        $annonces =  $AnnoncesPremium->getAnnoncesPremium();
        $villes =  $AnnoncesPremium->getVille();

        $ville = json_decode(json_encode($villes), true);
        $categories =  $AnnoncesPremium->getCategorie();




        // check annonce function
        // $PremiumChecking =  $AnnoncesPremium->checkIfPremium();


        // next
        $categorie = json_decode(json_encode($categories), true);
        // sering all premium data
        foreach ($annonces as $annonce) {
            $test = (array)$annonce;
            $the_date2  = $test["DateDebut"];
            $the_date = date_create($the_date2);
            $todaysDate = date_create(date("Y-m-d"));

            // $separatingTest = explode("-", $test["DateDebut"]);
            date_add($the_date, date_interval_create_from_date_string("15 days"));
            // echo date_format($the_date, "Y-m-d");
            // echo "before";
            // echo date("Y-m-d");
            // echo "after";
            if ($the_date > $todaysDate) {
                // deleting premium
                $results = DB::select('UPDATE annonce set Premium=:Premium where IdObjet =:IdObjet  ', ['Premium' => "non", 'IdObjet' => $test["IdObjet"]]);
                if ($results) {
                    // echo "update success";
                }
            }
            // var_dump($separatingTest[2]);
        }
        // checking all annonces to pass them to archive
        $AllData = $AnnoncesPremium->checkingAllAnnnonces();
        foreach ($AllData as $AllData1) {
            // var_dump($AllData1);
            $AllAnnonces = (array)$AllData1;
            // var_dump($AllAnnonces);
            $the_date2  = $AllAnnonces["DateFin"];
            $EndDate = date_create($the_date2);
            $todaysDate2 = date_create(date("Y-m-d"));
            // echo "before";
            // var_dump($EndDate);
            // var_dump($todaysDate2);
            // echo "after";
            // echo "hellooo ";
            // echo $AllAnnonces["IdAnnonce"];



            if ($EndDate > $todaysDate2) {
                // echo "yeah thats too far";
                $results = DB::select('UPDATE annonce set archivee=:archivee where IdAnnonce  =:IdAnnonce   ', ['archivee' => "oui", 'IdAnnonce' => $AllAnnonces["IdAnnonce"]]);
                // echo $test["IdAnnonce"];
            }
        }






        // checking all annonces to pass them to archive
        $user = Client::where('EmailClient', '=', $request->email)->first();
        $user2 = Partenaire::where('EmailPartenaire', '=', $request->email)->first();
        $results = DB::select('select *  from administrateur where EmailAdmin = :EmailAdmin ', ["EmailAdmin" => $request->email]);
        $result = null;
        if ($results) {
            $result = (array)$results[0];
        }
        // var_dump($result["EmailAdmin"]);


        if ($result) {
            if ($result["EmailAdmin"] == "admin@gmail.com") {
                $count = DB::table('reclamation')->count();
                $count2 = DB::table('annonce')->count();
                $count3 = DB::table('partenaires')->count();

                //    compact('count')

                return view('dashboard', ['countrec' => $count], ['countann' => $count2], ['countpart' => $count3]);
            }
        } else if ($user && !$user2) {
            if (Hash::check($request->password, $user->PasswordClient)) {
                // echo "<pre>";
                // var_dump($annonces);
                // echo "</pre>";
                // // var_dump($annonce);
                // foreach ($annonces as $anno) {
                //     $test = (array)$anno;
                //     // $test = json_decode(json_encode($anno), true);
                //     var_dump($test["CategorieObjet"]);
                // }
                //print_r(json_decode( $str_json)); //printing array after convert json string to array

                // traitement des notifications
                // 1 les reponses de l'admin
                $reponseAdminClient  = null;
                $idReclamationClient = null;
                $ClientNotif =  new User();
                $reclamations = $ClientNotif->reponseAdminClient($user->id);
                // Reclamation non lu

                // foreach ($reclamations as $reclamation) {
                //     // var_dump($reclamation);
                //     if ($reclamation["ReponseReclam"] && $reclamation["ReclamationLu"] == "non") {
                //         $reponseAdminClient = $reclamation["ReponseReclam"];
                //         $idReclamationClient = $reclamation["IdReclamation"];
                //     }
                //     if ($reclamation["VueReclamationAdmin"] && $reclamation["ReclamationLu"] == "non") {
                //         $reponseAdminClient = $reclamation["VueReclamationAdmin"];
                //         $idReclamationClient = $reclamation["IdReclamation"];
                //     }
                // }

                // Reclamation  lu (leave untill later) (top to non lu. After we find the lu)

                // foreach ($reclamations as $reclamation) {
                //     var_dump($reclamation);
                //     if ($reclamation["ReponseReclam"]) {
                //         $reponseAdminClient = $reclamation["ReponseReclam"];
                //         $idReclamationClient = $reclamation["IdReclamation"];
                //     }
                //     if ($reclamation["VueReclamationAdmin"]) {
                //         $reponseAdminClient = $reclamation["VueReclamationAdmin"];
                //         $idReclamationClient = $reclamation["IdReclamation"];
                //     }
                // }

                $GettingAll =  $AnnoncesPremium->getAllAnnonces();


                // 2 les notes
                $CheckNoteClient = $AnnoncesPremium->CheckNoteClient($user->id);

                $AcceptedLocations = $AnnoncesPremium->LocationAccepterNotifs($user->id);
                // foreach ($AcceptedLocations as $AcceptedLocation) {
                //     echo "les locations accepter";
                //     var_dump($AcceptedLocation);
                // }

                return view('view_Acceuil', ['client' => $user, 'CheckNoteClient' => $CheckNoteClient, 'annonces' => $annonces, 'AllData' => $GettingAll, 'villes' => $ville, 'categories' => $categorie, 'reclamations' => $reclamations, 'LocationsAccepter' => $AcceptedLocations]);
            } else {
                return back()->with("fail", "client,$request->password,$user->PasswordClient");
            }
        } else if ($user && $user2) {
            if (Hash::check($request->password, $user2->PasswordPartenaire)) {


                $ClientNotif =  new User();
                $reclamations = $ClientNotif->reponseAdminPartenaire($user2->id);
                // var_dump($reclamations);
                return view('view_Acceuil', ['partenaire' => $user2, 'annonces' => $annonces, 'villes' => $ville, 'categories' => $categorie, 'reclamations' => $reclamations]);
            }
        } else {
            if ($user2) {
                if (Hash::check($request->password, $user2->PasswordPartenaire)) {
                    $ClientNotif =  new User();
                    $reclamations = $ClientNotif->reponseAdminPartenaire($user2->id);
                    // var_dump($reclamations);

                    return view('view_Acceuil', ['partenaire' => $user2, 'annonces' => $annonces, 'villes' => $ville, 'categories' => $categorie, 'reclamations' => $reclamations]);
                }
            } else {
                $results = DB::select('select *  from administrateur where EmailAdmin = :EmailAdmin ', ["EmailAdmin" => $request->email]);
                //    return $results;

                if ($results) {
                    $result = (array)$results[0];
                    var_dump($result['EmailAdmin']);
                    $count = DB::table('reclamation')->count();
                    $count2 = DB::table('annonce')->count();
                    $count3 = DB::table('partenaires')->count();
                    return view('dashboard', ['countrec' => $count], ['countann' => $count2], ['countpart' => $count3]);
                } else {
                    return back()->with("fail", "Incorrect Email or password");
                }
            }
        }
    }
    public function plusDeProduits(Request $request)
    {
        $request->validate([
            "id" => 'required',
            "type" => 'required',
            "titre" => 'nullable',
            "Ville" => 'nullable',
            "Categorie" => 'nullable',
            "Prix" => 'nullable',
        ]);
        $Annonces =  new User();
        $Annonce = $Annonces->getAllAnnonces();
        $annonce = (array)$Annonce;
        $info = new User();
        $villes1 = $info->getVille();
        $villes = json_decode(json_encode($villes1), true);
        $categories =  $info->getCategorie();
        $categorie = json_decode(json_encode($categories), true);

        if ($request->type == "client") {
            // echo "client";
            $user2 = Client::where('id', '=', $request->id)->first();
            if ($user2) {
                if ($request->Categorie) {
                    return view('view_Annonces', ['user' => $user2, 'annonces' => $annonce,  'type' => "client", 'villes' => $villes, 'categories' => $categorie, 'CatRechercher' => $request->Categorie, 'titreRechercher' => $request->titre, 'villeRechercher' => $request->Ville, 'prixRechercher' => $request->Prix]);
                } else {
                    return view('view_Annonces', ['user' => $user2, 'annonces' => $annonce,  'type' => "client", 'villes' => $villes, 'categories' => $categorie]);
                }
            } else {
                echo "problemClient";
            }
        } elseif ($request->type == "partenaire") {
            // echo "partenaire";
            $user2 = Partenaire::where('id', '=', $request->id)->first();
            if ($request->Categorie) {
                return view('view_Annonces', ['user' => $user2, 'annonces' => $annonce,  'type' => "client", 'villes' => $villes, 'categories' => $categorie, 'CatRechercher' => $request->Categorie, 'titreRechercher' => $request->titre, 'villeRechercher' => $request->Ville, 'prixRechercher' => $request->Prix]);
            } else {
                return view('view_Annonces', ['user' => $user2, 'annonces' => $annonce, 'type' => "partenaire", 'villes' => $villes, 'categories' => $categorie]);
            }
        } else {
            echo "problem";
            if ($request->Categorie) {
                return view('view_Annonces', ['annonces' => $annonce, 'villes' => $villes, 'categories' => $categorie, 'CatRechercher' => $request->Categorie, 'titreRechercher' => $request->titre, 'villeRechercher' => $request->Ville, 'prixRechercher' => $request->Prix]);
            } else {

                return view('view_Annonces', ['annonces' => $annonce, 'villes' => $villes, 'categories' => $categorie]);
            }
        }
    }

    public function annonce(Request $request)
    {
        $request->validate([
            "id" => 'required',
            "type" => 'required',
            "idAnnonce" => 'required',
            'accept' => 'nullable',
            "decline" => "nullable",
            'IdLocation' => "nullable",
        ]);

        if ($request->type == "client") {
            $user2 = Client::where('id', '=', $request->id)->first();

            if ($user2) {
                $Annonces =  new User();
                // echo $request->idAnnonce;
                $Annonce = $Annonces->getInfoAnnonce($request->idAnnonce);

                $dates = $Annonces->getTimes();
                // var_dump($dates);

                // var_dump($Annonce);
                $image = $Annonces->getImage($request->idAnnonce);
                // var_dump($image['Image']);
                $annonce = (array)$Annonce[0];
                // var_dump($annonce);

                // var_dump($dates);
                $results = DB::select('select *  from avisobjet a join clients c on a.idClients=c.id  where IdObjet   = :IdObjet   ', ['IdObjet' => $annonce['IdObjet']]);
                $res = json_decode(json_encode($results), true);

                // var_dump($res[0]["UsernameClient"]);
                $user3 = Partenaire::where('id', '=', $annonce["idPartenaires"])->first();

                // if ($res) {
                return view('view_Annonce', ['user' => $user2, 'type' => "client", "Annonce" => $annonce, "partenaire" => $user3, "avisObjet" => $res, "image" => $image['Image'], 'dates' => $dates]);
                // }
            } else {
                echo "problemClient";
            }
        } elseif ($request->type == "partenaire") {

            $Annonces =  new User();



            // echo "partenaire";
            $user2 = Partenaire::where('id', '=', $request->id)->first();

            $Annonce = $Annonces->getInfoAnnonce($request->idAnnonce);
            $image = $Annonces->getImage($request->idAnnonce);

            $annonce = (array)$Annonce[0];

            // var_dump($annonce);

            $Demandes = $Annonces->DemandesDeLocation($request->id);
            $results = DB::select('select *  from avisobjet a join clients c on a.idClients=c.id  where IdObjet   = :IdObjet   ', ['IdObjet' => $annonce['IdObjet']]);
            $res = json_decode(json_encode($results), true);
            // $idObjet = $res[0]['IdObjet'];
            // var_dump($res);
            $user3 = Partenaire::where('id', '=', $annonce["idPartenaires"])->first();
            if ($request->accept) {
                // echo 'accepted gang';
                // echo $request->IdLocation;
                // echo 'accepted gang';

                $Annonces->AccepterDemandeLocation($request->IdLocation);
                // Getting location and client
                $ClinetMail = $Annonces->GettingInfoForEmail($request->IdLocation);
                $testing = (array)$ClinetMail[0];
                // var_dump($testing);
                // getting objet
                $ObjetMil = $Annonces->GettingTheObjetFormMAil($testing['IDANnonce']);
                $testing2 = (array)$ObjetMil[0];
                // var_dump($testing2);
                Mail::to("tbestt4@gmail.com")->send(new InfoClient($testing["NomClint"], $testing["PrenomClient"], $testing["UsernameClient"], $testing["EmailClient"], $testing2[" NomObjet"], $testing["DateDebutLoc"], $testing["DateFinLoc"]));
                // getting the email

                // sending


                // sending email with the clients info

                // return back();
                // echo "did it go throught ?";
                // return view('view_Annonce', ['user' => $user2, 'type' => "partenaire", "Annonce" => $annonce, "partenaire" => $user3, "avisObjet" => $res, "image" => $image['Image'], 'Demandes' => $Demandes]);
            }
            if ($request->decline) {
                // echo 'loser gang';
                $Annonces->RefuserDemandeLocation($request->IdLocation);
                // return back();
                return view('view_Annonce', ['user' => $user2, 'type' => "partenaire", "Annonce" => $annonce, "partenaire" => $user3, "avisObjet" => $res, "image" => $image['Image'], 'Demandes' => $Demandes]);
            }


            // var_dump($annonce['IdObjet']);

            return view('view_Annonce', ['user' => $user2, 'type' => "partenaire", "Annonce" => $annonce, "partenaire" => $user3, "avisObjet" => $res, "image" => $image['Image'], 'Demandes' => $Demandes]);
        } else {
            echo "problem";
            return view('view_Annonce');
        }
    }


    public function profile()
    {
        $res = DB::select(" select * from clients where id = 1 ");

        foreach ($res as $e) {
            $data = $e;
        }

        return view('Profil', ['data' => $data]);
    }

    public function Notes(Request $req)
    {
        $req->validate([
            "id" => 'required',
            "type" => 'required',
            'idLocation' => 'nullable',

            'noteobjet' => 'nullable',
            'notepartenaire' => 'nullable',
            'noteClient' => 'nullable',
            'CommentairePartenaire' => 'nullable',
            'CommentaireObjet' => 'nullable',
            'CommentaireObjet' => 'nullable',

        ]);
        if ($req->type == "client") {
            $user2 = Client::where('id', '=', $req->id)->first();
            // DB::INSERT('insert into avispartenaires (Notepartenaires, Commentairepartenaires, idClients, positif, idPartenaires) VALUES (?,?,?,?,?)', [$req->get("notepartenaire"), $req->get("Commentaire"), "1", "1", "1"]);
            // DB::INSERT('insert into avisobjet (CommentaireObjet, NoteObjet, idClients , IdObjet , positif) VALUES (?,?,?,?,?)', [$req->get("Commentaire"), $req->get("noteobjet"), "1", "1", "1"]);
            if ($req->idLocation) {
                $user = new User();
                $Informations = $user->getInfoLocation($req->idLocation);
                $Information = $Informations[0];
                // var_dump($Information);
                $InfoObjet = $user->GettingTheObjetFormMAil($Information['IDANnonce']);
                $Info1 = $InfoObjet[0];
                // var_dump($Info1);
                $InfoPartenaire = $user->getPartenaireInfo($Information['IDPartenaire']);
                $Info2 = $InfoPartenaire[0];
                // var_dump($Info2);
                // get Objet
                return view('Notes', ['id' => $req->id, 'Objet' => $Info1, 'LePartenaire' => $Info2, 'idLocation' => $req->idLocation, 'type' => "client"]);

                // get nom Partenaire
            } else {
                return view('Notes', ['id' => $req->id, 'idLocation' => $req->idLocation, 'type' => "client"]);
            }
        } else if ($req->type == "partenaire") {
            $user2 = Partenaire::where('id', '=', $req->id)->first();
            // DB::INSERT('insert into avispartenaires (Notepartenaires, Commentairepartenaires, idClients, positif, idPartenaires) VALUES (?,?,?,?,?)', [$req->get("notepartenaire"), $req->get("Commentaire"), "1", "1", "1"]);
            // DB::INSERT('insert into avisobjet (CommentaireObjet, NoteObjet, idClients , IdObjet , positif) VALUES (?,?,?,?,?)', [$req->get("Commentaire"), $req->get("noteobjet"), "1", "1", "1"]);
            return view('Notes', ['id' => $req->id, 'idLocation' => $req->idLocation, 'type' => "partenaire"]);
        }
    }




    public function Reclamation(Request $req)
    {
        $req->validate([
            "id" => 'required',
            "type" => 'required',
            "goal" => 'nullable',
            "Reponse" => 'nullable',
            'lu' => 'nullable',
            'IdReponse' => "nullable",
        ]);
        $ClientNotif =  new User();
        // echo "passing to lire";
        // echo $req->IdReponse;
        // echo "passing to lire";

        if ($req->IdReponse) {
            $reclamations = $ClientNotif->lireReponse($req->IdReponse);
        }
        // echo "The response";
        // echo $req->Reponse;
        // echo "The response";

        if ($req->type == "client" && !$req->goal) {
            // var_dump("1");
            $user2 = Client::where('id', '=', $req->id)->first();
            $reclamations = $ClientNotif->reponseAdminClient($req->id);
            if ($req->Reponse) {
                // echo "please";

                return view('View_Reclamation', ['id' => $req->id, 'type' => $req->type, 'client' => $user2,  'Reponse' => $req->Reponse, 'reclamations' => $reclamations]);
            } else {
                return view('View_Reclamation', ['id' => $req->id, 'type' => $req->type, 'client' => $user2, 'reclamations' => $reclamations]);
            }
        } else if ($req->type == "partenaire" && !$req->goal) {
            // var_dump("2");
            $ClientNotif2 =  new User();
            $reclamations = $ClientNotif2->reponseAdminPartenaire($req->id);
            $user2 = Partenaire::where('id', '=', $req->id)->first();
            if ($req->Reponse) {
                return view('View_Reclamation', ['id' => $req->id, 'type' => 'partenaire', 'partenaire' => $user2, 'Reponse' => $req->Reponse, 'reclamations' => $reclamations]);
            } else {
                return view('View_Reclamation', ['id' => $req->id, 'type' => 'partenaire', 'partenaire' => $user2, 'reclamations' => $reclamations]);
            }
        } else if ($req->type == "client" && $req->goal == "insert") {
            // var_dump("3");
            DB::INSERT('insert into Reclamation (idClients , ObjetReclam, MessageReclam) VALUES (?,?,?)', [$req->id, $req->get("objet"), $req->get("message")]);
            // return back();
            return view('View_Reclamation', ['id' => $req->id, 'type' => $req->type]);

            // return back();
        } else if ($req->type == "partenaire" && $req->goal == "insert") {
            // var_dump("4");

            DB::INSERT('insert into Reclamation (idPartenaires, ObjetReclam, MessageReclam) VALUES (?,?,?)', [$req->id, $req->get("objet"), $req->get("message")]);
            return view('View_Reclamation', ['id' => $req->id, 'type' => $req->type]);
        }
    }




    public function MesAnnoncesClient()
    {
        return view('View_MesAnnoncesClient');
    }
    public function MesLocClient()
    {
        return view('View_MesLocClient');
    }

    public function publier(Request $request)
    {
        $request->validate([
            "id" => 'required',
        ]);
        $info  = new User();
        $categories =  $info->getCategorie();
        $categorie = json_decode(json_encode($categories), true);
        $user2 = Partenaire::where('id', '=', $request->id)->first();
        $objets = $info->getObjets($request->id);
        // var_dump($objets);
        // $objets = $info->getObjets($request->id);
        // var_dump($objets);
        return view('view_Publier_Objet', ['partenaire' => $user2, 'categories' => $categorie, 'objets' => $objets]);
    }


    public function add(Request $request)
    {
        $request->validate([
            "id" => 'required',

            "nomObjet" => 'required',
            "categorie" => 'required',
            "prix" => 'required',
            "ville" => "required",
            "descriptionObjet" => "required",
            "date" => "required",
            "fichier" => "nullable",
            // "idObjet" => "nullable",
            "type" => "nullable",
            // "objet" => "required",
        ]);

        $info  = new User();
        $objets = $info->getObjets($request->id);
        // var_dump($objets);
        $categories =  $info->getCategorie();
        $categorie = json_decode(json_encode($categories), true);
        $user2 = Partenaire::where('id', '=', $request->id)->first();


        // var_dump($request->nomObjet);
        // echo $request->categorie;
        // echo $request->prix;
        // echo $request->ville;
        $dates = explode(" - ", $request->date);
        $time_input = strtotime($dates[0]);
        $time_input2 = strtotime($dates[1]);
        // echo $dates[0];
        $newformat = date('Y-m-d', $time_input);
        $newformat2 = date('Y-m-d', $time_input2);
        if (!$request->ville) {
            echo "not really working ";
        }

        //DB::INSERT('insert into objet ( NomObjet, CategorieObjet, PrixObjet,VilleObjet,idPartenaires ,DescriptionObjet) VALUES (?,?,?,?,?)', ["what", $request->categorie, $request->prix, $request->ville, 1, $request->descriptionObjet]);
        $checkingAnnoncesNumber = $info->checkAnnonce($request->id);
        // echo ($checkingAnnoncesNumber[0]['count(o.IdObjet)']);
        $counting  = $checkingAnnoncesNumber[0]['count(o.IdObjet)'];
        if ($counting < 5) {
            $query = DB::table('objet')->insert([
                ' NomObjet' => $request->input('nomObjet'),
                'CategorieObjet' => $request->input('categorie'),
                'PrixObjet' => $request->input('prix'),
                'VilleObjet' => $request->input('ville'),
                'idPartenaires' => $request->id,
                'DescriptionObjet' => $request->input('descriptionObjet')
            ]);
            // get last inserted id in table objet
            $lastID = DB::getPdo()->lastInsertId();
            $query2 = DB::table('annonce')->insert([
                'IdObjet' => $lastID,
                'Premium' => $request->input('premium'),
                'Dureepremium' => $request->input('Dureepremium'),
                'Image' => $request->input('fichier'),
                'DateDebut' => $newformat,
                'DateFin' => $newformat2,
                "archivee" => "non"


            ]);
            if ($query2) {
                return view('view_Publier_Objet', ['partenaire' => $user2, 'categories' => $categorie, 'objets' => $objets]);
            } else {
                echo "there has been some problem";
            }
        } else {
            echo "Vous pouvez pas louer plus de 5 objets";
        }
        //  else {
        //     // get last inserted id in table objet
        //
        //     $lastID = DB::getPdo()->lastInsertId();
        //     // echo ($checkingAnnoncesNumber[0]['count(IdAnnonce)']);
        //     // $NbrAnnoncesActifs = $checkingAnnoncesNumber[0]['count(IdAnnonce)'];
        //     // echo $NbrAnnoncesActifs;
        //     // if ($NbrAnnoncesActifs < 5) {
        //     // DB::INSERT('insert into annonce ( IdObjet, Premium, Dureepremium,Image,DateDebut ,DateFin) VALUES (?,?,?,?,?,?)   ', [$request->objet, $request->input('premium'), $request->input('Dureepremium'), $request->fichier, $newformat, $newformat2]);
        //     $query2 = DB::table('annonce')->insert([
        //         'IdObjet' => $request->objet,
        //         'Premium' => $request->input('premium'),
        //         'Dureepremium' => $request->input('Dureepremium'),
        //         'Image' => $request->input('fichier'),
        //         'DateDebut' => $newformat,
        //         'DateFin' => $newformat2,
        //         "archivee" => "non"
        //     ]);
        //     if ($query2) {
        //         // echo "here";
        //         return view('view_Publier_Objet', ['partenaire' => $user2, 'categories' => $categorie, 'objets' => $objets]);
        //     } else {
        //         echo "there has been some problem";
        //     }
        // }
    }

    // public function dashboard()
    // {
    //     $count = DB::table('reclamation')->count();
    //     $count2 = DB::table('annonce')->count();
    //     $count3 = DB::table('partenaires')->count();

    //     //    compact('count')

    //     return view('dashboard', ['countrec' => $count], ['countann' => $count2], ['countpart' => $count3]);
    // }
    // public function dashboard()
    // {
    //     return view('dashboard');
    // }
    public function devenirPartenaire(Request $request)
    {
        $request->validate([
            "id" => 'required',
        ]);
        $user2 = Client::where('id', '=', $request->id)->first();
        // DB::INSERT('insert into partenaires (NomPartenaire, PrenomPartenaire, UsernamePartenaire, EmailPartenaire , PasswordPartenaire) VALUES (?,?,?,?,?)', [$user2->NomClint, $user2->PrenomClient, $user2->UsernameClient, $user2->EmailClient, $user2->PasswordClient]);
        $partenaire = new Partenaire();
        $partenaire->NomPartenaire = $user2->NomClint;
        $partenaire->PrenomPartenaire = $user2->PrenomClient;
        $partenaire->UsernamePartenaire = $user2->UsernameClient;
        $partenaire->EmailPartenaire = $user2->EmailClient;
        $partenaire->PasswordPartenaire = $user2->PasswordClient;
        $res  = $partenaire->save();

        $user2 = Partenaire::where('EmailPartenaire', '=', $partenaire->EmailPartenaire)->first();
        // var_dump($user2);
        if ($res) {
            // $AnnoncesPremium =  new User();
            // echo $AnnoncesPremium->IdAnnonce;
            // echo $AnnoncesPremium;
            $AnnoncesPremium =  new User();
            $annonces =  $AnnoncesPremium->getAnnoncesPremium();
            $villes =  $AnnoncesPremium->getVille();
            $categories =  $AnnoncesPremium->getCategorie();
            $ville = json_decode(json_encode($villes), true);
            $categorie = json_decode(json_encode($categories), true);
            // $annonce = (array)$annonces;

            return view('view_Acceuil', ['partenaire' => $user2, 'annonces' => $annonces, 'villes' => $ville, 'categories' => $categorie]);

            // return view('view_Acceuil', ["AnnoncesPremium", $AnnoncesPremium]);
        } else {
            return back()->with("fail", "$request->type, there is a problem");
        }
    }
    public function location(Request $req)
    {
        $req->validate([
            "IDAnnonce" => 'required',
            "IDPartenaire" => 'required',
            "date" => 'required',
            "IDClient" => "required",
        ]);
        // echo $req->IDObjet;
        // echo $req->IDPartenaire;
        // echo $req->IDClient;
        // echo $req->IDObjet ;


        // echo $req->date;
        $dates = explode(" - ", $req->date);
        $time_input = strtotime($dates[0]);
        $time_input2 = strtotime($dates[1]);


        // echo $dates[0];
        $newformat = date('Y-m-d', $time_input);
        $newformat2 = date('Y-m-d', $time_input2);
        echo $newformat;
        echo "hello";
        echo $newformat2;
        DB::INSERT('insert into location ( DateDebutLoc, DateFinLoc, IDANnonce ,IdClient,IDPartenaire ,Status) VALUES (?,?,?,?,?,?)', [$newformat, $newformat2, $req->IDAnnonce, $req->IDClient, $req->IDPartenaire, "non"]);
    }
    // public function lochere(Request $request)
    // {
    //     $request->validate([
    //         "id" => 'required',
    //         "type" => 'required',
    //         "titre" => 'nullable',
    //         "Ville" => 'nullable',
    //         "Categorie" => 'nullable',
    //         "Prix" => 'nullable',
    //     ]);
    //     $AnnoncesPremium =  new User();
    //     $annonces =  $AnnoncesPremium->getAnnoncesPremium();
    //     $info = new User();
    //     $villes1 = $info->getVille();
    //     $villes = json_decode(json_encode($villes1), true);
    //     $categories =  $AnnoncesPremium->getCategorie();
    //     $categorie = json_decode(json_encode($categories), true);
    //     return view('view_Acceuil', ['annonces' => $annonces,  'villes' => $villes, 'categories' => $categorie, 'CatRechercher' => $request->Categorie, 'titreRechercher' => $request->titre, 'villeRechercher' => $request->Ville, 'prixRechercher' => $request->Prix]);
    //     echo "something";
    // }

}