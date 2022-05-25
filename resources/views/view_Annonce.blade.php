<?php
ini_set('memory_limit', '2048M');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/LOC_HERE.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-daterangepicker/3.0.5/daterangepicker.min.css" integrity="sha256-VVbO1uqtov1mU6f9qu/q+MfDmrqTfoba0rAE07szS20=" crossorigin="anonymous" />

    <!------ Include the above in your HEAD tag ---------->
    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/bootstrap/3/css/bootstrap.css" />
    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.css" />

    <!-- JS -->
    <script type="text/javascript" src="//cdn.jsdelivr.net/jquery/1/jquery.min.js"></script>
    <script type="text/javascript" src="//cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.js"></script>

    {{-- <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script> --}}
    <script src="/js/rating.js"></script>
    <title>LOC HERE</title>
</head>

<body class="app__body">



    <header class="app__header">
        <div class="app__headerContent">
            <div class="app__logoPlacement">
                <img src="/img/logo.png" class="app__logo" />
            </div>
            <div class="app__options">
                <div class="app__Acceuil">
                    <p class="app__option">Acceuil</p>
                </div>
                <div class="app__Acceuil">
                    <p class="app__option">À propos</p>
                </div>
                <div class="app__Acceuil">
                    <p class="app__option">Contrat</p>
                </div>
                <div class="app__Acceuil">
                    @if(!empty($client))
                          @if($client->NomClint)
                          <form  method="post" action=''>
                            @method('POST')
                            @csrf
                            <button type="submit" class="exploreMoreProducts">
                                <p class="app__option">Devenir Partanaire</p>
                            </button>
                        </form>
                         {{-- <p class="app__option">Devenir Partanaire</p> --}}
                        @endif
                    @elseif(!empty($partenaire))
                         @if($partenaire->NomPartenaire)

                          <form  method="post" action='{{route('publier',['id' => $partenaire->id])}}'>
                          @csrf
                          <button type="submit" class="exploreMoreProducts">
                            <p class="app__option">publier</p>
                          </button>
                           </form>
                           @endif
                          @else
                          <p class="app__option">publier</p>
                      @endif
                </div>
            </div>
            <div class="app__signIn">
                <div class="app__SignInButton" id="InscrireButton">

                 @if(!empty($client))
                    @if($client->NomClint)
                   <div class="dropdown">
                    <span>
                        <form  method="post" action='{{route('profile',["id"=>$client->id,"type"=>"client"]) }}'>
                            @csrf
                            <button type="submit" class="exploreMoreProducts">
                                <p class="app__SIgnInPar">{{$client->UsernameClient}}</p>
                            </button>
                        </form>
                    </span>
                    <div class="dropdown-content">
                        <form  method="post" action='{{route('profile',["id"=>$client->id,"type"=>"client"]) }}'>
                            @csrf
                            <button type="submit" class="exploreMoreProducts exploreMoreProducts4">
                                <p class=""> Profile</p>
                            </button>
                        </form>
                    </div>

                </div>
                    {{-- <form  method="POST" action='{{route('Notes') }}'> --}}
                        {{-- @csrf --}}
                        <div class="dropdown">
                            <span>
                                <button type="submit" class="exploreMoreProducts">
                                <i class="fa fa-solid fa-bell"></i>
                            </button></span>
                            <div class="dropdown-content">

                                <?php

                                foreach ($allNotifsSelected as $notifs) {
                                    $testing4 = (array)$notifs;
                                    if($testing4["Objet"]=="Noter Objet, Client et fournisseur"){
                                        ?>
                                        <p>
                                            <?php
                                            // echo "please bab";
                                            // echo $testing4["Objet"];
                                            // echo $testing4["IDclient"];
                                            // echo $testing4["IDLocation"];
                                            // echo "please bab";
                                                ?>
                                        </p>

                           <form method="post" action="{{route('Notes',['id' => $testing4["IDclient"], 'type'=>"client", 'idLocation'=>$testing4["IDLocation"]]) }}">
                            @method("POST")
                            @csrf
                          <button class="app__coloredButton" type="submit"> Merci de donner votre avis sur la location numéro : <?php echo $testing4["IDLocation"] ;  ?>   </button>
                           </form>
                            <?php
                                    }
                                    if($testing4["Objet"]=="Accepted"){
                                            ?>

                                    <p>
                                        <?php
                                            echo "Votre demande de location de l'objet num : ";
                                            echo $testing4["IdObjet"];
                                            echo " pendant : ";
                                            echo $testing4["DateDebutLoc"] ;
                                            echo " au ";
                                            echo $testing4["DateFinLoc"] ;
                                            echo " a été approuvé ";
                                            ?>
                                    </p>
                                            <?php

                                    }
                                    if($testing4["Objet"]=="Refused"){
                                        ?>
                                    <p>
                                        <?php
                                            echo "Votre demande de location de l'objet num : ";
                                            echo $testing4["IdObjet"];
                                            echo " pendant : ";
                                            echo $testing4["DateDebutLoc"] ;
                                            echo " au ";
                                            echo $testing4["DateFinLoc"] ;
                                            echo " a été refusé ";
                                            ?>
                                    </p>
                                            <?php
                                    }
                                    if(!$testing4["IDObjetReclamationClient"]==null){
                                    if($testing4["Objet"]=="Reponse Admin"){
                                    ?>

                                    <form method="POST" action="{{route('Reclamation',['id' => $testing4["IDclient"], 'type'=>"client",'IdReponse'=>$testing4["IDReclamation"] ,"Reponse"=>$testing4["Message"] ,'lu'=>'non']) }}">
                                        @method("POST")
                                        @csrf
                                        <button class="app__coloredButton" type="submit">L'administrateur a repondu a votre reclamation (Sujet : <?php  echo $testing4["IDObjetReclamationClient"];?>)</button>
                                    </form>
                                    <?php
                                }

                                if($testing4["Objet"]=="Vue Admin"){
                                    ?>
                                                 <p >L'administrateur a vu  votre reclamation (Sujet : <?php  echo $testing4["IDObjetReclamationClient"];?>)  </p>
                                    <?php

                                }
                            }
                            }
                                ?>

                             </div>
                        </div>
                    {{-- </form> --}}

                    <form action='{{route('Reclamation',['id' => $client->id, 'type'=>"client"]) }}' method="post">
                        @csrf
                        <button type="submit" class="exploreMoreProducts">
                            <i class="fa fa-solid fa-flag"></i>
                        </button>
                    </form>
                         @endif
                     @elseif(!empty($partenaire))

                          @if($partenaire->NomPartenaire)

                <div class="dropdown">
                    {{-- <form  method="get" action='{{route('profile') }}'> --}}
                        {{-- @csrf --}}
                        <span>
                            <button type="submit" class="exploreMoreProducts">
                                <p class="app__SIgnInPar">{{ $partenaire["UsernamePartenaire"]}}</p>
                            </button>
                        </span>
                    {{-- </form> --}}
                    <div class="dropdown-content">
                        <form  method="post" action='{{route('profile',["id"=>$partenaire->id,"type"=>"partenaire"]) }}'>
                        @csrf
                        <button type="submit" class="exploreMoreProducts exploreMoreProducts3">
                            <p class=""> Profile</p>
                        </button>
                        </form>

                        <form  method="post" action='{{route('archive',['id' => $partenaire->id, 'type'=>"partenaire"]) }}'>
                            @csrf
                            <button type="submit" class="exploreMoreProducts exploreMoreProducts2">
                                <p class="">Archive</p>
                            </button>
                        </form>

                    </div>
                </div>

                <div class="dropdown">
                    <span>
                        <button type="submit" class="exploreMoreProducts">
                        <i class="fa fa-solid fa-bell"></i>
                    </button>
                 </span>
                    <div class="dropdown-content">
                                <?php
                                // change avis to be got from the db

                                foreach ($allNotifsSelected as $notifs) {
                                    $testing4 = (array)$notifs;
                                    if($testing4["Objet"]=="Noter Objet, Client et fournisseur"){
                                        ?>
                                        <form method="post" action="{{route('Notes',['id' => $partenaire->id, 'type'=>"partenaire", 'idLocation'=>$testing4["IDLocation"]]) }}">
                                            @method("POST")
                                            @csrf
                                            <button class="app__coloredButton" type="submit"> Merci de donner votre avis sur la location numéro : <?php echo $testing4["IDLocation"] ;  ?>   </button>
                                        </form>


                                        <?php

                                    }
                                    if(!$testing4["IDObjetReclamationPartenaire"]==null){
                                    if($testing4["Objet"]=="Reponse Admin"){
                                            ?>
                                             <form method="POST" action="{{route('Reclamation',['id' => $partenaire->id, 'type'=>"partenaire",'IdReponse'=>$testing4["IDReclamation"] ,"Reponse"=>$testing4["Message"] ,'lu'=>'non']) }}">
                                                @method("POST")
                                                @csrf
                                                <button class="app__coloredButton" type="submit">L'administrateur a repondu a votre reclamation (Sujet : <?php  echo $testing4["IDObjetReclamationPartenaire"];?>) </button>
                                            </form>
                                            <?php

                                    }
                                    if($testing4["Objet"]=="Vue Admin"){
                                    ?>
                                                 <p >L'administrateur a vu  votre reclamation (Sujet : <?php  echo $testing4["IDObjetReclamationPartenaire"];?>)  </p>
                                    <?php
                                         }
                                     }
                                }
                    ?>
                     </div>
                </div>
                <form action='{{route('Reclamation',['id' => $partenaire->id, 'type'=>"partenaire"]) }}' method="post">
                    @csrf
                    <button type="submit" class="exploreMoreProducts">
                        <i class="fa fa-solid fa-flag"></i>
                    </button>
                </form>
                    @endif
                    @else
                  <p class="app__SIgnInPar">S'inscrire</p>
                 @endif
                 </div>
                 <hr class="app__signInBreak" />
                 <div class="app__SignInButton" id="ConnecterButton">
                    @if(!empty($client))
                    @if($client->NomClint)
                    <form  method="get" action='{{route('login') }}'>
                        @csrf
                        <button type="submit" class="exploreMoreProducts">
                            <p class="app__SIgnInPar">Se deconnecter</p>
                        </button>
                    </form>
                  @endif
                  @elseif(!empty($partenaire))
                     @if($partenaire->NomPartenaire)
                  <form  method="get" action='{{route('login') }}'>
                    @csrf
                    <button type="submit" class="exploreMoreProducts">
                        <p class="app__SIgnInPar">Se deconnecter</p>
                    </button>
                </form>
                @endif
                  @else
                  <form  method="get" action='{{route('login') }}'>
                    @csrf
                    <button type="submit" class="exploreMoreProducts">
                        <p class="app__SIgnInPar">Se connecter</p>
                    </button>
                </form>
                  @endif
                </div>
            </div>
        </div>
        <hr class="app__headerBreak" />
    </header>


    <main class="app__annonceMain">
        <?php
        // var_dump($partenaire["UsernamePartenaire"]);
        ?>
        <div class="app__annonceBanner">
            <div class="app__annonceImageContainer">
                <img src="data:image/jpeg;base64,<?php echo base64_encode($image); ?>"  class="app__annonceImage" />
            </div>
            <div class="app__annnonceDescription">
                <div class="app__annonceTitre2">
                    <p>{{$Annonce[" NomObjet"]}}</p>
                </div>
                <div class="app__annonceDescriptionNom">
                    <p>{{$partenaire["UsernamePartenaire"]}}</p>
                </div>
                <div class="app__annonceRatingPrice">
                    <div>
                        <p class="app__annoncePrice2">{{$Annonce["PrixObjet"]}} DH / Jour</p>
                    </div>
                    <div class="app__annonceRating">
                        <input id="input-1" name="input-1" class="rating rating-loading" data-min="0" data-max="5"
                            data-step="0.1" disabled value="{{$noteTotalObjet}}">
                    </div>
                </div>
                <div class="app__annonceLocation">
                    @if(isset($type))
                    @if($type=="client")
                    <form action='{{route('location',['IDAnnonce'=>$Annonce["IdAnnonce"],'IDPartenaire'=>$partenaire['id'],'IDClient'=>$user->id] )}}' method="POST">
                        @csrf
                        <input type="text" class="daterange"  name="date"/>
                        <p>
                            <?php
                                // //    echo (array)$dates[0];
                                // //    echo ((array)$dates[0])["DateFinLoc"];
                                //     foreach($dates as $date){
                                //     $theDate  = (array)$date ;
                                //     $endDate = $theDate["DateFinLoc"] ;
                                //     $startDate =  $theDate["DateDebutLoc"];
                                    // echo $Annonce["DateDebut"]  ;
                                // //     echo "hello" ;
                                    // echo  $Annonce["DateFin"] ;
                               ?>
                            </p>
                        <script>

                               $('.daterange').daterangepicker({
                                isInvalidDate: function(date) {
                                 if ( date.format('YYYY-MM-DD') < '<?php echo  $Annonce["DateDebut"] ?>'
                                  || date.format('YYYY-MM-DD') > '<?php echo $Annonce["DateFin"] ;?>')
                                  {
                                   return true;
                                   }

                                  }
                               });
                         </script>
                         {{-- <?php
                        // }
                        ?> --}}
                    <button  type="submit" class="app__annonceLocationButton">Louer</button>
                    </form>
                    @endif
                   @else
                   <form  method="get" action='{{route('login') }}'>
                    @csrf
                    <button type="submit" class="exploreMoreProducts">
                        <span>
                            Se Connecter
                        </span>
                        <p>pour louer</p>
                    </button>
                </form>

                   @endif

                </div>
            </div>
        </div>
        <div class="app__annonceBottom">
            <div class="app__annonceInfo">
                <div class="app__annonceInfoObjet">
                    <p class="app__annonceInfoTitre">Info Objet : </p>
                    <p class="app__annonceInfoContent">
                        {{$Annonce['DescriptionObjet']}}
                    </p>
                    <div class="app__DemandesLocation">

                       <?php if(isset($type)){
                           if($type=="partenaire"){
                               $i=0 ;
                               if(isset($Demandes)){

                            foreach ($Demandes as $Demande) {
                                // var_dump($Demande);

                            if ($Annonce["idPartenaires"] == $user->id && $Annonce["archivee"]=="non" ) {

                                ?>
                                <?php

                                if($i==0){
                                ?>
                                <p class="app__annonceInfoTitre">Demandes de location : </p>
                                <?php
                                $i++  ;
                                }

                                ?>
                                <?php

                                if($Demande["Status"]=="non"){

                                    ?>
                                     <p>
                                        <?php
                                             echo ($Demande["UsernameClient"]);
                                            echo " demande la location de cet objet depuis : ";
                                            echo ($Demande["DateDebutLoc"]);
                                            echo " jusqu'a ";
                                            echo ($Demande["DateFinLoc"]);
                                                // echo ($Demande["IDANnonce"]);
                                                // echo ($Demande["Status"]);

                                                // echo "here";
                                                // echo $Demande["IdLocation"];
                                                // echo "here";
                                            ?>
                                      <form action='{{route('annonce',['id' => $user->id, 'type'=>"partenaire",'idAnnonce'=>$Demande["IDANnonce"],'IdLocation'=>$Demande["IdLocation"]]) }}' method="POST">
                                        @csrf
                                        <input type="submit" name="accept" id="accept" value="Accepter">
                                        <input type="submit" name="decline" id="decline" value="Refuser">
                                    </form>


                                   </p>

                                    <?php
                                }
                                ?>
                                <?php
                            }
                           }
                            foreach ($Demandes as $Demande) {
                            if ($Annonce["idPartenaires"] == $user->id && $Annonce["IdAnnonce"]==$Demande["IDANnonce"] && $Annonce["archivee"]=="non") {
                                $todaysDate = date_create(date("Y-m-d"));
                                $StartDate = date_create($Demande["DateDebutLoc"]);
                                 $EndDate = date_create($Demande["DateFinLoc"]);
                                //  var_dump($todaysDate);
                                //  var_dump($StartDate);
                                //  var_dump($EndDate);
                                //  echo $Demande["Status"] ;

                                if($Demande["Status"]=="Accepter"&& $StartDate < $todaysDate && $EndDate > $todaysDate){
                                    ?>
                                     <div class="app__LocationsEnCour">
                                        <p class="app__annonceInfoTitre">Location en Cours : </p>

                                    </div>
                                    <p>
                                        <?php
                                             echo ($Demande["UsernameClient"]);
                                            echo " est entrain de louer cet objet depuis  : ";
                                            echo ($Demande["DateDebutLoc"]);
                                            echo " jusqu'a ";
                                            echo ($Demande["DateFinLoc"]);
                                        ?>
                                    </p>
                                    <?php
                                }
                            }}
                        }
                            ?>
                            <?php

                           }

                        }
                        ?>
                    </div>

                </div>
                <div class="app__annoncePartenaire">
                    <div>
                        <img src="data:image/jpeg;base64,<?php echo base64_encode($partenaire['ImagePartenaire']); ?>" class="app__annoncePartenaireImage" />
                    </div>
                    <div class="app__annoncePartenaireNom">
                        <p class="app__annoncePartenaireTitre">
                            Nom d'utilisateur :
                        </p>
                        <p>
                            {{$partenaire['UsernamePartenaire']}}
                        </p>
                    </div>
                    <div class="app__annoncePartenaireNom">
                        <p class="app__annoncePartenaireTitre">
                            Adresse :
                        </p>
                        <p>
                            {{$partenaire['AdressePartenaire']}}
                        </p>
                    </div>
                    <div class="app__annoncePartenaireNom">
                        <p class="app__annoncePartenaireTitre">
                            Tél :
                        </p>
                        <p>
                            {{$partenaire['TelPartenaire']}}
                        </p>
                    </div>
                    <div class="app__annoncePartenaireNom">
                        <p class="app__annoncePartenaireTitre">
                            Email :
                        </p>
                        <p>
                            {{$partenaire['EmailPartenaire']}}

                        </p>
                    </div>
                    <div class="app__annoncePartenaireRating">
                        <div class="app__annonceRating app__annonceRating2">
                            {{-- <?php
                                // var_dump($notePartenaire);
                                ?> --}}
                            <input id="input-2" name="input-2" class="rating rating-loading" data-min="0" data-max="5"
                                data-step="0.1" disabled value="{{$notePartenaire['AVG(Notepartenaires)']}}">
                        </div>
                    </div>
                </div>
            </div>


            <div class="app__annonceCommentairesContainer">

                <?php
                $i = 0;
                $i2=0 ;
                foreach ($avisObjet as $avis) {
                //  var_dump($avis);
                    if($avis["positif"]=="oui"){
                        if($i2==0){
                                ?>
                                  <div class="app__annonceCommentaireTitre">
                                    <p class="app__annonceInfoTitre">Commentaires positifs : </p>
                                </div>
                                <?php

                            $i2=1 ;
                        }
                        ?>

                <div class="app__annonceCommentaires">
                    <div class="app__annonceCommentaireContainer">
                        <img src="data:image/jpeg;base64,<?php echo base64_encode($avis['ImageClient']); ?>" class="app__annonceImageUtilisateur" />
                        <div class="app__annonceCommentaireDesc">
                            <div class="annonceCommentaireTop">
                                <p class="app__annonceCommentaireNom">
                                    {{$avis["UsernameClient"]}}
                                </p>
                                <div class="app__annonceCommentaireRating">
                                    <div class="app__annonceRating app__annonceRating2">
                                        <input id="input-3" name="input-3" class="rating rating-loading" data-min="0"
                                            data-max="5" disabled data-step="0.1" value="{{$avis["NoteObjet"]}}">
                                    </div>
                                </div>

                            </div>
                            <div class="app__annonceCommentaireContent">
                                {{$avis["CommentaireObjet"]}}
                            </div>
                        </div>
                        <div class="app__annonceCommentaireTime">
                            <p> <span class="app__annonceCommentaireDate">{{$avis["DateAvisObjet"]}}</span></p>
                        </div>
                    </div>


                </div>
                <?php
                }
                }
                ?>


                <?php


                $i = 0;
                $i2=0 ;

                foreach ($avisObjet as $avis) {

                    if(!isset($avis)){

                        ?>
                         <div class="app__annonceCommentaireTitre">
                            <p class="app__annonceInfoTitre">Commentaires négatifs : </p>
                        </div>
                        <div class="app__annonceCommentaires">

                            <div class="app__annonceCommentaireContainer">
                                <div class="app__annonceCommentaireDesc">

                                    <div class="app__annonceCommentaireContent">
                                        Aucun commentaire négatif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                        }
                    if($avis["positif"]=="non"){

                        if($î2==0){
                                ?>
                                 <div class="app__annonceCommentaireTitre">
                                    <p class="app__annonceInfoTitre">Commentaires négatifs : </p>
                                </div>
                                <?php

                            $i2=1 ;

                        }
                        ?>
                        <?php

                ?>
                <div class="app__annonceCommentaires">

                    <div class="app__annonceCommentaireContainer">
                        <img src="/img/Akil.png" class="app__annonceImageUtilisateur" />
                        <div class="app__annonceCommentaireDesc">
                            <div class="annonceCommentaireTop">
                                <p class="app__annonceCommentaireNom">
                                    {{$avis["UsernameClient"]}}
                                </p>
                                <div class="app__annonceCommentaireRating">
                                    <div class="app__annonceRating app__annonceRating2">
                                        <input id="input-3" name="input-3" class="rating rating-loading" data-min="0"
                                            data-max="5" disabled data-step="0.1" value="{{$avis["NoteObjet"]}}">
                                    </div>
                                </div>

                            </div>
                            <div class="app__annonceCommentaireContent">
                                {{$avis["CommentaireObjet"]}}
                            </div>
                        </div>
                        <div class="app__annonceCommentaireTime">
                            <p> <span class="app__annonceCommentaireDate">{{$avis["DateAvisObjet"]}}</span></p>
                        </div>
                    </div>


                </div>
                <?php

                }
                }?>


              </div>

             </div>


    </main>
    <footer class="app__footer">
        <div class="app__footerContent">
            <div class="app__LogoDesc">
                <img src="/img/logo.png" class="app__footerLogo" />
                <p class="app__footerDesc">
                    Nous permettons aux utilisateurs de louer du matériel
                    ou de le proposer à la location à d'autres
                    utilisateurs.
                </p>
            </div>
            <div class="app__footerOptions">
                <p class="app__footerOption">Acceuil</p>
                <p class="app__footerOption">À propos</p>
                <p class="app__footerOption">Contrat</p>
                <p class="app__footerOption">Publier</p>
            </div>
            <div class="app__socials">
                <p class="app__footerSocial">Facebook</p>
                <p class="app__footerSocial">Instagram</p>
                <p class="app__footerSocial">Twitter</p>
                <p class="app__footerSocial">LinkedIn</p>
            </div>
            <div class="app__conatct">
                <p class="app__ContactDesc">
                    N'hésitez pas à nous contacter par téléphone
                    ou à nous envoyer un message.
                </p>
                <p class="app__ContactDesc">
                    +212654638657
                </p>
                <p class="app__ContactDesc">
                    LocHere.ma
                    <i class="fa fa-solid fa-copyright"></i>
                </p>
            </div>
        </div>

    </footer>

</body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js" integrity="sha256-4iQZ6BVL4qNKlQ27TExEhBN1HFPvAvAMbFavKKosSWQ=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-daterangepicker/3.0.5/daterangepicker.min.js" integrity="sha256-zI6VVO07NPmVW11q3RQE42YbRmJIkkunrcQ9LEYxJsQ=" crossorigin="anonymous"></script>
</html>
