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
use Illuminate\Support\Facades\Redirect;

use Session;
use Symfony\Component\Translation\Loader\FileLoader;

use function PHPUnit\Framework\isNull;

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

    // public function dashboard()
    // {
    //     $count = DB::table('reclamation')->count();
    //     $count2 = DB::table('annonce')->count();
    //     $count3 = DB::table('partenaires')->count();
    //     return view('dashboard', ['countrec' => $count], ['countann' => $count2], ['countpart' => $count3]);
    // }
    public function loginUser(Request $request)
    {
        if (isset($request->Ville)) {
            echo "moretesting";
            echo "moretesting";
            echo "moretesting";
            echo "moretesting";
            return Redirect::back();
        }
        $request->validate([
            "email" => 'required',
            "password" => 'required',
            "titre" => 'nullable',
            "Ville" => 'nullable',
            "Categorie" => 'nullable',
            "Prix" => 'nullable',
        ]);
        if (isset($request->Ville)) {
            echo "moretesting";
            echo "moretesting";
            echo "moretesting";
            echo "moretesting";
            return Redirect::back();
        }

        $AnnoncesPremium =  new User();
        $annonces =  $AnnoncesPremium->getAnnoncesPremium();
        $villes =  $AnnoncesPremium->getVille();
        $ville = json_decode(json_encode($villes), true);

        $categories =  $AnnoncesPremium->getCategorie();
        // next
        $categorie = json_decode(json_encode($categories), true);
        // sering all premium data
        foreach ($annonces as $annonce) {
            $test = (array)$annonce;
            $the_date2  = $test["DateDebut"];
            $the_date = date_create($the_date2);
            $todaysDate = date_create(date("Y-m-d"));

            // $separatingTest = explode("-", $test["DateDebut"]);
            if ($test["Dureepremium"]) {
                $duree = $test["Dureepremium"];
                date_add($the_date, date_interval_create_from_date_string("$duree days"));
            }
            // echo date_format($the_date, "Y-m-d");
            // echo "before";
            // echo date("Y-m-d");
            // echo "after";
            if ($the_date < $todaysDate) {
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


            if ($EndDate < $todaysDate2) {
                // echo "yeah thats too far";
                // var_dump($EndDate);
                // var_dump($todaysDate2);
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
                $currentYear = date("Y");
                // echo $currentYear;
                $countrec = DB::table('reclamation')->get()->count();
                $countann = DB::table('annonce')->get()->count();
                $countcst = DB::table('clients')->get()->count();
                $countpart = DB::table('partenaires')->get()->count();
                $countprem = DB::table('annonce')->where('Premium', 'oui')->count();
                $januaryRentals = DB::table('location')->whereMonth('DateDebutLoc', '=', '01')->whereYear('DateDebutLoc', '=', $currentYear)->get()->count();
                $februaryRentals = DB::table('location')->whereMonth('DateDebutLoc', '=', '02')->whereYear('DateDebutLoc', '=', $currentYear)->get()->count();
                $marchRentals = DB::table('location')->whereMonth('DateDebutLoc', '=', '03')->whereYear('DateDebutLoc', '=', $currentYear)->get()->count();
                $aprilRentals = DB::table('location')->whereMonth('DateDebutLoc', '=', '04')->whereYear('DateDebutLoc', '=', $currentYear)->get()->count();
                $mayRentals = DB::table('location')->whereMonth('DateDebutLoc', '=', '05')->whereYear('DateDebutLoc', '=', $currentYear)->get()->count();
                $juneRentals = DB::table('location')->whereMonth('DateDebutLoc', '=', '06')->whereYear('DateDebutLoc', '=', $currentYear)->get()->count();
                $julyRentals = DB::table('location')->whereMonth('DateDebutLoc', '=', '07')->whereYear('DateDebutLoc', '=', $currentYear)->get()->count();
                $augustRentals = DB::table('location')->whereMonth('DateDebutLoc', '=', '08')->whereYear('DateDebutLoc', '=', $currentYear)->get()->count();
                $septemberRentals = DB::table('location')->whereMonth('DateDebutLoc', '=', '09')->whereYear('DateDebutLoc', '=', $currentYear)->get()->count();
                $octoberRentals = DB::table('location')->whereMonth('DateDebutLoc', '=', '10')->whereYear('DateDebutLoc', '=', $currentYear)->get()->count();
                $novemberRentals = DB::table('location')->whereMonth('DateDebutLoc', '=', '11')->whereYear('DateDebutLoc', '=', $currentYear)->get()->count();
                $decemberRentals = DB::table('location')->whereMonth('DateDebutLoc', '=', '12')->whereYear('DateDebutLoc', '=', $currentYear)->get()->count();
                $januaryPartners = DB::table('partenaires')->whereMonth('created_at', '=', '01')->whereYear('created_at', '=', $currentYear)->get()->count();
                $februaryPartners = DB::table('partenaires')->whereMonth('created_at', '=', '02')->whereYear('created_at', '=', $currentYear)->get()->count();
                $marchPartners = DB::table('partenaires')->whereMonth('created_at', '=', '03')->whereYear('created_at', '=', $currentYear)->get()->count();
                $aprilPartners = DB::table('partenaires')->whereMonth('created_at', '=', '04')->whereYear('created_at', '=', $currentYear)->get()->count();
                $mayPartners = DB::table('partenaires')->whereMonth('created_at', '=', '05')->whereYear('created_at', '=', $currentYear)->get()->count();
                $junePartners = DB::table('partenaires')->whereMonth('created_at', '=', '06')->whereYear('created_at', '=', $currentYear)->get()->count();
                $julyPartners = DB::table('partenaires')->whereMonth('created_at', '=', '07')->whereYear('created_at', '=', $currentYear)->get()->count();
                $augustPartners = DB::table('partenaires')->whereMonth('created_at', '=', '08')->whereYear('created_at', '=', $currentYear)->get()->count();
                $septemberPartners = DB::table('partenaires')->whereMonth('created_at', '=', '09')->whereYear('created_at', '=', $currentYear)->get()->count();
                $octoberPartners = DB::table('partenaires')->whereMonth('created_at', '=', '10')->whereYear('created_at', '=', $currentYear)->get()->count();
                $novemberPartners = DB::table('partenaires')->whereMonth('created_at', '=', '11')->whereYear('created_at', '=', $currentYear)->get()->count();
                $decemberPartners = DB::table('partenaires')->whereMonth('created_at', '=', '12')->whereYear('created_at', '=', $currentYear)->get()->count();
                $januaryCustomers = DB::table('clients')->whereMonth('created_at', '=', '01')->whereYear('created_at', '=', $currentYear)->get()->count();
                $februaryCustomers = DB::table('clients')->whereMonth('created_at', '=', '02')->whereYear('created_at', '=', $currentYear)->get()->count();
                $marchCustomers = DB::table('clients')->whereMonth('created_at', '=', '03')->whereYear('created_at', '=', $currentYear)->get()->count();
                $aprilCustomers = DB::table('clients')->whereMonth('created_at', '=', '04')->whereYear('created_at', '=', $currentYear)->get()->count();
                $mayCustomers = DB::table('clients')->whereMonth('created_at', '=', '05')->whereYear('created_at', '=', $currentYear)->get()->count();
                $juneCustomers = DB::table('clients')->whereMonth('created_at', '=', '06')->whereYear('created_at', '=', $currentYear)->get()->count();
                $julyCustomers = DB::table('clients')->whereMonth('created_at', '=', '07')->whereYear('created_at', '=', $currentYear)->get()->count();
                $augustCustomers = DB::table('clients')->whereMonth('created_at', '=', '08')->whereYear('created_at', '=', $currentYear)->get()->count();
                $septemberCustomers = DB::table('clients')->whereMonth('created_at', '=', '09')->whereYear('created_at', '=', $currentYear)->get()->count();
                $octoberCustomers = DB::table('clients')->whereMonth('created_at', '=', '10')->whereYear('created_at', '=', $currentYear)->get()->count();
                $novemberCustomers = DB::table('clients')->whereMonth('created_at', '=', '11')->whereYear('created_at', '=', $currentYear)->get()->count();
                $decemberCustomers = DB::table('clients')->whereMonth('created_at', '=', '12')->whereYear('created_at', '=', $currentYear)->get()->count();


                $data = [
                    "countrec"  => $countrec,
                    'countann'   => $countann,
                    'countcst' => $countcst,
                    'countpart' => $countpart,
                    'countprem' => $countprem,
                    'januaryRentals' => $januaryRentals,
                    'februaryRentals' => $februaryRentals,
                    'marchRentals' => $marchRentals,
                    'aprilRentals' => $aprilRentals,
                    'mayRentals' => $mayRentals,
                    'juneRentals' => $juneRentals,
                    'julyRentals' => $julyRentals,
                    'augustRentals' => $augustRentals,
                    'septemberRentals' => $septemberRentals,
                    'octoberRentals' => $octoberRentals,
                    'novemberRentals' => $novemberRentals,
                    'decemberRentals' => $decemberRentals,
                    'januaryCustomers' => $januaryCustomers,
                    'februaryCustomers' => $februaryCustomers,
                    'marchCustomers' => $marchCustomers,
                    'aprilCustomers' => $aprilCustomers,
                    'mayCustomers' => $mayCustomers,
                    'juneCustomers' => $juneCustomers,
                    'julyCustomers' => $julyCustomers,
                    'augustCustomers' => $augustCustomers,
                    'septemberCustomers' => $septemberCustomers,
                    'octoberCustomers' => $octoberCustomers,
                    'novemberCustomers' => $novemberCustomers,
                    'decemberCustomers' => $decemberCustomers,
                    'januaryPartners' => $januaryPartners,
                    'februaryPartners' => $februaryPartners,
                    'marchPartners' => $marchPartners,
                    'aprilPartners' => $aprilPartners,
                    'mayPartners' => $mayPartners,
                    'junePartners' => $junePartners,
                    'julyPartners' => $julyPartners,
                    'augustPartners' => $augustPartners,
                    'septemberPartners' => $septemberPartners,
                    'octoberPartners' => $octoberPartners,
                    'novemberPartners' => $novemberPartners,
                    'decemberPartners' => $decemberPartners,
                ];

                return  view('dashboard', ["data" => $data, 'email' => $result["EmailAdmin"]]);

                // return view('getDataDashboard', ['countrec' => $count], ['countann' => $count2], ['countpart' => $count3]);
            }
        } else if ($user && !$user2) {
            if (Hash::check($request->password, $user->PasswordClient)) {

                if (isset($request->titre)) {
                    echo $request->titre;
                    // echo "fucing pease";
                }
                $GettingNotifs = $AnnoncesPremium->SelectingNotifs();
                $reponseAdminClient  = null;
                $idReclamationClient = null;
                $ClientNotif =  new User();
                // see how to store the reclamations all of them
                $reclamations = $ClientNotif->reponseAdminClient($user->id);


                foreach ($reclamations as $reclamation) {
                    if ($reclamation["ReponseReclam"] != NULL) {
                        if ($reclamation["ReclamationLu"] == "non") {
                            // compare witrh what i already have in the db
                            // echo 'wher tf am i ';

                            $i = 0;
                            foreach ($GettingNotifs as $notifs2) {
                                $notifs = (array)$notifs2;

                                if ($notifs == null) {
                                    $AnnoncesPremium->insertMessgaeAdmin($reclamation["IdReclamation"], $reclamation["ReponseReclam"], $user->id, $reclamation["ObjetReclam"]);
                                } else {
                                    // echo "wahtt";
                                }
                                if ($notifs['IDReclamation'] == $reclamation["IdReclamation"]) {
                                    $i = 1;
                                }
                            }
                            if ($i == 0) {
                                $AnnoncesPremium->insertMessgaeAdmin($reclamation["IdReclamation"], $reclamation["ReponseReclam"], $user->id, $reclamation["ObjetReclam"]);
                            } else {
                                $i = 0;
                            }

                            // ajouter a la table de notifications reponse
                        }
                    } else if ($reclamation["ReponseReclam"] == NULL && $reclamation["VueReclamationAdmin"] != "non") {
                        // compare witrh what i already have in the db
                        $i = 0;

                        foreach ($GettingNotifs as $notifs2) {

                            $notifs = (array)$notifs2;

                            if ($notifs == null) {
                                $AnnoncesPremium->insertVueAdmin($reclamation["IdReclamation"], $user->id, $reclamation["ObjetReclam"]);
                            } else {
                                // echo "wahtt";
                            }

                            if ($notifs["IDReclamation"] == $reclamation["IdReclamation"]) {
                                $i = 1;
                            }
                        }
                        if ($i == 0) {
                            $AnnoncesPremium->insertVueAdmin($reclamation["IdReclamation"], $user->id, $reclamation["ObjetReclam"]);
                        } else {
                            $i = 0;
                        }
                        // ajouter a la table de notifications  vue
                    }
                }




                $GettingAll =  $AnnoncesPremium->getAllAnnonces();

                // 2 les notes

                $CheckNoteClient = $AnnoncesPremium->CheckNoteClient($user->id);


                foreach ($CheckNoteClient as $data) {
                    if ($data["IdLocation"] != null) {

                        $i = 0;
                        foreach ($GettingNotifs as $notifs2) {
                            $notifs = (array)$notifs2;
                            if ($notifs == null) {
                                $AnnoncesPremium->insretingNotes($data["IdLocation"], $data["IdClient"], $data["IDPartenaire"]);
                            } else {
                                // echo "wahtt";
                            }
                            if ($data["IdLocation"] == $notifs["IDLocation"] && $data["IdClient"] == $notifs["IDclient"] && $data["IDPartenaire"] == $notifs["IDPartenaire"]) {
                                $i = 1;
                            }
                        }
                        if ($i == 0) {
                            $insertingNotes = $AnnoncesPremium->insretingNotes($data["IdLocation"], $data["IdClient"], $data["IDPartenaire"]);
                        } else {
                            $i = 0;
                        }
                        // else {
                        //     echo "here2aybe";
                        //     $AnnoncesPremium->insretingNotes($data["IdLocation"], $data["IdClient"], $data["IDPartenaire"]);
                        // }
                    }
                }
                // fix accepter
                $AcceptedLocations = $AnnoncesPremium->LocationAccepterNotifs($user->id);
                $nomObjet = null;
                foreach ($AcceptedLocations as $LocationAccepter) {
                    foreach ($AllData as $data) {
                        $test2 = (array)$data;
                        // var_dump($test2);
                        if ($test2["IdAnnonce"] == $LocationAccepter["IDANnonce"]) {
                            $i = 0;
                            foreach ($GettingNotifs as $notifs2) {
                                $notifs = (array)$notifs2;
                                // $nomObjet = $test2[' NomObjet'];
                                if ($notifs == null) {
                                    echo "idk";
                                    $AnnoncesPremium->insertignAccepted($LocationAccepter["DateDebutLoc"], $LocationAccepter["DateFinLoc"], $LocationAccepter["IdLocation"], $LocationAccepter["IdClient"], $test2["IdObjet"]);
                                } else {
                                    // echo "wahtt";
                                }
                                if ($LocationAccepter["IdLocation"] == $notifs["IDLocation"] && $LocationAccepter["IdClient"] == $notifs["IDclient"] && $test2["IdObjet"] == $notifs["IdObjet"] && $notifs["IDPartenaire"] == null) {
                                    $i = 1;
                                }
                            }
                            if ($i == 0) {
                                echo "inserting the accepted thing  ";
                                $AnnoncesPremium->insertignAccepted($LocationAccepter["DateDebutLoc"], $LocationAccepter["DateFinLoc"], $LocationAccepter["IdLocation"], $LocationAccepter["IdClient"], $test2["IdObjet"]);
                                echo " not inserting the accepted thing  ";
                            } else {
                                $i = 0;
                            }
                        }
                    }
                }
                // fix refuser
                $Refuser = $ClientNotif->LocationRefuser($user->id);
                $nomObjet = null;
                foreach ($Refuser as $REfused) {
                    foreach ($AllData as $data) {
                        $test3 = (array)$data;
                        if ($test3["IdAnnonce"] == $REfused["IDANnonce"]) {
                            $i = 0;
                            foreach ($GettingNotifs as $notifs2) {
                                $notifs = (array)$notifs2;
                                // $nomObjet = $test2[' NomObjet'];
                                if ($notifs == null) {
                                    // echo "idk";
                                    $AnnoncesPremium->insertignRefused($REfused["DateDebutLoc"], $REfused["DateFinLoc"], $REfused["IdLocation"], $REfused["IdClient"], $test3["IdObjet"]);
                                } else {
                                    // echo "wahtt";
                                }
                                if ($REfused["IdLocation"] == $notifs["IDLocation"] && $REfused["IdClient"] == $notifs["IDclient"] && $test3["IdObjet"] == $notifs["IdObjet"] && $notifs["IDPartenaire"] == null) {
                                    $i = 1;
                                }
                            }
                            if ($i == 0) {
                                // echo "inserting the accepted thing  ";
                                $AnnoncesPremium->insertignRefused($REfused["DateDebutLoc"], $REfused["DateFinLoc"], $REfused["IdLocation"], $REfused["IdClient"], $test3["IdObjet"]);
                                // echo " not inserting the accepted thing  ";
                            } else {
                                $i = 0;
                            }
                        }
                    }
                }
                // getting all notifications and sorting them by desc
                $allNotifsSelected = $AnnoncesPremium->selectingNotifications();
                $AlreadyTryingToLocate = $AnnoncesPremium->selectingAllFromLocation();

                // var_dump($allNotifsSelected);
                return view('view_Acceuil', ['client' => $user, 'AlreadyTryingToLocate' => $AlreadyTryingToLocate, 'allNotifsSelected' => $allNotifsSelected, 'Refuser' => $Refuser, 'CheckNoteClient' => $CheckNoteClient, 'annonces' => $annonces, 'AllData' => $GettingAll, 'villes' => $ville, 'categories' => $categorie, 'reclamations' => $reclamations, 'LocationsAccepter' => $AcceptedLocations, 'CatRechercher' => $request->Categorie, 'titreRechercher' => $request->titre, 'villeRechercher' => $request->Ville, 'prixRechercher' => $request->Prix]);
            } else {
                return back()->with("fail", "client,$request->password,$user->PasswordClient");
            }
        } else if ($user && $user2) {
            if (Hash::check($request->password, $user2->PasswordPartenaire)) {
                // 2 les notes
                $NewUser = new User();
                // fix note partenaire


                $CheckNotePartenaire = $NewUser->CheckNotePartenaire($user2->id);
                $GettingNotifs = $AnnoncesPremium->SelectingNotifs();
                foreach ($CheckNotePartenaire as $data) {
                    // var_dump($data);
                    if ($data["IdLocation"] != null) {

                        $i = 0;
                        foreach ($GettingNotifs as $notifs2) {
                            $notifs = (array)$notifs2;
                            if ($notifs == null) {
                                // inserting not partenaire
                                $AnnoncesPremium->insretingNotes($data["IdLocation"], $data["IdClient"], $user2->id);
                            } else {
                                // echo "wahtt";
                            }
                            if ($data["IdLocation"] == $notifs["IDLocation"] && $data["IdClient"] == $notifs["IDclient"] && $user2->id == $notifs["IDPartenaire"]) {
                                $i = 1;
                            }
                        }
                        if ($i == 0) {
                            $insertingNotes = $AnnoncesPremium->insretingNotes($data["IdLocation"], $data["IdClient"], $user2->id);
                        } else {
                            $i = 0;
                        }
                    }
                }
                // fix reponse admin
                $reclamations = $NewUser->reponseAdminPartenaire($user2->id);
                foreach ($reclamations as $reclamation) {
                    if ($reclamation["ReponseReclam"] != NULL) {
                        $i = 0;
                        foreach ($GettingNotifs as $notifs2) {
                            $notifs = (array)$notifs2;

                            if ($notifs == null) {
                                $AnnoncesPremium->insertMessgaeAdminPartenaire($reclamation["IdReclamation"], $reclamation["ReponseReclam"], $user2->id, $reclamation["ObjetReclam"]);
                            } else {
                                // echo "wahtt";
                            }
                            if ($notifs['IDReclamation'] == $reclamation["IdReclamation"]) {
                                $i = 1;
                            }
                        }
                        if ($i == 0) {
                            $AnnoncesPremium->insertMessgaeAdminPartenaire($reclamation["IdReclamation"], $reclamation["ReponseReclam"], $user2->id, $reclamation["ObjetReclam"]);
                        } else {
                            $i = 0;
                        }
                    } else if ($reclamation["ReponseReclam"] == NULL && $reclamation["VueReclamationAdmin"] != "non") {

                        $i = 0;

                        foreach ($GettingNotifs as $notifs2) {

                            $notifs = (array)$notifs2;

                            if ($notifs == null) {
                                $AnnoncesPremium->insertVueAdminPartenaire($reclamation["IdReclamation"], $user2->id, $reclamation["ObjetReclam"]);
                            } else {
                                // echo "wahtt";
                            }

                            if ($notifs["IDReclamation"] == $reclamation["IdReclamation"]) {
                                $i = 1;
                            }
                        }
                        if ($i == 0) {
                            $AnnoncesPremium->insertVueAdminPartenaire($reclamation["IdReclamation"], $user2->id, $reclamation["ObjetReclam"]);
                        } else {
                            $i = 0;
                        }
                    }
                }

                // now we select all notifs
                $allNotifsSelected = $AnnoncesPremium->selectingNotifications();


                // var_dump($reclamations);
                return view('view_Acceuil', ['partenaire' => $user2, 'allNotifsSelected' => $allNotifsSelected,  'CheckNotePartenaire' => $CheckNotePartenaire, 'annonces' => $annonces, 'villes' => $ville, 'categories' => $categorie, 'reclamations' => $reclamations, 'CatRechercher' => $request->Categorie, 'titreRechercher' => $request->titre, 'villeRechercher' => $request->Ville, 'prixRechercher' => $request->Prix]);
            }
        } else {
            if ($user2) {
                if (Hash::check($request->password, $user2->PasswordPartenaire)) {
                    $CheckNotePartenaire = $AnnoncesPremium->CheckNotePartenaire($user2->id);

                    $ClientNotif =  new User();
                    $reclamations = $ClientNotif->reponseAdminPartenaire($user2->id);
                    // var_dump($reclamations);
                    return view('view_Acceuil', ['partenaire' => $user2, 'CheckNotePartenaire' => $CheckNotePartenaire, 'annonces' => $annonces, 'villes' => $ville, 'categories' => $categorie, 'reclamations' => $reclamations, 'CatRechercher' => $request->Categorie, 'titreRechercher' => $request->titre, 'villeRechercher' => $request->Ville, 'prixRechercher' => $request->Prix]);
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
            $GettingNotifs = $Annonces->SelectingNotifs();
            $reponseAdminClient  = null;
            $idReclamationClient = null;
            $ClientNotif =  new User();
            //reponseAdminClient
            $reclamations = $Annonces->reponseAdminClient($user2->id);

            foreach ($reclamations as $reclamation) {
                if ($reclamation["ReponseReclam"] != NULL) {
                    if ($reclamation["ReclamationLu"] == "non") {
                        // compare witrh what i already have in the db
                        // echo 'wher tf am i ';

                        $i = 0;
                        foreach ($GettingNotifs as $notifs2) {
                            $notifs = (array)$notifs2;

                            if ($notifs == null) {
                                $Annonces->insertMessgaeAdmin($reclamation["IdReclamation"], $reclamation["ReponseReclam"], $user2->id, $reclamation["ObjetReclam"]);
                            } else {
                                // echo "wahtt";
                            }
                            if ($notifs['IDReclamation'] == $reclamation["IdReclamation"]) {
                                $i = 1;
                            }
                        }
                        if ($i == 0) {
                            $Annonces->insertMessgaeAdmin($reclamation["IdReclamation"], $reclamation["ReponseReclam"], $user2->id, $reclamation["ObjetReclam"]);
                        } else {
                            $i = 0;
                        }

                        // ajouter a la table de notifications reponse
                    }
                } else if ($reclamation["ReponseReclam"] == NULL && $reclamation["VueReclamationAdmin"] != "non") {
                    // compare witrh what i already have in the db
                    $i = 0;

                    foreach ($GettingNotifs as $notifs2) {

                        $notifs = (array)$notifs2;

                        if ($notifs == null) {
                            $Annonces->insertVueAdmin($reclamation["IdReclamation"], $user2->id, $reclamation["ObjetReclam"]);
                        } else {
                            // echo "wahtt";
                        }

                        if ($notifs["IDReclamation"] == $reclamation["IdReclamation"]) {
                            $i = 1;
                        }
                    }
                    if ($i == 0) {
                        $Annonces->insertVueAdmin($reclamation["IdReclamation"], $user2->id, $reclamation["ObjetReclam"]);
                    } else {
                        $i = 0;
                    }
                    // ajouter a la table de notifications  vue
                }
            }




            // checking all announces
            $AllData = $Annonces->checkingAllAnnnonces();
            // getting all the announces
            $GettingAll =  $Annonces->getAllAnnonces();
            //LocationAccepterNotifs
            $AcceptedLocations = $Annonces->LocationAccepterNotifs($user2->id);
            foreach ($AcceptedLocations as $LocationAccepter) {
                foreach ($AllData as $data) {
                    $test2 = (array)$data;
                    // var_dump($test2);
                    if ($test2["IdAnnonce"] == $LocationAccepter["IDANnonce"]) {
                        $i = 0;
                        foreach ($GettingNotifs as $notifs2) {
                            $notifs = (array)$notifs2;
                            // $nomObjet = $test2[' NomObjet'];
                            if ($notifs == null) {
                                echo "idk";
                                $Annonces->insertignAccepted($LocationAccepter["DateDebutLoc"], $LocationAccepter["DateFinLoc"], $LocationAccepter["IdLocation"], $LocationAccepter["IdClient"], $test2["IdObjet"]);
                            } else {
                                // echo "wahtt";
                            }
                            if ($LocationAccepter["IdLocation"] == $notifs["IDLocation"] && $LocationAccepter["IdClient"] == $notifs["IDclient"] && $test2["IdObjet"] == $notifs["IdObjet"] && $notifs["IDPartenaire"] == null) {
                                $i = 1;
                            }
                        }
                        if ($i == 0) {
                            echo "inserting the accepted thing  ";
                            $Annonces->insertignAccepted($LocationAccepter["DateDebutLoc"], $LocationAccepter["DateFinLoc"], $LocationAccepter["IdLocation"], $LocationAccepter["IdClient"], $test2["IdObjet"]);
                            echo " not inserting the accepted thing  ";
                        } else {
                            $i = 0;
                        }
                    }
                }
            }
            // refused locations
            $Refuser = $ClientNotif->LocationRefuser($user2->id);
            $nomObjet = null;
            foreach ($Refuser as $REfused) {
                foreach ($AllData as $data) {
                    $test3 = (array)$data;
                    if ($test3["IdAnnonce"] == $REfused["IDANnonce"]) {
                        $i = 0;
                        foreach ($GettingNotifs as $notifs2) {
                            $notifs = (array)$notifs2;
                            // $nomObjet = $test2[' NomObjet'];
                            if ($notifs == null) {
                                // echo "idk";
                                $Annonces->insertignRefused($REfused["DateDebutLoc"], $REfused["DateFinLoc"], $REfused["IdLocation"], $REfused["IdClient"], $test3["IdObjet"]);
                            } else {
                                // echo "wahtt";
                            }
                            if ($REfused["IdLocation"] == $notifs["IDLocation"] && $REfused["IdClient"] == $notifs["IDclient"] && $test3["IdObjet"] == $notifs["IdObjet"] && $notifs["IDPartenaire"] == null) {
                                $i = 1;
                            }
                        }
                        if ($i == 0) {
                            // echo "inserting the accepted thing  ";
                            $Annonces->insertignRefused($REfused["DateDebutLoc"], $REfused["DateFinLoc"], $REfused["IdLocation"], $REfused["IdClient"], $test3["IdObjet"]);
                            // echo " not inserting the accepted thing  ";
                        } else {
                            $i = 0;
                        }
                    }
                }
            }
            //getAllAnnonces
            $GettingAll =  $Annonces->getAllAnnonces();
            //CheckNoteClient
            $CheckNoteClient = $Annonces->CheckNoteClient($user2->id);
            foreach ($CheckNoteClient as $data) {
                if ($data["IdLocation"] != null) {

                    $i = 0;
                    foreach ($GettingNotifs as $notifs2) {
                        $notifs = (array)$notifs2;
                        if ($notifs == null) {
                            $Annonces->insretingNotes($data["IdLocation"], $data["IdClient"], $data["IDPartenaire"]);
                        } else {
                            // echo "wahtt";
                        }
                        if ($data["IdLocation"] == $notifs["IDLocation"] && $data["IdClient"] == $notifs["IDclient"] && $data["IDPartenaire"] == $notifs["IDPartenaire"]) {
                            $i = 1;
                        }
                    }
                    if ($i == 0) {
                        $insertingNotes = $Annonces->insretingNotes($data["IdLocation"], $data["IdClient"], $data["IDPartenaire"]);
                    } else {
                        $i = 0;
                    }
                    // else {
                    //     echo "here2aybe";
                    //     $AnnoncesPremium->insretingNotes($data["IdLocation"], $data["IdClient"], $data["IDPartenaire"]);
                    // }
                }
            }

            // check if this annonce is demandeed to be located
            $checkIflocated = $Annonces->checkifdemanded($request->id);
            // rest
            // getting all notifications and sorting them by desc
            $allNotifsSelected = $Annonces->selectingNotifications();
            // var_dump($allNotifsSelected);


            if ($user2) {

                if ($request->Categorie) {

                    return view('view_Annonces', ['client' => $user2, 'allNotifsSelected' => $allNotifsSelected, 'checkIflocated' => $checkIflocated, 'AllData' => $GettingAll, 'reclamations' => $reclamations, 'LocationsAccepter' => $AcceptedLocations, 'CheckNoteClient' => $CheckNoteClient, 'annonces' => $annonce,  'type' => "client", 'villes' => $villes, 'categories' => $categorie, 'CatRechercher' => $request->Categorie, 'titreRechercher' => $request->titre, 'villeRechercher' => $request->Ville, 'prixRechercher' => $request->Prix]);
                } else {

                    return view('view_Annonces', ['client' => $user2, 'allNotifsSelected' => $allNotifsSelected, "checkIflocated" => $checkIflocated, 'AllData' => $GettingAll, 'reclamations' => $reclamations, 'LocationsAccepter' => $AcceptedLocations, 'CheckNoteClient' => $CheckNoteClient, 'annonces' => $annonce,  'type' => "client", 'villes' => $villes, 'categories' => $categorie]);
                }
            } else {
                echo "problemClient";
            }
        } elseif ($request->type == "partenaire") {
            // echo "partenaire";
            $GettingNotifs = $Annonces->SelectingNotifs();
            $user2 = Partenaire::where('id', '=', $request->id)->first();
            // checking not partenaire
            $CheckNotePartenaire = $Annonces->CheckNotePartenaire($user2->id);
            $GettingNotifs = $Annonces->SelectingNotifs();
            foreach ($CheckNotePartenaire as $data) {
                // var_dump($data);
                if ($data["IdLocation"] != null) {

                    $i = 0;
                    foreach ($GettingNotifs as $notifs2) {
                        $notifs = (array)$notifs2;
                        if ($notifs == null) {
                            // inserting not partenaire
                            $Annonces->insretingNotes($data["IdLocation"], $data["IdClient"], $user2->id);
                        } else {
                            // echo "wahtt";
                        }
                        if ($data["IdLocation"] == $notifs["IDLocation"] && $data["IdClient"] == $notifs["IDclient"] && $user2->id == $notifs["IDPartenaire"]) {
                            $i = 1;
                        }
                    }
                    if ($i == 0) {
                        $insertingNotes = $Annonces->insretingNotes($data["IdLocation"], $data["IdClient"], $user2->id);
                    } else {
                        $i = 0;
                    }
                }
            }
            // voir reponse partenaire
            $reclamations = $Annonces->reponseAdminPartenaire($user2->id);
            foreach ($reclamations as $reclamation) {
                if ($reclamation["ReponseReclam"] != NULL) {
                    $i = 0;
                    foreach ($GettingNotifs as $notifs2) {
                        $notifs = (array)$notifs2;

                        if ($notifs == null) {
                            $Annonces->insertMessgaeAdminPartenaire($reclamation["IdReclamation"], $reclamation["ReponseReclam"], $user2->id, $reclamation["ObjetReclam"]);
                        } else {
                            // echo "wahtt";
                        }
                        if ($notifs['IDReclamation'] == $reclamation["IdReclamation"]) {
                            $i = 1;
                        }
                    }
                    if ($i == 0) {
                        $Annonces->insertMessgaeAdminPartenaire($reclamation["IdReclamation"], $reclamation["ReponseReclam"], $user2->id, $reclamation["ObjetReclam"]);
                    } else {
                        $i = 0;
                    }
                } else if ($reclamation["ReponseReclam"] == NULL && $reclamation["VueReclamationAdmin"] != "non") {

                    $i = 0;

                    foreach ($GettingNotifs as $notifs2) {

                        $notifs = (array)$notifs2;

                        if ($notifs == null) {
                            $Annonces->insertVueAdminPartenaire($reclamation["IdReclamation"], $user2->id, $reclamation["ObjetReclam"]);
                        } else {
                            // echo "wahtt";
                        }

                        if ($notifs["IDReclamation"] == $reclamation["IdReclamation"]) {
                            $i = 1;
                        }
                    }
                    if ($i == 0) {
                        $Annonces->insertVueAdminPartenaire($reclamation["IdReclamation"], $user2->id, $reclamation["ObjetReclam"]);
                    } else {
                        $i = 0;
                    }
                }
            }
            // getting all announces
            $GettingAll =  $Annonces->getAllAnnonces();
            // now we select all notifs
            $allNotifsSelected = $Annonces->selectingNotifications();
            if ($request->Categorie) {
                return view('view_Annonces', ['partenaire' => $user2,  'allNotifsSelected' => $allNotifsSelected, 'CheckNotePartenaire' => $CheckNotePartenaire, 'annonces' => $annonce,  'type' => "partenaire", 'villes' => $villes, 'categories' => $categorie, 'CatRechercher' => $request->Categorie, 'titreRechercher' => $request->titre, 'villeRechercher' => $request->Ville, 'prixRechercher' => $request->Prix, 'reclamations' => $reclamations]);
            } else {
                return view('view_Annonces', ['partenaire' => $user2,  'allNotifsSelected' => $allNotifsSelected,  'CheckNotePartenaire' => $CheckNotePartenaire, 'annonces' => $annonce, 'type' => "partenaire", 'villes' => $villes, 'categories' => $categorie, 'reclamations' => $reclamations]);
            }
        } else {
            $AnnoncesPremium =  new User();
            $annonces =  $AnnoncesPremium->getAnnoncesPremium();
            $villes =  $AnnoncesPremium->getVille();
            $categories =  $AnnoncesPremium->getCategorie();
            $ville = json_decode(json_encode($villes), true);
            $categorie = json_decode(json_encode($categories), true);
            $annonce = (array)$annonces;
            $GettingAll =  $Annonces->getAllAnnonces();
            if ($request->Categorie) {
                // return view('view_Annonces', ['annonces' => $annonce, 'villes' => $villes, 'categories' => $categorie, 'CatRechercher' => $request->Categorie, 'titreRechercher' => $request->titre, 'villeRechercher' => $request->Ville, 'prixRechercher' => $request->Prix]);
            } else {

                // return view('view_Annonces', ['annonces' => $annonce, 'villes' => $villes, 'categories' => $categorie]);
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

                // getting average not partenaire
                $results = DB::select(' SELECT AVG(Notepartenaires) from avispartenaires where idPartenaires =:id GROUP by IdAvispartenaires ; ', ['id' => $user3->id]);
                $res2 = json_decode(json_encode($results), true);
                $notePartenaire = $res2[0];
                // average note objet
                $average = null;
                $Averagenote = DB::select('SELECT AVG(ao.NoteObjet),o.IdObjet from avisobjet ao join objet o on ao.IdObjet   = o.IdObjet  GROUP by o.IdObjet;');
                $resNote = json_decode(json_encode($Averagenote), true);

                foreach ($resNote as $avg) {

                    if ($avg['IdObjet'] == $annonce['IdObjet']) {

                        $average = $avg['AVG(ao.NoteObjet)'];
                    }
                }
                // checking note
                $CheckNoteClient = $Annonces->CheckNoteClient($user2->id);
                $GettingNotifs = $Annonces->SelectingNotifs();

                foreach ($CheckNoteClient as $data) {
                    if ($data["IdLocation"] != null) {

                        $i = 0;
                        foreach ($GettingNotifs as $notifs2) {
                            $notifs = (array)$notifs2;
                            if ($notifs == null) {
                                $Annonces->insretingNotes($data["IdLocation"], $data["IdClient"], $data["IDPartenaire"]);
                            } else {
                                // echo "wahtt";
                            }
                            if ($data["IdLocation"] == $notifs["IDLocation"] && $data["IdClient"] == $notifs["IDclient"] && $data["IDPartenaire"] == $notifs["IDPartenaire"]) {
                                $i = 1;
                            }
                        }
                        if ($i == 0) {
                            $insertingNotes = $Annonces->insretingNotes($data["IdLocation"], $data["IdClient"], $data["IDPartenaire"]);
                        } else {
                            $i = 0;
                        }
                        // else {
                        //     echo "here2aybe";
                        //     $AnnoncesPremium->insretingNotes($data["IdLocation"], $data["IdClient"], $data["IDPartenaire"]);
                        // }
                    }
                }
                $AllData = $Annonces->checkingAllAnnnonces();

                // seeig the locations accepted
                $AcceptedLocations = $Annonces->LocationAccepterNotifs($user2->id);
                foreach ($AcceptedLocations as $LocationAccepter) {
                    foreach ($AllData as $data) {
                        $test2 = (array)$data;
                        // var_dump($test2);
                        if ($test2["IdAnnonce"] == $LocationAccepter["IDANnonce"]) {
                            $i = 0;
                            foreach ($GettingNotifs as $notifs2) {
                                $notifs = (array)$notifs2;
                                // $nomObjet = $test2[' NomObjet'];
                                if ($notifs == null) {
                                    echo "idk";
                                    $Annonces->insertignAccepted($LocationAccepter["DateDebutLoc"], $LocationAccepter["DateFinLoc"], $LocationAccepter["IdLocation"], $LocationAccepter["IdClient"], $test2["IdObjet"]);
                                } else {
                                    // echo "wahtt";
                                }
                                if ($LocationAccepter["IdLocation"] == $notifs["IDLocation"] && $LocationAccepter["IdClient"] == $notifs["IDclient"] && $test2["IdObjet"] == $notifs["IdObjet"] && $notifs["IDPartenaire"] == null) {
                                    $i = 1;
                                }
                            }
                            if ($i == 0) {
                                echo "inserting the accepted thing  ";
                                $Annonces->insertignAccepted($LocationAccepter["DateDebutLoc"], $LocationAccepter["DateFinLoc"], $LocationAccepter["IdLocation"], $LocationAccepter["IdClient"], $test2["IdObjet"]);
                                echo " not inserting the accepted thing  ";
                            } else {
                                $i = 0;
                            }
                        }
                    }
                }

                // checking all anounces
                $GettingAll =  $Annonces->getAllAnnonces();
                // checking reponse admin
                $reclamations = $Annonces->reponseAdminClient($user2->id);
                foreach ($reclamations as $reclamation) {
                    if ($reclamation["ReponseReclam"] != NULL) {
                        if ($reclamation["ReclamationLu"] == "non") {
                            // compare witrh what i already have in the db
                            // echo 'wher tf am i ';

                            $i = 0;
                            foreach ($GettingNotifs as $notifs2) {
                                $notifs = (array)$notifs2;

                                if ($notifs == null) {
                                    $Annonces->insertMessgaeAdmin($reclamation["IdReclamation"], $reclamation["ReponseReclam"], $user2->id, $reclamation["ObjetReclam"]);
                                } else {
                                    // echo "wahtt";
                                }
                                if ($notifs['IDReclamation'] == $reclamation["IdReclamation"]) {
                                    $i = 1;
                                }
                            }
                            if ($i == 0) {
                                $Annonces->insertMessgaeAdmin($reclamation["IdReclamation"], $reclamation["ReponseReclam"], $user2->id, $reclamation["ObjetReclam"]);
                            } else {
                                $i = 0;
                            }

                            // ajouter a la table de notifications reponse
                        }
                    } else if ($reclamation["ReponseReclam"] == NULL && $reclamation["VueReclamationAdmin"] != "non") {
                        // compare witrh what i already have in the db
                        $i = 0;

                        foreach ($GettingNotifs as $notifs2) {

                            $notifs = (array)$notifs2;

                            if ($notifs == null) {
                                $Annonces->insertVueAdmin($reclamation["IdReclamation"], $user2->id, $reclamation["ObjetReclam"]);
                            } else {
                                // echo "wahtt";
                            }

                            if ($notifs["IDReclamation"] == $reclamation["IdReclamation"]) {
                                $i = 1;
                            }
                        }
                        if ($i == 0) {
                            $Annonces->insertVueAdmin($reclamation["IdReclamation"], $user2->id, $reclamation["ObjetReclam"]);
                        } else {
                            $i = 0;
                        }
                        // ajouter a la table de notifications  vue

                    }
                }
                // refused locations
                $Refuser = $Annonces->LocationRefuser($user2->id);
                $nomObjet = null;
                foreach ($Refuser as $REfused) {
                    foreach ($AllData as $data) {
                        $test3 = (array)$data;
                        if ($test3["IdAnnonce"] == $REfused["IDANnonce"]) {
                            $i = 0;
                            foreach ($GettingNotifs as $notifs2) {
                                $notifs = (array)$notifs2;
                                // $nomObjet = $test2[' NomObjet'];
                                if ($notifs == null) {
                                    // echo "idk";
                                    $Annonces->insertignRefused($REfused["DateDebutLoc"], $REfused["DateFinLoc"], $REfused["IdLocation"], $REfused["IdClient"], $test3["IdObjet"]);
                                } else {
                                    // echo "wahtt";
                                }
                                if ($REfused["IdLocation"] == $notifs["IDLocation"] && $REfused["IdClient"] == $notifs["IDclient"] && $test3["IdObjet"] == $notifs["IdObjet"] && $notifs["IDPartenaire"] == null) {
                                    $i = 1;
                                }
                            }
                            if ($i == 0) {
                                // echo "inserting the accepted thing  ";
                                $Annonces->insertignRefused($REfused["DateDebutLoc"], $REfused["DateFinLoc"], $REfused["IdLocation"], $REfused["IdClient"], $test3["IdObjet"]);
                                // echo " not inserting the accepted thing  ";
                            } else {
                                $i = 0;
                            }
                        }
                    }
                }
                // getting all notifications and sorting them by desc
                $allNotifsSelected = $Annonces->selectingNotifications();
                // var_dump($allNotifsSelected);
                // if ($res) {
                return view('view_Annonce', ['client' => $user2, 'allNotifsSelected' => $allNotifsSelected, 'reclamations' => $reclamations, 'AllData' => $GettingAll, "CheckNoteClient" => $CheckNoteClient, "LocationsAccepter" => $AcceptedLocations, 'user' => $user2, 'notePartenaire' => $notePartenaire, 'noteTotalObjet' => $average, 'type' => "client", "Annonce" => $annonce, "partenaire" => $user3, "avisObjet" => $res, "image" => $image['Image'], 'dates' => $dates]);
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
            $results = DB::select(' SELECT AVG(Notepartenaires) from avispartenaires where idPartenaires =:id GROUP by IdAvispartenaires ; ', ['id' => $request->id]);
            $res = json_decode(json_encode($results), true);
            $notePartenaire = $res[0];
            // checking not partenaire
            $CheckNotePartenaire = $Annonces->CheckNotePartenaire($user2->id);
            $GettingNotifs = $Annonces->SelectingNotifs();
            foreach ($CheckNotePartenaire as $data) {
                // var_dump($data);
                if ($data["IdLocation"] != null) {

                    $i = 0;
                    foreach ($GettingNotifs as $notifs2) {
                        $notifs = (array)$notifs2;
                        if ($notifs == null) {
                            // inserting not partenaire
                            $Annonces->insretingNotes($data["IdLocation"], $data["IdClient"], $user2->id);
                        } else {
                            // echo "wahtt";
                        }
                        if ($data["IdLocation"] == $notifs["IDLocation"] && $data["IdClient"] == $notifs["IDclient"] && $user2->id == $notifs["IDPartenaire"]) {
                            $i = 1;
                        }
                    }
                    if ($i == 0) {
                        $insertingNotes = $Annonces->insretingNotes($data["IdLocation"], $data["IdClient"], $user2->id);
                    } else {
                        $i = 0;
                    }
                }
            }
            // checkinh reponse admin pârtenaire
            $reclamations = $Annonces->reponseAdminPartenaire($user2->id);
            foreach ($reclamations as $reclamation) {
                if ($reclamation["ReponseReclam"] != NULL) {
                    $i = 0;
                    foreach ($GettingNotifs as $notifs2) {
                        $notifs = (array)$notifs2;

                        if ($notifs == null) {
                            $Annonces->insertMessgaeAdminPartenaire($reclamation["IdReclamation"], $reclamation["ReponseReclam"], $user2->id, $reclamation["ObjetReclam"]);
                        } else {
                            // echo "wahtt";
                        }
                        if ($notifs['IDReclamation'] == $reclamation["IdReclamation"]) {
                            $i = 1;
                        }
                    }
                    if ($i == 0) {
                        $Annonces->insertMessgaeAdminPartenaire($reclamation["IdReclamation"], $reclamation["ReponseReclam"], $user2->id, $reclamation["ObjetReclam"]);
                    } else {
                        $i = 0;
                    }
                } else if ($reclamation["ReponseReclam"] == NULL && $reclamation["VueReclamationAdmin"] != "non") {

                    $i = 0;

                    foreach ($GettingNotifs as $notifs2) {

                        $notifs = (array)$notifs2;

                        if ($notifs == null) {
                            $Annonces->insertVueAdminPartenaire($reclamation["IdReclamation"], $user2->id, $reclamation["ObjetReclam"]);
                        } else {
                            // echo "wahtt";
                        }

                        if ($notifs["IDReclamation"] == $reclamation["IdReclamation"]) {
                            $i = 1;
                        }
                    }
                    if ($i == 0) {
                        $Annonces->insertVueAdminPartenaire($reclamation["IdReclamation"], $user2->id, $reclamation["ObjetReclam"]);
                    } else {
                        $i = 0;
                    }
                }
            }
            // now we select all notifs
            $allNotifsSelected = $Annonces->selectingNotifications();


            $results100000 = DB::select('select * from location l  join clients c on c.id = l.IdClient   where l.IDPartenaire=:IDPartenaire    ', ['IDPartenaire' => $request->id]);
            $Demandes12 = json_decode(json_encode($results100000), true);
            // var_dump($Demandes12);


            // $Demandes = $Annonces->DemandesDeLocation($request->id);
            $results = DB::select('select *  from avisobjet a join clients c on a.idClients=c.id  where IdObjet   = :IdObjet   ', ['IdObjet' => $annonce['IdObjet']]);
            $res = json_decode(json_encode($results), true);
            // $idObjet = $res[0]['IdObjet'];
            // var_dump($res);
            $average = null;
            $Averagenote = DB::select('SELECT AVG(ao.NoteObjet),o.IdObjet from avisobjet ao join objet o on ao.IdObjet   = o.IdObjet  GROUP by o.IdObjet;');
            $resNote = json_decode(json_encode($Averagenote), true);
            foreach ($resNote as $avg) {
                if ($avg['IdObjet'] == $annonce['IdObjet']) {
                    $average = $avg['AVG(ao.NoteObjet)'];
                }
            }
            $user3 = Partenaire::where('id', '=', $annonce["idPartenaires"])->first();

            if ($request->accept) {
                $results = DB::select(' SELECT AVG(Noteclients) from avisclients where idClients=:id GROUP by IdAvisclients ; ', ['id' => $user2["id"]]);
                $res = json_decode(json_encode($results), true);
                if ($res) {
                    $noteclient = $res[0];
                } else {
                    $noteclient = 0;
                }
                $Annonces->AccepterDemandeLocation($request->IdLocation);

                $ClinetMail = $Annonces->GettingInfoForEmail($request->IdLocation);
                $testing = (array)$ClinetMail[0];

                // getting the start date and end date for all annonces
                $AllAnnonces = $Annonces->getALllocations($request->IdLocation, $request->id);

                foreach ($AllAnnonces as $test) {

                    if (($test["DateDebutLoc"] >= $testing["DateDebutLoc"] && $test["DateDebutLoc"] < $testing["DateFinLoc"]) || ($test["DateFinLoc"] >= $testing["DateDebutLoc"] && $test["DateFinLoc"] < $testing["DateFinLoc"]) || ($test["DateDebutLoc"] < $testing["DateDebutLoc"] && $test["DateFinLoc"] > $testing["DateFinLoc"])) {
                        $AllAnnonces = $Annonces->RefuserDemandeLocation($test["IdLocation"]);
                    }
                }
                // change status to refuser l'annonce

                // getting objet
                $ObjetMil = $Annonces->GettingTheObjetFormMAil($testing['IDANnonce']);
                // var_dump($ObjetMil[" NomObjet"]);
                $testing2 = $ObjetMil[" NomObjet"];
                // var_dump($testing2);
                Mail::to("tbestt4@gmail.com")->send(new InfoClient($testing["NomClint"], $testing["PrenomClient"], $testing["UsernameClient"], $testing["EmailClient"], $testing2, $testing["DateDebutLoc"], $testing["DateFinLoc"], $testing["Tel"], $testing["Adresse"], $noteclient));
                // return view('view_Annonce', ['user' => $user2, 'type' => "partenaire", "Annonce" => $annonce, "partenaire" => $user3, "avisObjet" => $res, "image" => $image['Image'], 'Demandes' => $Demandes]);
            }
            if ($request->decline) {
                // echo 'loser gang';
                $Annonces->RefuserDemandeLocation($request->IdLocation);
                $Annonces->RefuserDemandeLocation($request->IdLocation);
                // average note partenaire
                $results = DB::select(' SELECT AVG(Notepartenaires) from avispartenaires where idPartenaires =:id GROUP by IdAvispartenaires ; ', ['id' => $user2->id]);
                $res = json_decode(json_encode($results), true);
                $notePartenaire = $res[0];
                // return back();
                return view('view_Annonce', ['user' => $user2, 'allNotifsSelected' => $allNotifsSelected, 'noteTotalObjet' => $average, 'notePartenaire' => $notePartenaire, 'type' => "partenaire", "Annonce" => $annonce, "partenaire" => $user3, "avisObjet" => $res, "image" => $image['Image'], 'Demandes' => $Demandes12]);
            }

            return view('view_Annonce', ['user' => $user2, 'allNotifsSelected' => $allNotifsSelected, "CheckNotePartenaire" => $CheckNotePartenaire, 'reclamations' => $reclamations, 'noteTotalObjet' => $average, 'notePartenaire' => $notePartenaire, 'type' => "partenaire", "Annonce" => $annonce, "partenaire" => $user3, "avisObjet" => $res, "image" => $image['Image'], 'Demandes' => $Demandes12]);
        } else {
            echo "problem";
            // return view('view_Annonce');
        }
    }

    public function profile(Request $req)
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
            'CommentaireClient' => 'nullable',
            'IDObjet' => 'nullable',
            'IDPartenaire' => 'nullable',
            "IDClient" => 'nullable',
            "Ville" => "nullable",
            "Adresse" => "nullable",
            "Tel" => "nullable",
            "fichier" => "nullable",
        ]);
        if (isset($req->fichier)) {
            // $temp = file_get_contents($req->fichier);
            // $blob = base64_encode($temp);
            $file = request()->file('fichier');
            $imagedata = file_get_contents($file->getRealPath());
            $base64 = base64_encode($imagedata);
        }

        if ($req->type == "client") {

            if ($req->Tel) {
                $results = DB::select('UPDATE clients set Tel=:Tel where id  =:id   ', ['Tel' => $req->Tel, 'id' => $req->id]);
            }
            if ($req->Adresse) {
                $results = DB::select('UPDATE clients set Adresse=:Adresse where id  =:id   ', ['Adresse' => $req->Adresse, 'id' => $req->id]);
            }
            if ($req->Ville) {
                $results = DB::select('UPDATE clients set Ville=:Ville where id  =:id   ', ['Ville' => $req->Ville, 'id' => $req->id]);
            }
            if ($req->fichier) {
                $results = DB::select('UPDATE clients set ImageClient=:ImageClient where id  =:id   ', ['ImageClient' => $imagedata, 'id' => $req->id]);
            }
            $user2 = Client::where('id', '=', $req->id)->first();
            $ClientNotif =  new User();
            // functions
            // repsonse admin
            $reclamations = $ClientNotif->reponseAdminClient($user2->id);
            $Annonces = new User();
            $GettingNotifs = $Annonces->SelectingNotifs();

            foreach ($reclamations as $reclamation) {
                if ($reclamation["ReponseReclam"] != NULL) {
                    if ($reclamation["ReclamationLu"] == "non") {
                        // compare witrh what i already have in the db
                        // echo 'wher tf am i ';

                        $i = 0;
                        foreach ($GettingNotifs as $notifs2) {
                            $notifs = (array)$notifs2;

                            if ($notifs == null) {
                                $Annonces->insertMessgaeAdmin($reclamation["IdReclamation"], $reclamation["ReponseReclam"], $user2->id, $reclamation["ObjetReclam"]);
                            } else {
                                // echo "wahtt";
                            }
                            if ($notifs['IDReclamation'] == $reclamation["IdReclamation"]) {
                                $i = 1;
                            }
                        }
                        if ($i == 0) {
                            $Annonces->insertMessgaeAdmin($reclamation["IdReclamation"], $reclamation["ReponseReclam"], $user2->id, $reclamation["ObjetReclam"]);
                        } else {
                            $i = 0;
                        }

                        // ajouter a la table de notifications reponse
                    }
                } else if ($reclamation["ReponseReclam"] == NULL && $reclamation["VueReclamationAdmin"] != "non") {
                    // compare witrh what i already have in the db
                    $i = 0;

                    foreach ($GettingNotifs as $notifs2) {

                        $notifs = (array)$notifs2;

                        if ($notifs == null) {
                            $Annonces->insertVueAdmin($reclamation["IdReclamation"], $user2->id, $reclamation["ObjetReclam"]);
                        } else {
                            // echo "wahtt";
                        }

                        if ($notifs["IDReclamation"] == $reclamation["IdReclamation"]) {
                            $i = 1;
                        }
                    }
                    if ($i == 0) {
                        $Annonces->insertVueAdmin($reclamation["IdReclamation"], $user2->id, $reclamation["ObjetReclam"]);
                    } else {
                        $i = 0;
                    }
                    // ajouter a la table de notifications  vue
                }
            }
            // getting all announces
            $GettingAll =  $ClientNotif->getAllAnnonces();
            $AllData = $Annonces->checkingAllAnnnonces();

            // checking note
            $CheckNoteClient = $ClientNotif->CheckNoteClient($user2->id);
            foreach ($CheckNoteClient as $data) {
                if ($data["IdLocation"] != null) {

                    $i = 0;
                    foreach ($GettingNotifs as $notifs2) {
                        $notifs = (array)$notifs2;
                        if ($notifs == null) {
                            $Annonces->insretingNotes($data["IdLocation"], $data["IdClient"], $data["IDPartenaire"]);
                        } else {
                            // echo "wahtt";
                        }
                        if ($data["IdLocation"] == $notifs["IDLocation"] && $data["IdClient"] == $notifs["IDclient"] && $data["IDPartenaire"] == $notifs["IDPartenaire"]) {
                            $i = 1;
                        }
                    }
                    if ($i == 0) {
                        $insertingNotes = $Annonces->insretingNotes($data["IdLocation"], $data["IdClient"], $data["IDPartenaire"]);
                    } else {
                        $i = 0;
                    }
                    // else {
                    //     echo "here2aybe";
                    //     $AnnoncesPremium->insretingNotes($data["IdLocation"], $data["IdClient"], $data["IDPartenaire"]);
                    // }
                }
            }
            // location accepter
            $AcceptedLocations = $ClientNotif->LocationAccepterNotifs($user2->id);
            foreach ($AcceptedLocations as $LocationAccepter) {
                foreach ($AllData as $data) {
                    $test2 = (array)$data;
                    // var_dump($test2);
                    if ($test2["IdAnnonce"] == $LocationAccepter["IDANnonce"]) {
                        $i = 0;
                        foreach ($GettingNotifs as $notifs2) {
                            $notifs = (array)$notifs2;
                            // $nomObjet = $test2[' NomObjet'];
                            if ($notifs == null) {
                                echo "idk";
                                $Annonces->insertignAccepted($LocationAccepter["DateDebutLoc"], $LocationAccepter["DateFinLoc"], $LocationAccepter["IdLocation"], $LocationAccepter["IdClient"], $test2["IdObjet"]);
                            } else {
                                // echo "wahtt";
                            }
                            if ($LocationAccepter["IdLocation"] == $notifs["IDLocation"] && $LocationAccepter["IdClient"] == $notifs["IDclient"] && $test2["IdObjet"] == $notifs["IdObjet"] && $notifs["IDPartenaire"] == null) {
                                $i = 1;
                            }
                        }
                        if ($i == 0) {
                            echo "inserting the accepted thing  ";
                            $Annonces->insertignAccepted($LocationAccepter["DateDebutLoc"], $LocationAccepter["DateFinLoc"], $LocationAccepter["IdLocation"], $LocationAccepter["IdClient"], $test2["IdObjet"]);
                            echo " not inserting the accepted thing  ";
                        } else {
                            $i = 0;
                        }
                    }
                }
            }
            // location refuser
            $REfused = $ClientNotif->LocationRefuser($user2->id);
            foreach ($REfused as $REfused) {
                foreach ($AllData as $data) {
                    $test3 = (array)$data;
                    if ($test3["IdAnnonce"] == $REfused["IDANnonce"]) {
                        $i = 0;
                        foreach ($GettingNotifs as $notifs2) {
                            $notifs = (array)$notifs2;
                            // $nomObjet = $test2[' NomObjet'];
                            if ($notifs == null) {
                                // echo "idk";
                                $Annonces->insertignRefused($REfused["DateDebutLoc"], $REfused["DateFinLoc"], $REfused["IdLocation"], $REfused["IdClient"], $test3["IdObjet"]);
                            } else {
                                // echo "wahtt";
                            }
                            if ($REfused["IdLocation"] == $notifs["IDLocation"] && $REfused["IdClient"] == $notifs["IDclient"] && $test3["IdObjet"] == $notifs["IdObjet"] && $notifs["IDPartenaire"] == null) {
                                $i = 1;
                            }
                        }
                        if ($i == 0) {
                            // echo "inserting the accepted thing  ";
                            $Annonces->insertignRefused($REfused["DateDebutLoc"], $REfused["DateFinLoc"], $REfused["IdLocation"], $REfused["IdClient"], $test3["IdObjet"]);
                            // echo " not inserting the accepted thing  ";
                        } else {
                            $i = 0;
                        }
                    }
                }
            }

            $results = DB::select('select *  from clients where  id=:id  ', ['id' => $req->id]);
            // $res = json_decode(json_encode($results), true);
            $res = (array)$results[0];
            $infoClient = $res;
            // var_dump($infoClient);
            // $profile
            $results = DB::select(' SELECT AVG(Noteclients) from avisclients where idClients=:id GROUP by IdAvisclients ; ', ['id' => $req->id]);
            $res = json_decode(json_encode($results), true);
            $noteclient = $res[0];
            // var_dump($noteclient);
            $CheckNoteClient = $ClientNotif->CheckNoteClient($user2->id);
            $AcceptedLocations = $ClientNotif->LocationAccepterNotifs($user2->id);
            $GettingAll =  $ClientNotif->getAllAnnonces();
            $reclamations = $ClientNotif->reponseAdminClient($user2->id);
            // getting acis clients
            $avisClient = $ClientNotif->avisClient($user2->id);
            // var_dump($avisClient);
            // check if this annonce is demandeed to be located
            $checkIflocated = $Annonces->checkifdemanded($user2->id);
            // rest
            // getting all notifications and sorting them by desc
            $allNotifsSelected = $Annonces->selectingNotifications();
            // var_dump($allNotifsSelected);
            return view('Profil', ['client' => $user2, 'allNotifsSelected' => $allNotifsSelected, 'checkIflocated' => $checkIflocated, 'avisClient' => $avisClient, 'id' => $req->id, "ProfileClient" => $infoClient, "NoteClient" => $noteclient, 'type' => "client", 'profile' => $user2, 'CheckNoteClient' => $CheckNoteClient, 'AllData' => $GettingAll,  'reclamations' => $reclamations, 'LocationsAccepter' => $AcceptedLocations]);
            // get nom Partenaire
        } else if ($req->type == "partenaire") {

            if ($req->Tel) {
                $results = DB::select('UPDATE partenaires set TelPartenaire=:TelPartenaire where id  =:id   ', ['TelPartenaire' => $req->Tel, 'id' => $req->id]);
            }
            if ($req->Adresse) {
                $results = DB::select('UPDATE partenaires set AdressePartenaire=:AdressePartenaire where id  =:id   ', ['AdressePartenaire' => $req->Adresse, 'id' => $req->id]);
            }
            if ($req->Ville) {
                $results = DB::select('UPDATE partenaires set Ville=:Ville where id  =:id   ', ['Ville' => $req->Ville, 'id' => $req->id]);
            }
            if ($req->fichier) {
                $results = DB::select('UPDATE partenaires set ImagePartenaire=:ImagePartenaire where id  =:id   ', ['ImagePartenaire' => $imagedata, 'id' => $req->id]);
            }
            // notification end of location client
            $user2 = Partenaire::where('id', '=', $req->id)->first();
            $Annonces = new User();
            $CheckNotePartenaire = $Annonces->CheckNotePartenaire($user2->id);
            $GettingNotifs = $Annonces->SelectingNotifs();
            foreach ($CheckNotePartenaire as $data) {
                // var_dump($data);
                if ($data["IdLocation"] != null) {

                    $i = 0;
                    foreach ($GettingNotifs as $notifs2) {
                        $notifs = (array)$notifs2;
                        if ($notifs == null) {
                            // inserting not partenaire
                            $Annonces->insretingNotes($data["IdLocation"], $data["IdClient"], $user2->id);
                        } else {
                            // echo "wahtt";
                        }
                        if ($data["IdLocation"] == $notifs["IDLocation"] && $data["IdClient"] == $notifs["IDclient"] && $user2->id == $notifs["IDPartenaire"]) {
                            $i = 1;
                        }
                    }
                    if ($i == 0) {
                        $insertingNotes = $Annonces->insretingNotes($data["IdLocation"], $data["IdClient"], $user2->id);
                    } else {
                        $i = 0;
                    }
                }
            }
            // first try partenaire
            $ClientNotif =  new User();
            $reclamations = $ClientNotif->reponseAdminPartenaire($user2->id);
            foreach ($reclamations as $reclamation) {
                if ($reclamation["ReponseReclam"] != NULL) {
                    $i = 0;
                    foreach ($GettingNotifs as $notifs2) {
                        $notifs = (array)$notifs2;

                        if ($notifs == null) {
                            $Annonces->insertMessgaeAdminPartenaire($reclamation["IdReclamation"], $reclamation["ReponseReclam"], $user2->id, $reclamation["ObjetReclam"]);
                        } else {
                            // echo "wahtt";
                        }
                        if ($notifs['IDReclamation'] == $reclamation["IdReclamation"]) {
                            $i = 1;
                        }
                    }
                    if ($i == 0) {
                        $Annonces->insertMessgaeAdminPartenaire($reclamation["IdReclamation"], $reclamation["ReponseReclam"], $user2->id, $reclamation["ObjetReclam"]);
                    } else {
                        $i = 0;
                    }
                } else if ($reclamation["ReponseReclam"] == NULL && $reclamation["VueReclamationAdmin"] != "non") {

                    $i = 0;

                    foreach ($GettingNotifs as $notifs2) {

                        $notifs = (array)$notifs2;

                        if ($notifs == null) {
                            $Annonces->insertVueAdminPartenaire($reclamation["IdReclamation"], $user2->id, $reclamation["ObjetReclam"]);
                        } else {
                            // echo "wahtt";
                        }

                        if ($notifs["IDReclamation"] == $reclamation["IdReclamation"]) {
                            $i = 1;
                        }
                    }
                    if ($i == 0) {
                        $Annonces->insertVueAdminPartenaire($reclamation["IdReclamation"], $user2->id, $reclamation["ObjetReclam"]);
                    } else {
                        $i = 0;
                    }
                }
            }
            // var_dump($reclamations);
            $results = DB::select('select *  from partenaires where  id=:id  ', ['id' => $req->id]);
            // var_dump($results);
            $res = (array)$results[0];
            $infoPartenaire = $res;
            // var_dump($infoPartenaire);
            // $profile
            $results = DB::select(' SELECT AVG(Notepartenaires) from avispartenaires where idPartenaires =:id GROUP by IdAvispartenaires ; ', ['id' => $req->id]);
            $res = json_decode(json_encode($results), true);
            $notePartenaire = $res[0];
            // var_dump($notePartenaire);
            $avisPartenaire = $ClientNotif->avisPartenaires2($req->id);
            $allNotifsSelected = $Annonces->selectingNotifications();

            return view('Profil', ["partenaire" => $user2, 'allNotifsSelected' => $allNotifsSelected, 'avisPartenaire' => $avisPartenaire, 'CheckNotePartenaire' => $CheckNotePartenaire, 'id' => $req->id, "ProfilePartenaire" => $infoPartenaire, "NotePartenaire" => $notePartenaire, 'type' => "partenaire", 'reclamations' => $reclamations]);
        }



        // $res = DB::select(" select * from clients where id = 1 ");

        // foreach ($res as $e) {
        //     $data = $e;
        // }

        // return view('Profil', ['data' => $data]);
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
            'CommentaireClient' => 'nullable',
            'IDObjet' => 'nullable',
            'IDPartenaire' => 'nullable',
            "IDClient" => 'nullable',


        ]);
        if ($req->type == "client") {
            $user2 = Client::where('id', '=', $req->id)->first();
            // DB::INSERT('insert into avispartenaires (Notepartenaires, Commentairepartenaires, idClients, positif, idPartenaires) VALUES (?,?,?,?,?)', [$req->get("notepartenaire"), $req->get("Commentaire"), "1", "1", "1"]);
            // DB::INSERT('insert into avisobjet (CommentaireObjet, NoteObjet, idClients , IdObjet , positif) VALUES (?,?,?,?,?)', [$req->get("Commentaire"), $req->get("noteobjet"), "1", "1", "1"]);
            if ($req->idLocation && !$req->CommentairePartenaire) {
                $user = new User();
                $Informations = $user->getInfoLocation($req->idLocation);
                $Information = $Informations[0];
                // var_dump($Information);
                $InfoObjet = $user->GettingTheObjetFormMAil($Information['IDANnonce']);
                $Info1 = $InfoObjet;
                // $Info1 = $InfoObjet[0];
                // var_dump($Info1);


                $InfoPartenaire = $user->getPartenaireInfo($Information['IDPartenaire']);
                $Info2 = (array)$InfoPartenaire[0];
                // echo 'infoPartenaire';
                // var_dump($Info2);
                // echo 'infoPartenaire';


                $Annonces =  new User();

                $CheckNoteClient = $Annonces->CheckNoteClient($user2->id);
                $GettingNotifs = $Annonces->SelectingNotifs();

                foreach ($CheckNoteClient as $data) {
                    if ($data["IdLocation"] != null) {

                        $i = 0;
                        foreach ($GettingNotifs as $notifs2) {
                            $notifs = (array)$notifs2;
                            if ($notifs == null) {
                                $Annonces->insretingNotes($data["IdLocation"], $data["IdClient"], $data["IDPartenaire"]);
                            } else {
                                // echo "wahtt";
                            }
                            if ($data["IdLocation"] == $notifs["IDLocation"] && $data["IdClient"] == $notifs["IDclient"] && $data["IDPartenaire"] == $notifs["IDPartenaire"]) {
                                $i = 1;
                            }
                        }
                        if ($i == 0) {
                            $insertingNotes = $Annonces->insretingNotes($data["IdLocation"], $data["IdClient"], $data["IDPartenaire"]);
                        } else {
                            $i = 0;
                        }
                        // else {
                        //     echo "here2aybe";
                        //     $AnnoncesPremium->insretingNotes($data["IdLocation"], $data["IdClient"], $data["IDPartenaire"]);
                        // }
                    }
                }
                $AllData = $Annonces->checkingAllAnnnonces();
                $AcceptedLocations = $Annonces->LocationAccepterNotifs($user2->id);
                foreach ($AcceptedLocations as $LocationAccepter) {
                    foreach ($AllData as $data) {
                        $test2 = (array)$data;
                        // var_dump($test2);
                        if ($test2["IdAnnonce"] == $LocationAccepter["IDANnonce"]) {
                            $i = 0;
                            foreach ($GettingNotifs as $notifs2) {
                                $notifs = (array)$notifs2;
                                // $nomObjet = $test2[' NomObjet'];
                                if ($notifs == null) {
                                    echo "idk";
                                    $Annonces->insertignAccepted($LocationAccepter["DateDebutLoc"], $LocationAccepter["DateFinLoc"], $LocationAccepter["IdLocation"], $LocationAccepter["IdClient"], $test2["IdObjet"]);
                                } else {
                                    // echo "wahtt";
                                }
                                if ($LocationAccepter["IdLocation"] == $notifs["IDLocation"] && $LocationAccepter["IdClient"] == $notifs["IDclient"] && $test2["IdObjet"] == $notifs["IdObjet"] && $notifs["IDPartenaire"] == null) {
                                    $i = 1;
                                }
                            }
                            if ($i == 0) {
                                echo "inserting the accepted thing  ";
                                $Annonces->insertignAccepted($LocationAccepter["DateDebutLoc"], $LocationAccepter["DateFinLoc"], $LocationAccepter["IdLocation"], $LocationAccepter["IdClient"], $test2["IdObjet"]);
                                echo " not inserting the accepted thing  ";
                            } else {
                                $i = 0;
                            }
                        }
                    }
                }
                $GettingAll =  $Annonces->getAllAnnonces();
                // checking reponse admin
                $reclamations = $Annonces->reponseAdminClient($user2->id);
                foreach ($reclamations as $reclamation) {
                    if ($reclamation["ReponseReclam"] != NULL) {
                        if ($reclamation["ReclamationLu"] == "non") {
                            // compare witrh what i already have in the db
                            // echo 'wher tf am i ';

                            $i = 0;
                            foreach ($GettingNotifs as $notifs2) {
                                $notifs = (array)$notifs2;

                                if ($notifs == null) {
                                    $Annonces->insertMessgaeAdmin($reclamation["IdReclamation"], $reclamation["ReponseReclam"], $user2->id, $reclamation["ObjetReclam"]);
                                } else {
                                    // echo "wahtt";
                                }
                                if ($notifs['IDReclamation'] == $reclamation["IdReclamation"]) {
                                    $i = 1;
                                }
                            }
                            if ($i == 0) {
                                $Annonces->insertMessgaeAdmin($reclamation["IdReclamation"], $reclamation["ReponseReclam"], $user2->id, $reclamation["ObjetReclam"]);
                            } else {
                                $i = 0;
                            }

                            // ajouter a la table de notifications reponse
                        }
                    } else if ($reclamation["ReponseReclam"] == NULL && $reclamation["VueReclamationAdmin"] != "non") {
                        // compare witrh what i already have in the db
                        $i = 0;

                        foreach ($GettingNotifs as $notifs2) {

                            $notifs = (array)$notifs2;

                            if ($notifs == null) {
                                $Annonces->insertVueAdmin($reclamation["IdReclamation"], $user2->id, $reclamation["ObjetReclam"]);
                            } else {
                                // echo "wahtt";
                            }

                            if ($notifs["IDReclamation"] == $reclamation["IdReclamation"]) {
                                $i = 1;
                            }
                        }
                        if ($i == 0) {
                            $Annonces->insertVueAdmin($reclamation["IdReclamation"], $user2->id, $reclamation["ObjetReclam"]);
                        } else {
                            $i = 0;
                        }
                        // ajouter a la table de notifications  vue

                    }
                }

                $Refuser = $Annonces->LocationRefuser($user2->id);
                $nomObjet = null;
                foreach ($Refuser as $REfused) {
                    foreach ($AllData as $data) {
                        $test3 = (array)$data;
                        if ($test3["IdAnnonce"] == $REfused["IDANnonce"]) {
                            $i = 0;
                            foreach ($GettingNotifs as $notifs2) {
                                $notifs = (array)$notifs2;
                                // $nomObjet = $test2[' NomObjet'];
                                if ($notifs == null) {
                                    // echo "idk";
                                    $Annonces->insertignRefused($REfused["DateDebutLoc"], $REfused["DateFinLoc"], $REfused["IdLocation"], $REfused["IdClient"], $test3["IdObjet"]);
                                } else {
                                    // echo "wahtt";
                                }
                                if ($REfused["IdLocation"] == $notifs["IDLocation"] && $REfused["IdClient"] == $notifs["IDclient"] && $test3["IdObjet"] == $notifs["IdObjet"] && $notifs["IDPartenaire"] == null) {
                                    $i = 1;
                                }
                            }
                            if ($i == 0) {
                                // echo "inserting the accepted thing  ";
                                $Annonces->insertignRefused($REfused["DateDebutLoc"], $REfused["DateFinLoc"], $REfused["IdLocation"], $REfused["IdClient"], $test3["IdObjet"]);
                                // echo " not inserting the accepted thing  ";
                            } else {
                                $i = 0;
                            }
                        }
                    }
                }
                $allNotifsSelected = $Annonces->selectingNotifications();


                // var_dump($Info2);
                // get Objet
                return view('Notes', ['client' => $user2, 'id' => $req->id, 'allNotifsSelected' => $allNotifsSelected,  'Objet' => $Info1, 'LePartenaire' => $Info2, 'idLocation' => $req->idLocation, 'type' => "client"]);
                // get nom Partenaire
            } else {
                if ($req->CommentairePartenaire) {


                    $positifObjet = null;
                    $positifClient = null;
                    if ($req->noteobjet < 3) {
                        $positifObjet = "non";
                    } else {
                        $positifObjet = "oui";
                    }
                    if ($req->notepartenaire < 3) {
                        $positifClient = "non";
                    } else {
                        $positifClient = "oui";
                    }
                    $todaysDate = date_create(date("Y-m-d"));
                    DB::INSERT('insert into avisobjet ( CommentaireObjet, NoteObjet, DateAvisObjet ,idClients ,IdObjet,positif) VALUES (?,?,?,?,?,?)', [$req->CommentaireObjet, $req->noteobjet, $todaysDate, $req->id, $req->IDObjet, $positifObjet]);
                    DB::INSERT('insert into avispartenaires ( Notepartenaires, Commentairepartenaires, DateAvispartenaires ,idClients ,positif ,idPartenaires ) VALUES (?,?,?,?,?,?)', [$req->notepartenaire, $req->CommentairePartenaire, $todaysDate, $req->id, $positifClient, $req->IDPartenaire]);
                    // update location
                    $results = DB::select('UPDATE location set Note=:Note where IdLocation  =:IdLocation   ', ['Note' => "oui", 'IdLocation' => $req->idLocation]);
                    // if ($results) {
                    //     echo "sucecs";
                    // }
                    // return to the acceuil please
                    // return view('Notes', ['id' => $req->id, 'idLocation' => $req->idLocation, 'type' => "client"]);
                } else {
                    return view('Notes', ['client' => $user2, 'id' => $req->id, 'idLocation' => $req->idLocation, 'type' => "client"]);
                }
            }
        } else if ($req->type == "partenaire") {
            // notification end of location client
            $user2 = Partenaire::where('id', '=', $req->id)->first();
            // first try partenaire
            if ($req->idLocation && !$req->CommentaireClient) {
                $PartenaireUser = new User();
                $Informations = $PartenaireUser->getInfoLocation($req->idLocation);
                $Information = $Informations[0];
                // var_dump($Information);
                $InfoObjet = $PartenaireUser->GettingTheObjetFormMAil($Information['IDANnonce']);
                $Info1 = $InfoObjet;
                // var_dump($Info1);
                $InfoClient = $PartenaireUser->getClientInfo($Information['IdClient']);
                $Info2 = $InfoClient[0];
                $Annonces = new User();
                $CheckNotePartenaire = $Annonces->CheckNotePartenaire($user2->id);
                $GettingNotifs = $Annonces->SelectingNotifs();
                foreach ($CheckNotePartenaire as $data) {
                    // var_dump($data);
                    if ($data["IdLocation"] != null) {

                        $i = 0;
                        foreach ($GettingNotifs as $notifs2) {
                            $notifs = (array)$notifs2;
                            if ($notifs == null) {
                                // inserting not partenaire
                                $Annonces->insretingNotes($data["IdLocation"], $data["IdClient"], $user2->id);
                            } else {
                                // echo "wahtt";
                            }
                            if ($data["IdLocation"] == $notifs["IDLocation"] && $data["IdClient"] == $notifs["IDclient"] && $user2->id == $notifs["IDPartenaire"]) {
                                $i = 1;
                            }
                        }
                        if ($i == 0) {
                            $insertingNotes = $Annonces->insretingNotes($data["IdLocation"], $data["IdClient"], $user2->id);
                        } else {
                            $i = 0;
                        }
                    }
                }
                $reclamations = $Annonces->reponseAdminPartenaire($user2->id);
                foreach ($reclamations as $reclamation) {
                    if ($reclamation["ReponseReclam"] != NULL) {
                        $i = 0;
                        foreach ($GettingNotifs as $notifs2) {
                            $notifs = (array)$notifs2;

                            if ($notifs == null) {
                                $Annonces->insertMessgaeAdminPartenaire($reclamation["IdReclamation"], $reclamation["ReponseReclam"], $user2->id, $reclamation["ObjetReclam"]);
                            } else {
                                // echo "wahtt";
                            }
                            if ($notifs['IDReclamation'] == $reclamation["IdReclamation"]) {
                                $i = 1;
                            }
                        }
                        if ($i == 0) {
                            $Annonces->insertMessgaeAdminPartenaire($reclamation["IdReclamation"], $reclamation["ReponseReclam"], $user2->id, $reclamation["ObjetReclam"]);
                        } else {
                            $i = 0;
                        }
                    } else if ($reclamation["ReponseReclam"] == NULL && $reclamation["VueReclamationAdmin"] != "non") {

                        $i = 0;

                        foreach ($GettingNotifs as $notifs2) {

                            $notifs = (array)$notifs2;

                            if ($notifs == null) {
                                $Annonces->insertVueAdminPartenaire($reclamation["IdReclamation"], $user2->id, $reclamation["ObjetReclam"]);
                            } else {
                                // echo "wahtt";
                            }

                            if ($notifs["IDReclamation"] == $reclamation["IdReclamation"]) {
                                $i = 1;
                            }
                        }
                        if ($i == 0) {
                            $Annonces->insertVueAdminPartenaire($reclamation["IdReclamation"], $user2->id, $reclamation["ObjetReclam"]);
                        } else {
                            $i = 0;
                        }
                    }
                }
                $allNotifsSelected = $Annonces->selectingNotifications();

                // var_dump($Info2);
                // get Objet
                return view('Notes', ['partenaire' => $user2, 'user' => $user2, 'id' => $req->id, 'Objet' => $Info1, 'allNotifsSelected' => $allNotifsSelected, 'LeClient' => $Info2, 'idLocation' => $req->idLocation, 'type' => "partenaire"]);
                // get nom Partenaire
            } else {
                // echo $req->CommentairePartenaire;
                // echo $req->CommentaireObjet;
                // echo $req->notepartenaire;
                // echo $req->noteobjet;
                $positifPartenaire = null;

                if ($req->notepartenaire < 3) {
                    $positifPartenaire = "non";
                } else {
                    $positifPartenaire = "oui";
                }
                $todaysDate = date_create(date("Y-m-d"));
                // echo "????";
                // echo  $req->IDClient;
                // echo "????";

                DB::INSERT('insert into avisclients ( Noteclients, Commentaireclients, DateAvisclients ,idPartenaires  ,positif ,idClients  ) VALUES (?,?,?,?,?,?)', [$req->noteClient, $req->CommentaireClient, $todaysDate, $req->id, $positifPartenaire, $req->IDClient]);
                // update location
                $results = DB::select('UPDATE location set NotePartenaire=:NotePartenaire where IdLocation  =:IdLocation   ', ['NotePartenaire' => "oui", 'IdLocation' => $req->idLocation]);

                $NewUser = new User();
                $CheckNotePartenaire = $NewUser->CheckNotePartenaire($user2->id);
                $reclamations = $NewUser->reponseAdminPartenaire($user2->id);
                $AnnoncesPremium =  new User();
                $annonces =  $AnnoncesPremium->getAnnoncesPremium();
                $villes =  $AnnoncesPremium->getVille();
                $ville = json_decode(json_encode($villes), true);
                $categories =  $AnnoncesPremium->getCategorie();
                // next
                $categorie = json_decode(json_encode($categories), true);
                // var_dump($reclamations);
                $allNotifsSelected = $AnnoncesPremium->selectingNotifications();

                return view('view_Acceuil', ['partenaire' => $user2, 'allNotifsSelected' => $allNotifsSelected, 'CheckNotePartenaire' => $CheckNotePartenaire, 'annonces' => $annonces, 'villes' => $ville, 'categories' => $categorie, 'reclamations' => $reclamations]);
                // return to the acceuil please
                // echo "iKD maybe inserted";
                // return view('Notes', ['id' => $req->id, 'idLocation' => $req->idLocation, 'type' => "client"]);
            }
            //  DB::INSERT('insert into avispartenaires (Notepartenaires, Commentairepartenaires, idClients, positif, idPartenaires) VALUES (?,?,?,?,?)', [$req->get("notepartenaire"), $req->get("Commentaire"), "1", "1", "1"]);
            //  DB::INSERT('insert into avisobjet (CommentaireObjet, NoteObjet, idClients , IdObjet , positif) VALUES (?,?,?,?,?)', [$req->get("Commentaire"), $req->get("noteobjet"), "1", "1", "1"]);
            // return view('Notes', ['id' => $req->id, 'idLocation' => $req->idLocation, 'type' => "partenaire"]);
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
        $Annonces =  new User();

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
            // again
            $CheckNoteClient = $Annonces->CheckNoteClient($user2->id);
            $GettingNotifs = $Annonces->SelectingNotifs();

            foreach ($CheckNoteClient as $data) {
                if ($data["IdLocation"] != null) {

                    $i = 0;
                    foreach ($GettingNotifs as $notifs2) {
                        $notifs = (array)$notifs2;
                        if ($notifs == null) {
                            $Annonces->insretingNotes($data["IdLocation"], $data["IdClient"], $data["IDPartenaire"]);
                        } else {
                            // echo "wahtt";
                        }
                        if ($data["IdLocation"] == $notifs["IDLocation"] && $data["IdClient"] == $notifs["IDclient"] && $data["IDPartenaire"] == $notifs["IDPartenaire"]) {
                            $i = 1;
                        }
                    }
                    if ($i == 0) {
                        $insertingNotes = $Annonces->insretingNotes($data["IdLocation"], $data["IdClient"], $data["IDPartenaire"]);
                    } else {
                        $i = 0;
                    }
                    // else {
                    //     echo "here2aybe";
                    //     $AnnoncesPremium->insretingNotes($data["IdLocation"], $data["IdClient"], $data["IDPartenaire"]);
                    // }
                }
            }
            $AllData = $Annonces->checkingAllAnnnonces();

            // seeig the locations accepted
            $AcceptedLocations = $Annonces->LocationAccepterNotifs($user2->id);
            foreach ($AcceptedLocations as $LocationAccepter) {
                foreach ($AllData as $data) {
                    $test2 = (array)$data;
                    // var_dump($test2);
                    if ($test2["IdAnnonce"] == $LocationAccepter["IDANnonce"]) {
                        $i = 0;
                        foreach ($GettingNotifs as $notifs2) {
                            $notifs = (array)$notifs2;
                            // $nomObjet = $test2[' NomObjet'];
                            if ($notifs == null) {
                                echo "idk";
                                $Annonces->insertignAccepted($LocationAccepter["DateDebutLoc"], $LocationAccepter["DateFinLoc"], $LocationAccepter["IdLocation"], $LocationAccepter["IdClient"], $test2["IdObjet"]);
                            } else {
                                // echo "wahtt";
                            }
                            if ($LocationAccepter["IdLocation"] == $notifs["IDLocation"] && $LocationAccepter["IdClient"] == $notifs["IDclient"] && $test2["IdObjet"] == $notifs["IdObjet"] && $notifs["IDPartenaire"] == null) {
                                $i = 1;
                            }
                        }
                        if ($i == 0) {
                            echo "inserting the accepted thing  ";
                            $Annonces->insertignAccepted($LocationAccepter["DateDebutLoc"], $LocationAccepter["DateFinLoc"], $LocationAccepter["IdLocation"], $LocationAccepter["IdClient"], $test2["IdObjet"]);
                            echo " not inserting the accepted thing  ";
                        } else {
                            $i = 0;
                        }
                    }
                }
            }

            // checking all anounces
            $GettingAll =  $Annonces->getAllAnnonces();
            // checking reponse admin
            $reclamations = $Annonces->reponseAdminClient($user2->id);
            foreach ($reclamations as $reclamation) {
                if ($reclamation["ReponseReclam"] != NULL) {
                    if ($reclamation["ReclamationLu"] == "non") {
                        // compare witrh what i already have in the db
                        // echo 'wher tf am i ';

                        $i = 0;
                        foreach ($GettingNotifs as $notifs2) {
                            $notifs = (array)$notifs2;

                            if ($notifs == null) {
                                $Annonces->insertMessgaeAdmin($reclamation["IdReclamation"], $reclamation["ReponseReclam"], $user2->id, $reclamation["ObjetReclam"]);
                            } else {
                                // echo "wahtt";
                            }
                            if ($notifs['IDReclamation'] == $reclamation["IdReclamation"]) {
                                $i = 1;
                            }
                        }
                        if ($i == 0) {
                            $Annonces->insertMessgaeAdmin($reclamation["IdReclamation"], $reclamation["ReponseReclam"], $user2->id, $reclamation["ObjetReclam"]);
                        } else {
                            $i = 0;
                        }

                        // ajouter a la table de notifications reponse
                    }
                } else if ($reclamation["ReponseReclam"] == NULL && $reclamation["VueReclamationAdmin"] != "non") {
                    // compare witrh what i already have in the db
                    $i = 0;

                    foreach ($GettingNotifs as $notifs2) {

                        $notifs = (array)$notifs2;

                        if ($notifs == null) {
                            $Annonces->insertVueAdmin($reclamation["IdReclamation"], $user2->id, $reclamation["ObjetReclam"]);
                        } else {
                            // echo "wahtt";
                        }

                        if ($notifs["IDReclamation"] == $reclamation["IdReclamation"]) {
                            $i = 1;
                        }
                    }
                    if ($i == 0) {
                        $Annonces->insertVueAdmin($reclamation["IdReclamation"], $user2->id, $reclamation["ObjetReclam"]);
                    } else {
                        $i = 0;
                    }
                    // ajouter a la table de notifications  vue

                }
            }
            // refused locations
            $Refuser = $Annonces->LocationRefuser($user2->id);
            $nomObjet = null;
            foreach ($Refuser as $REfused) {
                foreach ($AllData as $data) {
                    $test3 = (array)$data;
                    if ($test3["IdAnnonce"] == $REfused["IDANnonce"]) {
                        $i = 0;
                        foreach ($GettingNotifs as $notifs2) {
                            $notifs = (array)$notifs2;
                            // $nomObjet = $test2[' NomObjet'];
                            if ($notifs == null) {
                                // echo "idk";
                                $Annonces->insertignRefused($REfused["DateDebutLoc"], $REfused["DateFinLoc"], $REfused["IdLocation"], $REfused["IdClient"], $test3["IdObjet"]);
                            } else {
                                // echo "wahtt";
                            }
                            if ($REfused["IdLocation"] == $notifs["IDLocation"] && $REfused["IdClient"] == $notifs["IDclient"] && $test3["IdObjet"] == $notifs["IdObjet"] && $notifs["IDPartenaire"] == null) {
                                $i = 1;
                            }
                        }
                        if ($i == 0) {
                            // echo "inserting the accepted thing  ";
                            $Annonces->insertignRefused($REfused["DateDebutLoc"], $REfused["DateFinLoc"], $REfused["IdLocation"], $REfused["IdClient"], $test3["IdObjet"]);
                            // echo " not inserting the accepted thing  ";
                        } else {
                            $i = 0;
                        }
                    }
                }
            }
            // getting all notifications and sorting them by desc
            $allNotifsSelected = $Annonces->selectingNotifications();
            // var_dump($allNotifsSelected);
            $GettingAll =  $ClientNotif->getAllAnnonces();
            $reclamations = $ClientNotif->reponseAdminClient($user2->id);
            if ($req->Reponse) {
                // echo "please";

                return view('View_Reclamation', ['client' => $user2, 'allNotifsSelected' => $allNotifsSelected, 'CheckNoteClient' => $CheckNoteClient, 'AllData' => $GettingAll,  'reclamations' => $reclamations, 'LocationsAccepter' => $AcceptedLocations, 'id' => $req->id, 'type' => $req->type, 'client' => $user2,  'Reponse' => $req->Reponse, 'reclamations' => $reclamations]);
            } else {
                return view('View_Reclamation', ['client' => $user2, 'allNotifsSelected' => $allNotifsSelected, 'CheckNoteClient' => $CheckNoteClient, 'AllData' => $GettingAll,  'reclamations' => $reclamations, 'LocationsAccepter' => $AcceptedLocations, 'id' => $req->id, 'type' => $req->type, 'client' => $user2, 'reclamations' => $reclamations]);
            }
        } else if ($req->type == "partenaire" && !$req->goal) {
            // var_dump("2");
            $ClientNotif2 =  new User();
            $user2 = Partenaire::where('id', '=', $req->id)->first();


            $CheckNotePartenaire = $Annonces->CheckNotePartenaire($user2->id);
            $GettingNotifs = $Annonces->SelectingNotifs();
            foreach ($CheckNotePartenaire as $data) {
                // var_dump($data);
                if ($data["IdLocation"] != null) {

                    $i = 0;
                    foreach ($GettingNotifs as $notifs2) {
                        $notifs = (array)$notifs2;
                        if ($notifs == null) {
                            // inserting not partenaire
                            $Annonces->insretingNotes($data["IdLocation"], $data["IdClient"], $user2->id);
                        } else {
                            // echo "wahtt";
                        }
                        if ($data["IdLocation"] == $notifs["IDLocation"] && $data["IdClient"] == $notifs["IDclient"] && $user2->id == $notifs["IDPartenaire"]) {
                            $i = 1;
                        }
                    }
                    if ($i == 0) {
                        $insertingNotes = $Annonces->insretingNotes($data["IdLocation"], $data["IdClient"], $user2->id);
                    } else {
                        $i = 0;
                    }
                }
            }
            $reclamations = $Annonces->reponseAdminPartenaire($user2->id);
            foreach ($reclamations as $reclamation) {
                if ($reclamation["ReponseReclam"] != NULL) {
                    $i = 0;
                    foreach ($GettingNotifs as $notifs2) {
                        $notifs = (array)$notifs2;

                        if ($notifs == null) {
                            $Annonces->insertMessgaeAdminPartenaire($reclamation["IdReclamation"], $reclamation["ReponseReclam"], $user2->id, $reclamation["ObjetReclam"]);
                        } else {
                            // echo "wahtt";
                        }
                        if ($notifs['IDReclamation'] == $reclamation["IdReclamation"]) {
                            $i = 1;
                        }
                    }
                    if ($i == 0) {
                        $Annonces->insertMessgaeAdminPartenaire($reclamation["IdReclamation"], $reclamation["ReponseReclam"], $user2->id, $reclamation["ObjetReclam"]);
                    } else {
                        $i = 0;
                    }
                } else if ($reclamation["ReponseReclam"] == NULL && $reclamation["VueReclamationAdmin"] != "non") {

                    $i = 0;

                    foreach ($GettingNotifs as $notifs2) {

                        $notifs = (array)$notifs2;

                        if ($notifs == null) {
                            $Annonces->insertVueAdminPartenaire($reclamation["IdReclamation"], $user2->id, $reclamation["ObjetReclam"]);
                        } else {
                            // echo "wahtt";
                        }

                        if ($notifs["IDReclamation"] == $reclamation["IdReclamation"]) {
                            $i = 1;
                        }
                    }
                    if ($i == 0) {
                        $Annonces->insertVueAdminPartenaire($reclamation["IdReclamation"], $user2->id, $reclamation["ObjetReclam"]);
                    } else {
                        $i = 0;
                    }
                }
            }

            $allNotifsSelected = $Annonces->selectingNotifications();


            $GettingAll =  $ClientNotif2->getAllAnnonces();
            if ($req->Reponse) {
                return view('View_Reclamation', ["partenaire" => $user2, 'allNotifsSelected' => $allNotifsSelected, 'CheckNotePartenaire' => $CheckNotePartenaire, 'id' => $req->id, 'type' => 'partenaire', 'partenaire' => $user2, 'Reponse' => $req->Reponse, 'reclamations' => $reclamations]);
            } else {
                return view('View_Reclamation', ["partenaire" => $user2, 'allNotifsSelected' => $allNotifsSelected, 'CheckNotePartenaire' => $CheckNotePartenaire, 'id' => $req->id, 'type' => 'partenaire', 'partenaire' => $user2, 'reclamations' => $reclamations]);
            }
        } else if ($req->type == "client" && $req->goal == "insert") {
            // var_dump("3");
            DB::INSERT('insert into Reclamation (idClients , ObjetReclam, MessageReclam) VALUES (?,?,?)', [$req->id, $req->get("objet"), $req->get("message")]);
            // return back();
            $allNotifsSelected = $Annonces->selectingNotifications();

            return view('View_Reclamation', ['id' => $req->id, "allNotifsSelected" => $allNotifsSelected, 'type' => $req->type]);

            // return back();
        } else if ($req->type == "partenaire" && $req->goal == "insert") {
            // var_dump("4");

            DB::INSERT('insert into Reclamation (idPartenaires, ObjetReclam, MessageReclam) VALUES (?,?,?)', [$req->id, $req->get("objet"), $req->get("message")]);
            // return view('View_Reclamation', ['id' => $req->id, 'type' => $req->type]);
            $user2 = Partenaire::where('id', '=', $req->id)->first();
            $NewUser = new User();
            $CheckNotePartenaire = $NewUser->CheckNotePartenaire($user2->id);
            $reclamations = $NewUser->reponseAdminPartenaire($user2->id);
            $AnnoncesPremium =  new User();
            $annonces =  $AnnoncesPremium->getAnnoncesPremium();
            $villes =  $AnnoncesPremium->getVille();

            $ville = json_decode(json_encode($villes), true);
            $categories =  $AnnoncesPremium->getCategorie();
            // next
            $categorie = json_decode(json_encode($categories), true);
            // var_dump($reclamations);
            $allNotifsSelected = $AnnoncesPremium->selectingNotifications();
            return view('view_Acceuil', ['partenaire' => $user2, 'allNotifsSelected' => $allNotifsSelected, 'CheckNotePartenaire' => $CheckNotePartenaire, 'annonces' => $annonces, 'villes' => $ville, 'categories' => $categorie, 'reclamations' => $reclamations]);
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
        $Annonces =  new User();
        $user2 = Partenaire::where('id', '=', $request->id)->first();
        $NewUser = new User();
        $CheckNotePartenaire = $NewUser->CheckNotePartenaire($request->id);
        $GettingNotifs = $Annonces->SelectingNotifs();
        foreach ($CheckNotePartenaire as $data) {
            // var_dump($data);
            if ($data["IdLocation"] != null) {

                $i = 0;
                foreach ($GettingNotifs as $notifs2) {
                    $notifs = (array)$notifs2;
                    if ($notifs == null) {
                        // inserting not partenaire
                        $Annonces->insretingNotes($data["IdLocation"], $data["IdClient"], $user2->id);
                    } else {
                        // echo "wahtt";
                    }
                    if ($data["IdLocation"] == $notifs["IDLocation"] && $data["IdClient"] == $notifs["IDclient"] && $user2->id == $notifs["IDPartenaire"]) {
                        $i = 1;
                    }
                }
                if ($i == 0) {
                    $insertingNotes = $Annonces->insretingNotes($data["IdLocation"], $data["IdClient"], $user2->id);
                } else {
                    $i = 0;
                }
            }
        }
        $reclamations = $NewUser->reponseAdminPartenaire($request->id);
        foreach ($reclamations as $reclamation) {
            if ($reclamation["ReponseReclam"] != NULL) {
                $i = 0;
                foreach ($GettingNotifs as $notifs2) {
                    $notifs = (array)$notifs2;

                    if ($notifs == null) {
                        $Annonces->insertMessgaeAdminPartenaire($reclamation["IdReclamation"], $reclamation["ReponseReclam"], $user2->id, $reclamation["ObjetReclam"]);
                    } else {
                        // echo "wahtt";
                    }
                    if ($notifs['IDReclamation'] == $reclamation["IdReclamation"]) {
                        $i = 1;
                    }
                }
                if ($i == 0) {
                    $Annonces->insertMessgaeAdminPartenaire($reclamation["IdReclamation"], $reclamation["ReponseReclam"], $user2->id, $reclamation["ObjetReclam"]);
                } else {
                    $i = 0;
                }
            } else if ($reclamation["ReponseReclam"] == NULL && $reclamation["VueReclamationAdmin"] != "non") {

                $i = 0;

                foreach ($GettingNotifs as $notifs2) {

                    $notifs = (array)$notifs2;

                    if ($notifs == null) {
                        $Annonces->insertVueAdminPartenaire($reclamation["IdReclamation"], $user2->id, $reclamation["ObjetReclam"]);
                    } else {
                        // echo "wahtt";
                    }

                    if ($notifs["IDReclamation"] == $reclamation["IdReclamation"]) {
                        $i = 1;
                    }
                }
                if ($i == 0) {
                    $Annonces->insertVueAdminPartenaire($reclamation["IdReclamation"], $user2->id, $reclamation["ObjetReclam"]);
                } else {
                    $i = 0;
                }
            }
        }
        $info  = new User();
        $categories =  $info->getCategorie();
        $categorie = json_decode(json_encode($categories), true);
        $user2 = Partenaire::where('id', '=', $request->id)->first();
        $objets = $info->getObjets($request->id);

        $villes = $info->getVille();
        $ville = json_decode(json_encode($villes), true);
        $allNotifsSelected = $Annonces->selectingNotifications();


        return view('view_Publier_Objet', ['partenaire' => $user2, 'allNotifsSelected' => $allNotifsSelected, 'villes' => $ville, 'reclamations' => $reclamations, 'CheckNotePartenaire' => $CheckNotePartenaire, 'categories' => $categorie, 'objets' => $objets]);
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

        $dates = explode(" - ", $request->date);
        $time_input = strtotime($dates[0]);
        $time_input2 = strtotime($dates[1]);
        // echo $dates[0];
        $newformat = date('Y-m-d', $time_input);
        $newformat2 = date('Y-m-d', $time_input2);
        if (!$request->ville) {
            echo "not really working ";
        }
        $temp = file_get_contents($request->fichier);
        $blob = base64_encode($temp);

        $checkingAnnoncesNumber = $info->checkAnnonce($request->id);
        $counting  = $checkingAnnoncesNumber[0]['count(o.IdObjet)'];

        $file = request()->file('fichier');
        $imagedata = file_get_contents($file->getRealPath());
        $base64 = base64_encode($imagedata);


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
            if ($request->input('premium')) {
                $query2 = DB::table('annonce')->insert([
                    'IdObjet' => $lastID,
                    'Premium' => $request->input('premium'),
                    'Dureepremium' => $request->input('Dureepremium'),
                    'Image' => $imagedata,
                    'DateDebut' => $newformat,
                    'DateFin' => $newformat2,
                    "archivee" => "non"
                ]);
            } else {
                $query2 = DB::table('annonce')->insert([
                    'IdObjet' => $lastID,
                    'Premium' => $request->input('premium'),
                    'Dureepremium' => null,
                    'Image' => $imagedata,
                    'DateDebut' => $newformat,
                    'DateFin' => $newformat2,
                    "archivee" => "non"
                ]);
            }
            $NewUser = new User();
            $CheckNotePartenaire = $NewUser->CheckNotePartenaire($request->id);
            $reclamations = $NewUser->reponseAdminPartenaire($request->id);

            if ($query2) {
                return view('view_Publier_Objet', ['partenaire' => $user2, 'reclamations' => $reclamations, 'CheckNotePartenaire' => $CheckNotePartenaire, 'categories' => $categorie, 'objets' => $objets]);
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
        // echo $newformat;
        // echo "hello";
        // echo $newformat2;
        DB::INSERT('insert into location ( DateDebutLoc, DateFinLoc, IDANnonce ,IdClient,IDPartenaire ,Status,Note,NotePartenaire) VALUES (?,?,?,?,?,?,?,?)', [$newformat, $newformat2, $req->IDAnnonce, $req->IDClient, $req->IDPartenaire, "non", "non", "non"]);
        $user = Client::where('id', '=', $req->IDClient)->first();
        $AnnoncesPremium =  new User();
        $annonces =  $AnnoncesPremium->getAnnoncesPremium();
        $villes =  $AnnoncesPremium->getVille();
        $ville = json_decode(json_encode($villes), true);
        $categories =  $AnnoncesPremium->getCategorie();
        $categorie = json_decode(json_encode($categories), true);
        $ClientNotif =  new User();
        $reclamations = $ClientNotif->reponseAdminClient($user->id);
        $GettingAll =  $AnnoncesPremium->getAllAnnonces();
        $CheckNoteClient = $AnnoncesPremium->CheckNoteClient($user->id);
        $AcceptedLocations = $AnnoncesPremium->LocationAccepterNotifs($user->id);
        $Refuser = $ClientNotif->LocationRefuser($user->id);
        $allNotifsSelected = $AnnoncesPremium->selectingNotifications();
        return view('view_Acceuil', ['client' => $user, 'allNotifsSelected' => $allNotifsSelected, 'Refuser' => $Refuser, 'CheckNoteClient' => $CheckNoteClient, 'annonces' => $annonces, 'AllData' => $GettingAll, 'villes' => $ville, 'categories' => $categorie, 'reclamations' => $reclamations, 'LocationsAccepter' => $AcceptedLocations]);
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

    public function archive(Request $req)
    {
        $req->validate([
            "id" => 'required',
            "type" => 'required',
        ]);

        $ClientNotif =  new User();
        $Annonces =  new User();
        // getting all
        $Annonce = $Annonces->getAllAnnonces();
        $annonce = (array)$Annonce;
        $user2 = Partenaire::where('id', '=', $req->id)->first();
        // admin response
        $reclamations = $ClientNotif->reponseAdminPartenaire($user2->id);
        // getting note partenaire
        $CheckNotePartenaire = $ClientNotif->CheckNotePartenaire($user2->id);
        // get objects overall grade
        $Averagenote = DB::select('SELECT AVG(ao.NoteObjet),o.IdObjet from avisobjet ao join objet o on ao.IdObjet   = o.IdObjet where o.idPartenaires =:idPartenaires   GROUP by o.IdObjet ; ', ["idPartenaires" => $req->id]);
        $res = json_decode(json_encode($Averagenote), true);
        // notification end of location client
        $user2 = Partenaire::where('id', '=', $req->id)->first();
        $Annonces = new User();
        // chcking note partenaire
        $CheckNotePartenaire = $Annonces->CheckNotePartenaire($user2->id);
        $GettingNotifs = $Annonces->SelectingNotifs();
        foreach ($CheckNotePartenaire as $data) {
            // var_dump($data);
            if ($data["IdLocation"] != null) {

                $i = 0;
                foreach ($GettingNotifs as $notifs2) {
                    $notifs = (array)$notifs2;
                    if ($notifs == null) {
                        // inserting not partenaire
                        $Annonces->insretingNotes($data["IdLocation"], $data["IdClient"], $user2->id);
                    } else {
                        // echo "wahtt";
                    }
                    if ($data["IdLocation"] == $notifs["IDLocation"] && $data["IdClient"] == $notifs["IDclient"] && $user2->id == $notifs["IDPartenaire"]) {
                        $i = 1;
                    }
                }
                if ($i == 0) {
                    $insertingNotes = $Annonces->insretingNotes($data["IdLocation"], $data["IdClient"], $user2->id);
                } else {
                    $i = 0;
                }
            }
        }
        // first try partenaire
        $ClientNotif =  new User();
        $reclamations = $ClientNotif->reponseAdminPartenaire($user2->id);
        foreach ($reclamations as $reclamation) {
            if ($reclamation["ReponseReclam"] != NULL) {
                $i = 0;
                foreach ($GettingNotifs as $notifs2) {
                    $notifs = (array)$notifs2;

                    if ($notifs == null) {
                        $Annonces->insertMessgaeAdminPartenaire($reclamation["IdReclamation"], $reclamation["ReponseReclam"], $user2->id, $reclamation["ObjetReclam"]);
                    } else {
                        // echo "wahtt";
                    }
                    if ($notifs['IDReclamation'] == $reclamation["IdReclamation"]) {
                        $i = 1;
                    }
                }
                if ($i == 0) {
                    $Annonces->insertMessgaeAdminPartenaire($reclamation["IdReclamation"], $reclamation["ReponseReclam"], $user2->id, $reclamation["ObjetReclam"]);
                } else {
                    $i = 0;
                }
            } else if ($reclamation["ReponseReclam"] == NULL && $reclamation["VueReclamationAdmin"] != "non") {

                $i = 0;

                foreach ($GettingNotifs as $notifs2) {

                    $notifs = (array)$notifs2;

                    if ($notifs == null) {
                        $Annonces->insertVueAdminPartenaire($reclamation["IdReclamation"], $user2->id, $reclamation["ObjetReclam"]);
                    } else {
                        // echo "wahtt";
                    }

                    if ($notifs["IDReclamation"] == $reclamation["IdReclamation"]) {
                        $i = 1;
                    }
                }
                if ($i == 0) {
                    $Annonces->insertVueAdminPartenaire($reclamation["IdReclamation"], $user2->id, $reclamation["ObjetReclam"]);
                } else {
                    $i = 0;
                }
            }
        }
        // getting all notifications and sorting them by desc
        $allNotifsSelected = $Annonces->selectingNotifications();
        // var_dump($allNotifsSelected);
        // var_dump($res);
        return view('view_Archive', ['id' => $req->id, 'allNotifsSelected' => $allNotifsSelected, 'CheckNotePartenaire' => $CheckNotePartenaire, 'reclamations' => $reclamations, "Averagenote" => $res, 'partenaire' => $user2, 'CheckNotePartenaire' => $CheckNotePartenaire, "annonces" => $annonce, 'type' => "partenaire", 'reclamations' => $reclamations]);
    }

    public function FirstPage()
    {
        $AnnoncesPremium =  new User();
        $annonces =  $AnnoncesPremium->getAnnoncesPremium();
        $villes =  $AnnoncesPremium->getVille();
        $categories =  $AnnoncesPremium->getCategorie();
        $ville = json_decode(json_encode($villes), true);
        $categorie = json_decode(json_encode($categories), true);
        $annonce = (array)$annonces;
        return view('view_Acceuil', ['annonces' => $annonces, 'villes' => $ville, 'categories' => $categorie]);
    }

    public function plusDeProduitsOff()
    {
        $AnnoncesPremium =  new User();
        $Annonce = $AnnoncesPremium->getAllAnnonces();
        $villes =  $AnnoncesPremium->getVille();
        $categories =  $AnnoncesPremium->getCategorie();
        $ville = json_decode(json_encode($villes), true);
        $categorie = json_decode(json_encode($categories), true);
        $GettingAll =  $AnnoncesPremium->getAllAnnonces();
        return view('view_Annonces', ['annonces' => $Annonce, 'villes' => $ville, 'categories' => $categorie]);
    }
    public function annonceOff(Request $request)
    {
        $request->validate([
            "idAnnonce" => 'required',
        ]);
        $Annonces =  new User();
        // echo $request->idAnnonce;
        $Annonce = $Annonces->getInfoAnnonce($request->idAnnonce);

        $dates = $Annonces->getTimes();
        // var_dump($dates);

        // average objet note


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

        // getting average not partenaire
        $results = DB::select(' SELECT AVG(Notepartenaires) from avispartenaires where idPartenaires =:id GROUP by IdAvispartenaires ; ', ['id' => $user3->id]);
        $res2 = json_decode(json_encode($results), true);
        $notePartenaire = $res2[0];
        // average note objet
        $average = null;
        $Averagenote = DB::select('SELECT AVG(ao.NoteObjet),o.IdObjet from avisobjet ao join objet o on ao.IdObjet   = o.IdObjet  GROUP by o.IdObjet;');
        $resNote = json_decode(json_encode($Averagenote), true);

        foreach ($resNote as $avg) {

            if ($avg['IdObjet'] == $annonce['IdObjet']) {

                $average = $avg['AVG(ao.NoteObjet)'];
            }
        }
        $GettingAll =  $Annonces->getAllAnnonces();
        $user3 = Partenaire::where('id', '=', $annonce["idPartenaires"])->first();

        return view('view_Annonce', ['AllData' => $GettingAll, 'notePartenaire' => $notePartenaire, 'noteTotalObjet' => $average, "Annonce" => $annonce, "partenaire" => $user3, "avisObjet" => $res, "image" => $image['Image'], 'dates' => $dates]);
    }

    //
    public function getDataDashboard()
    {
        $currentYear = date("Y");
        // echo $currentYear;

        $countrec = DB::table('reclamation')->get()->count();
        $countann = DB::table('annonce')->get()->count();
        $countcst = DB::table('clients')->get()->count();
        $countpart = DB::table('partenaires')->get()->count();
        $countprem = DB::table('annonce')->where('Premium', 'oui')->count();
        $januaryRentals = DB::table('location')->whereMonth('DateDebutLoc', '=', '01')->whereYear('DateDebutLoc', '=', $currentYear)->get()->count();
        $februaryRentals = DB::table('location')->whereMonth('DateDebutLoc', '=', '02')->whereYear('DateDebutLoc', '=', $currentYear)->get()->count();
        $marchRentals = DB::table('location')->whereMonth('DateDebutLoc', '=', '03')->whereYear('DateDebutLoc', '=', $currentYear)->get()->count();
        $aprilRentals = DB::table('location')->whereMonth('DateDebutLoc', '=', '04')->whereYear('DateDebutLoc', '=', $currentYear)->get()->count();
        $mayRentals = DB::table('location')->whereMonth('DateDebutLoc', '=', '05')->whereYear('DateDebutLoc', '=', $currentYear)->get()->count();
        $juneRentals = DB::table('location')->whereMonth('DateDebutLoc', '=', '06')->whereYear('DateDebutLoc', '=', $currentYear)->get()->count();
        $julyRentals = DB::table('location')->whereMonth('DateDebutLoc', '=', '07')->whereYear('DateDebutLoc', '=', $currentYear)->get()->count();
        $augustRentals = DB::table('location')->whereMonth('DateDebutLoc', '=', '08')->whereYear('DateDebutLoc', '=', $currentYear)->get()->count();
        $septemberRentals = DB::table('location')->whereMonth('DateDebutLoc', '=', '09')->whereYear('DateDebutLoc', '=', $currentYear)->get()->count();
        $octoberRentals = DB::table('location')->whereMonth('DateDebutLoc', '=', '10')->whereYear('DateDebutLoc', '=', $currentYear)->get()->count();
        $novemberRentals = DB::table('location')->whereMonth('DateDebutLoc', '=', '11')->whereYear('DateDebutLoc', '=', $currentYear)->get()->count();
        $decemberRentals = DB::table('location')->whereMonth('DateDebutLoc', '=', '12')->whereYear('DateDebutLoc', '=', $currentYear)->get()->count();
        $januaryPartners = DB::table('partenaires')->whereMonth('created_at', '=', '01')->whereYear('created_at', '=', $currentYear)->get()->count();
        $februaryPartners = DB::table('partenaires')->whereMonth('created_at', '=', '02')->whereYear('created_at', '=', $currentYear)->get()->count();
        $marchPartners = DB::table('partenaires')->whereMonth('created_at', '=', '03')->whereYear('created_at', '=', $currentYear)->get()->count();
        $aprilPartners = DB::table('partenaires')->whereMonth('created_at', '=', '04')->whereYear('created_at', '=', $currentYear)->get()->count();
        $mayPartners = DB::table('partenaires')->whereMonth('created_at', '=', '05')->whereYear('created_at', '=', $currentYear)->get()->count();
        $junePartners = DB::table('partenaires')->whereMonth('created_at', '=', '06')->whereYear('created_at', '=', $currentYear)->get()->count();
        $julyPartners = DB::table('partenaires')->whereMonth('created_at', '=', '07')->whereYear('created_at', '=', $currentYear)->get()->count();
        $augustPartners = DB::table('partenaires')->whereMonth('created_at', '=', '08')->whereYear('created_at', '=', $currentYear)->get()->count();
        $septemberPartners = DB::table('partenaires')->whereMonth('created_at', '=', '09')->whereYear('created_at', '=', $currentYear)->get()->count();
        $octoberPartners = DB::table('partenaires')->whereMonth('created_at', '=', '10')->whereYear('created_at', '=', $currentYear)->get()->count();
        $novemberPartners = DB::table('partenaires')->whereMonth('created_at', '=', '11')->whereYear('created_at', '=', $currentYear)->get()->count();
        $decemberPartners = DB::table('partenaires')->whereMonth('created_at', '=', '12')->whereYear('created_at', '=', $currentYear)->get()->count();
        $januaryCustomers = DB::table('clients')->whereMonth('created_at', '=', '01')->whereYear('created_at', '=', $currentYear)->get()->count();
        $februaryCustomers = DB::table('clients')->whereMonth('created_at', '=', '02')->whereYear('created_at', '=', $currentYear)->get()->count();
        $marchCustomers = DB::table('clients')->whereMonth('created_at', '=', '03')->whereYear('created_at', '=', $currentYear)->get()->count();
        $aprilCustomers = DB::table('clients')->whereMonth('created_at', '=', '04')->whereYear('created_at', '=', $currentYear)->get()->count();
        $mayCustomers = DB::table('clients')->whereMonth('created_at', '=', '05')->whereYear('created_at', '=', $currentYear)->get()->count();
        $juneCustomers = DB::table('clients')->whereMonth('created_at', '=', '06')->whereYear('created_at', '=', $currentYear)->get()->count();
        $julyCustomers = DB::table('clients')->whereMonth('created_at', '=', '07')->whereYear('created_at', '=', $currentYear)->get()->count();
        $augustCustomers = DB::table('clients')->whereMonth('created_at', '=', '08')->whereYear('created_at', '=', $currentYear)->get()->count();
        $septemberCustomers = DB::table('clients')->whereMonth('created_at', '=', '09')->whereYear('created_at', '=', $currentYear)->get()->count();
        $octoberCustomers = DB::table('clients')->whereMonth('created_at', '=', '10')->whereYear('created_at', '=', $currentYear)->get()->count();
        $novemberCustomers = DB::table('clients')->whereMonth('created_at', '=', '11')->whereYear('created_at', '=', $currentYear)->get()->count();
        $decemberCustomers = DB::table('clients')->whereMonth('created_at', '=', '12')->whereYear('created_at', '=', $currentYear)->get()->count();


        $data = [
            "countrec"  => $countrec,
            'countann'   => $countann,
            'countcst' => $countcst,
            'countpart' => $countpart,
            'countprem' => $countprem,
            'januaryRentals' => $januaryRentals,
            'februaryRentals' => $februaryRentals,
            'marchRentals' => $marchRentals,
            'aprilRentals' => $aprilRentals,
            'mayRentals' => $mayRentals,
            'juneRentals' => $juneRentals,
            'julyRentals' => $julyRentals,
            'augustRentals' => $augustRentals,
            'septemberRentals' => $septemberRentals,
            'octoberRentals' => $octoberRentals,
            'novemberRentals' => $novemberRentals,
            'decemberRentals' => $decemberRentals,
            'januaryCustomers' => $januaryCustomers,
            'februaryCustomers' => $februaryCustomers,
            'marchCustomers' => $marchCustomers,
            'aprilCustomers' => $aprilCustomers,
            'mayCustomers' => $mayCustomers,
            'juneCustomers' => $juneCustomers,
            'julyCustomers' => $julyCustomers,
            'augustCustomers' => $augustCustomers,
            'septemberCustomers' => $septemberCustomers,
            'octoberCustomers' => $octoberCustomers,
            'novemberCustomers' => $novemberCustomers,
            'decemberCustomers' => $decemberCustomers,
            'januaryPartners' => $januaryPartners,
            'februaryPartners' => $februaryPartners,
            'marchPartners' => $marchPartners,
            'aprilPartners' => $aprilPartners,
            'mayPartners' => $mayPartners,
            'junePartners' => $junePartners,
            'julyPartners' => $julyPartners,
            'augustPartners' => $augustPartners,
            'septemberPartners' => $septemberPartners,
            'octoberPartners' => $octoberPartners,
            'novemberPartners' => $novemberPartners,
            'decemberPartners' => $decemberPartners,
        ];

        return  view('dashboard', ["data" => $data]);
    }

    public function customers(Request $request)
    {
        // echo "even trying ";
        $request->validate([
            "email" => 'required',
        ]);
        $Sympathieclients = DB::select('SELECT PrenomClient,etat,NomClint,EmailClient,id,AVG(Noteclients) as NOTECLIENt  FROM avisclients JOIN clients ON avisclients.idClients =clients.id');
        // average note
        // $Sympathieclients = DB::select('SELECT AVG(Noteclients) as NoteClient FROM avisclients JOIN clients ON avisclients.idClients =clients.id');
        // echo "are you even here?";
        // var_dump($Sympathieclients);
        return view('customers')->with([
            'Sympathieclients' => $Sympathieclients,
            'email' => $request->email,
        ]);
    }
    public function partners(Request $request)
    {
        $request->validate([
            "email" => 'required',
        ]);
        $Notepartenaires = DB::select('SELECT partenaires.id, AVG(Notepartenaires) as AVgNote, partenaires.etat, partenaires.NomPartenaire, partenaires.PrenomPartenaire, partenaires.EmailPartenaire
                            FROM partenaires JOIN avispartenaires ON partenaires.id=avispartenaires.idPartenaires group by avispartenaires.idPartenaires');


        // echo "are you even here?";
        // var_dump($Notepartenaires);
        return view('partners')->with([
            'Notepartenaires' => $Notepartenaires,
            'email' => $request->email,
        ]);
    }
    public function bloquercustomer($id, Request $req)
    {

        $res = DB::select('SELECT etat from clients where id = ' . $id);
        foreach ($res as $e) {
            $etat = $e->etat;
        }

        if ($etat != 'bloque') {
            DB::update('update clients set etat ="bloque" where id = ' . $id);
        } else {
            DB::update('update clients set etat ="visible" where id = ' . $id);
        }

        return Redirect::back()->with('message', 'well blocked !');
    }

    public function bloquerpartner($id, Request $req)
    {

        $res = DB::select('SELECT etat from partenaires where id = ' . $id);
        foreach ($res as $e) {
            $etat = $e->etat;
        }

        if ($etat != 'bloque') {
            DB::update('UPDATE partenaires set etat ="bloque" where id = ' . $id);
        } else {
            DB::update('UPDATE partenaires set etat ="visible" where id = ' . $id);
        }

        return Redirect::back()->with('message', 'well blocked !');
    }

    public function announcement(Request $req)
    {

        $req->validate([
            "email" => 'nullable',
        ]);
        $annonces = DB::select('SELECT objet.` NomObjet` , annonce.IdAnnonce, annonce.etat,objet.idPartenaires , annonce.Premium, objet.VilleObjet, annonce.Image, objet.PrixObjet, objet.CategorieObjet
        FROM objet JOIN annonce ON annonce.IdObjet =objet.IdObjet');
        // var_dump($annonces);
        // echo "testing";
        return view('view_AnnoncesAdmin')->with([

            'annonces' => $annonces,
            'email' => $req->email,
        ]);
    }
    public function announcementblack()
    {

        $annonces = DB::select('SELECT objet.` NomObjet`, annonce.IdAnnonce, annonce.etat,objet.idPartenaires , annonce.Premium, objet.VilleObjet, annonce.Image, objet.PrixObjet, objet.CategorieObjet
                FROM objet JOIN annonce ON annonce.IdObjet=objet.IdObjet');

        return view('view_Annonces_blackliste')->with([
            'annonces' => $annonces
        ]);
    }
    public function bloquer($id, Request $req)
    {

        $res = DB::select('select etat from annonce where IdAnnonce = ' . $id);
        foreach ($res as $e) {
            $etat = $e->etat;
        }

        if ($etat != 'bloque') {
            DB::update('update annonce set etat ="bloque" where IdAnnonce = ' . $id);
        } else {
            DB::update('update annonce set etat ="visible" where IdAnnonce = ' . $id);
        }

        return Redirect::back()->with('message', 'well blocked !');
    }

    public function testing(Request $req)
    {
        echo "testing";
        $req->validate([
            "titre" => 'nullable',
            "Ville" => 'nullable',
            "Categorie" => 'nullable',
            "Prix" => 'nullable',
        ]);
    }
}