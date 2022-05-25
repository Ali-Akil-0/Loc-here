<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;


class User extends Model
{
    function getAnnoncesPremium()
    {
        // $results = DB::select('select * from annonce where Premium = oui ');
        $results = DB::select('select * from objet o join annonce a  on  a.IdObjet  = o.IdObjet where a.Premium = "oui" ');

        return $results;
    }
    function selectingAllFromLocation()
    {
        $results = DB::select('select * from location where Status = "non" ');

        return $results;
    }
    function getAllAnnonces()
    {
        $results = DB::select('select * from objet o join partenaires a  on  a.id  = o.idPartenaires JOIN annonce an on an.IdObjet = o.IdObjet join categorie c on c.IdCategorie =o.CategorieObjet   ');
        return $results;
    }
    function getALllocations($IdLocation, $IDPartenaire)
    {
        $results = DB::select('select * from location where IdLocation !=:IdLocation and Status=:Status and IDPartenaire =:IDPartenaire  ', ["IdLocation" => $IdLocation, "Status" => "non", "IDPartenaire" => $IDPartenaire]);
        $res = json_decode(json_encode($results), true);
        return $res;
    }
    function checkingAllAnnnonces()
    {
        $results = DB::select('select * from annonce  ');
        return $results;
    }
    function getVille()
    {
        $results = DB::select('select Distinct * from ville');
        return $results;
    }


    function getCategorie()
    {
        $results = DB::select('select Distinct * from categorie');

        return $results;
    }


    function getInfoAnnonce($idAnnonce)
    {
        $results = DB::select('select IdObjet  from annonce  where IdAnnonce = :IdAnnonce ', ['IdAnnonce' => $idAnnonce]);
        $res = json_decode(json_encode($results), true);
        $idObjet = $res[0]['IdObjet'];
        // $results3 = null;
        // $results2 = DB::select('select *  from objet o  join avisobjet a on a.IdObjet  = o.IdObjet where  o.IdObjet = :IdObjet ', ['IdObjet' => $idObjet]);
        // echo "found ????";
        $results3 = DB::select('select *  from objet o   join annonce an  on  an.IdObjet  = o.IdObjet  where  o.IdObjet = :IdObjet ', ['IdObjet' => $idObjet]);
        return $results3;
        // echo $idObjet = $res[0]['IdObjet'];

    }
    function getImage($idAnnonce)
    {
        $results = DB::select('select *  from annonce  where IdAnnonce = :IdAnnonce ', ['IdAnnonce' => $idAnnonce]);
        $res = (array)$results[0];
        return $res;
    }
    function getObjets($idPartenaires)
    {
        $results = DB::select('select *  from objet   where idPartenaires  = :idPartenaires  ', ['idPartenaires' => $idPartenaires]);
        $res = json_decode(json_encode($results), true);
        return $res;
    }

    function getTimes()
    {
        $results = DB::select('select DateDebutLoc,DateFinLoc  from location ');
        // $res = (array)$results;
        return $results;
    }
    function checkAnnonce($idPartenaires)
    {
        $results = DB::select('select count(o.IdObjet) from objet o  join annonce an  on  an.IdObjet  = o.IdObjet   where idPartenaires    = :idPartenaires  and archivee=:archivee  group by o.IdObjet ', ['idPartenaires' => $idPartenaires, 'archivee' => "non"]);
        $res = json_decode(json_encode($results), true);
        return $res;
    }
    // function getLimits($IdAnnonce)
    // {
    //     $results = DB::select('select * from annonce   where IdAnnonce   = :IdAnnonce ', ['IdAnnonce' => $IdAnnonce]);
    //     $res = json_decode(json_encode($results), true);
    //     return $res;
    // }

    public function reponseAdminClient($idClient)
    {
        $results = DB::select('select * from reclamation  where idClients =:idClients ', ['idClients' => $idClient]);
        $res = json_decode(json_encode($results), true);
        return $res;
    }
    public function lireReponse($IdReclamation)
    {
        $results = DB::select('UPDATE reclamation set ReclamationLu=:ReclamationLu where IdReclamation =:IdReclamation  ', ['ReclamationLu' => "oui", 'IdReclamation' => $IdReclamation]);
        if ($results) {
            echo "success";
        }
    }
    public function reponseAdminPartenaire($idPartenaires)
    {
        $results = DB::select('select * from reclamation  where idPartenaires  =:idPartenaires  ', ['idPartenaires' => $idPartenaires]);
        $res = json_decode(json_encode($results), true);
        return $res;
    }

    public function DemandesDeLocation($IDPartenaire)
    {
        $results = DB::select('select * from location l  join clients c on c.id = l.IdClient   where IDPartenaire   =:IDPartenaire   ', ['IDPartenaire' => $IDPartenaire]);
        $res = json_decode(json_encode($results), true);
        return $res;
    }
    public function AccepterDemandeLocation($IdLocation)
    {
        $results = DB::select('UPDATE location set Status=:Status where IdLocation  =:IdLocation   ', ['Status' => "Accepter", 'IdLocation' => $IdLocation]);
        if ($results) {
            echo "success";
        }
    }
    public function RefuserDemandeLocation($IdLocation)
    {
        $results = DB::select('UPDATE location set Status=:Status where IdLocation  =:IdLocation   ', ['Status' => "Refuser", 'IdLocation' => $IdLocation]);
        if ($results) {
            echo "success";
        }
    }
    public function LocationAccepterNotifs($idClient)
    {
        $results = DB::select('select * from location   where IdClient  =:IdClient  and Status=:Status ', ['IdClient' => $idClient, 'Status' => "Accepter"]);
        $res = json_decode(json_encode($results), true);
        return $res;
    }
    public function LocationRefuser($idClient)
    {
        $results = DB::select('select * from location   where IdClient  =:IdClient  and Status=:Status ', ['IdClient' => $idClient, 'Status' => "Refuser"]);
        $res = json_decode(json_encode($results), true);
        return $res;
    }
    // une location has an location id and id client and id annonce
    public function GettingInfoForEmail($IdLocation)
    {
        $results = DB::select('select * from location l join clients c on c.id=l.IdClient  where IdLocation =:IdLocation  ', ['IdLocation' => $IdLocation]);
        $res = json_decode(json_encode($results), true);
        return $res;
    }
    public function GettingTheObjetFormMAil($IdAnnonce)
    {
        $results = DB::select('select * from objet o join annonce a  on  a.IdObjet  = o.IdObjet  where a.IdAnnonce =:IdAnnonce ', ['IdAnnonce' => $IdAnnonce]);
        $res = (array)$results[0];
        // var_dump($res);
        return $res;
    }

    public function CheckNoteClient($IdClient)
    {
        $results = DB::select('select * from location  where Note=:Note and IdClient =:IdClient   ', ['Note' => "Waiting", 'IdClient' => $IdClient]);
        $res = json_decode(json_encode($results), true);
        return $res;
    }
    public function CheckNotePartenaire($IDPartenaire)
    {
        $results = DB::select('select * from location  where NotePartenaire=:NotePartenaire and IDPartenaire  =:IDPartenaire    ', ['NotePartenaire' => "Waiting", 'IDPartenaire' => $IDPartenaire]);
        $res = json_decode(json_encode($results), true);
        return $res;
    }
    // get the objet and Partenaire info
    public function getInfoLocation($IdLocation)
    {
        $results = DB::select('select * from location  where IdLocation   =:IdLocation     ', ['IdLocation' => $IdLocation]);
        $res = json_decode(json_encode($results), true);
        return $res;
    }
    // selecting objet
    public function getObjetInfo($IdObjet)
    {
        $results = DB::select('select * from objet  where IdObjet    =:IdObjet      ', ['IdObjet' => $IdObjet]);
        $res = json_decode(json_encode($results), true);
        return $res;
    }
    // selecting Partenaire
    public function getPartenaireInfo($id)
    {
        $results = DB::select('select * from partenaires  where id   =:id     ', ['id' => $id]);
        return $results;
    }
    public function getClientInfo($id)
    {
        $results = DB::select('select * from clients  where id   =:id     ', ['id' => $id]);
        $res = json_decode(json_encode($results), true);
        return $res;
    }

    public function checkifdemanded($IdClient)
    {
        $results = DB::select('select * from location  where IdClient =:IdClient and Status=:Status   ', ['IdClient' => $IdClient, 'Status' => "non"]);
        $res = json_decode(json_encode($results), true);
        return $res;
    }
    public function avisClient($IdClient)
    {
        $results = DB::select('select * from avisclients ac join partenaires p on p.id = ac.idPartenaires  where idClients  =:idClients   ', ['idClients' => $IdClient]);
        // var_dump($results);
        // $res = json_decode(json_encode($results), true);
        return $results;
    }
    public function avisPartenaires2($idPartenaires)
    {
        $results = DB::select('select * from avispartenaires ap join clients c on c.id = ap.idClients   where idPartenaires    =:idPartenaires     ', ['idPartenaires' => $idPartenaires]);
        return $results;
    }

    public function SelectingNotifs()
    {
        $results = DB::select('select * from notificationsclient;');
        return $results;
    }
    public function insretingNotes($IDLocation, $IDclient, $IDPartenaire)
    {
        echo "maybe insretign 1";
        DB::INSERT('insert into notificationsclient ( IDclient,Objet, IDPartenaire, IDLocation,LuClient ,LuPartenaire) VALUES (?,?,?,?,?,?)', [$IDclient, "Noter Objet, Client et fournisseur", $IDPartenaire, $IDLocation, 'non', "non"]);
        echo "again mayb";
    }
    public function NoterInsert($idPartenaires)
    {
        $results = DB::select('select * from avispartenaires ap join clients c on c.id = ap.idClients   where idPartenaires    =:idPartenaires     ', ['idPartenaires' => $idPartenaires]);
        return $results;
    }
    public function insertMessgaeAdmin($IDReclamation, $reponse, $IDclient, $ObjetClient)
    {
        echo "maybe insretign 1";
        DB::INSERT('insert into notificationsclient (IDReclamation, IDclient,Objet,Message,IDObjetReclamationClient) VALUES (?,?,?,?,?)', [$IDReclamation, $IDclient, "Reponse Admin", $reponse, $ObjetClient]);
        echo "again mayb";
    }
    public function insertMessgaeAdminPartenaire($IDReclamation, $reponse, $IDPartenaire, $ObjetClient)
    {
        echo "maybe insretign 1";
        DB::INSERT('insert into notificationsclient (IDReclamation, IDPartenaire,Objet,Message,IDObjetReclamationPartenaire) VALUES (?,?,?,?,?)', [$IDReclamation, $IDPartenaire, "Reponse Admin", $reponse, $ObjetClient]);
        echo "again mayb";
    }

    public function insertVueAdmin($IDReclamation, $IDclient, $ObjetClient)
    {
        echo "maybe insretign 1";
        if (isset($ObjetClient)) {
            DB::INSERT('insert into notificationsclient (IDReclamation, IDclient,Objet,IDObjetReclamationClient) VALUES (?,?,?,?)', [$IDReclamation, $IDclient, "Vue Admin", $ObjetClient]);
        } else {
            DB::INSERT('insert into notificationsclient (IDReclamation, IDclient,Objet) VALUES (?,?,?)', [$IDReclamation, $IDclient, "Vue Admin"]);
        }
        echo "again mayb";
    }
    public function insertVueAdminPartenaire($IDReclamation, $IDPartenaire, $ObjetClient)
    {
        echo "maybe insretign 1";
        if (isset($ObjetClient)) {
            DB::INSERT('insert into notificationsclient (IDReclamation, IDPartenaire,Objet,IDObjetReclamationPartenaire) VALUES (?,?,?,?)', [$IDReclamation, $IDPartenaire, "Vue Admin", $ObjetClient]);
        } else {
            DB::INSERT('insert into notificationsclient (IDReclamation, IDPartenaire,Objet) VALUES (?,?,?)', [$IDReclamation, $IDPartenaire, "Vue Admin"]);
        }
        echo "again mayb";
    }
    public function insertignAccepted($DateDebutLoc, $DateFinLoc, $IDLocation, $IDclient, $IdObjet)
    {
        echo "maybe insretign 1";
        DB::INSERT('insert into notificationsclient (IDLocation, IDclient,IdObjet,Message,Objet,DateDebutLoc,DateFinLoc) VALUES (?,?,?,?,?,?,?)', [$IDLocation, $IDclient, $IdObjet, "Accepted", "Accepted", $DateDebutLoc, $DateFinLoc]);
        echo "again mayb";
    }
    public function insertignRefused($DateDebutLoc, $DateFinLoc, $IDLocation, $IDclient, $IdObjet)
    {
        echo "maybe insretign 1";
        DB::INSERT('insert into notificationsclient (IDLocation, IDclient,IdObjet,Message,Objet,DateDebutLoc,DateFinLoc) VALUES (?,?,?,?,?,?,?)', [$IDLocation, $IDclient, $IdObjet, "Refused", "Refused", $DateDebutLoc, $DateFinLoc]);
        echo "again mayb";
    }
    public function selectingNotifications()
    {
        // echo "maybe insretign 1";
        $results = DB::select('select * from notificationsclient order by DateAjout desc ;  ');
        // echo "again mayb";
        return $results;
    }
    use HasFactory;
}