<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/LOC_HERE.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <!-- <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css"> -->
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous"> -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-daterangepicker/3.0.5/daterangepicker.min.css" integrity="sha256-VVbO1uqtov1mU6f9qu/q+MfDmrqTfoba0rAE07szS20=" crossorigin="anonymous" />

    <!------ Include the above in your HEAD tag ---------->
    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/bootstrap/3/css/bootstrap.css" />
    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.css" />

    <!-- JS -->
    <script type="text/javascript" src="//cdn.jsdelivr.net/jquery/1/jquery.min.js"></script>
    <script type="text/javascript" src="//cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.js"></script>

    <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js"></script> -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"></script>



    <script src="Content/rating.js"></script>
    <link rel="stylesheet" href="css/LOC_HERE.css">


    <title>LOC HERE</title>
</head>

<body class="app__Inscrire">

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
                                <span class="badge">+</span>
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
                                <p class="app__SIgnInPar">{{ $partenaire->UsernamePartenaire}}</p>
                            </button>
                        </span>
                    {{-- </form> --}}
                    <div class="dropdown-content">
                        <form  method="post" action='{{route('profile',["id"=>$partenaire->id,"type"=>"partenaire"]) }}'>
                        @csrf
                        <button type="submit" class="exploreMoreProducts exploreMoreProducts3">
                            <p class="">Profil</p>
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
                        <span class="badge">+</span>
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
                            <p class="app__SIgnInPar connexion">Se deconnecter</p>
                        </button>
                    </form>
                  @endif
                  @elseif(!empty($partenaire))
                     @if($partenaire->NomPartenaire)
                  <form  method="get" action='{{route('login') }}'>
                    @csrf
                    <button type="submit" class="exploreMoreProducts">
                        <p class="app__SIgnInPar connexion">Se deconnecter</p>
                    </button>
                </form>
                @endif
                  @else
                  <form  method="get" action='{{route('login') }}'>
                    @csrf
                    <button type="submit" class="exploreMoreProducts">
                        <p class="app__SIgnInPar connexion">Se connecter</p>
                    </button>
                </form>
                  @endif
                </div>
            </div>
        </div>
        <hr class="app__headerBreak" />
    </header>

    <!-- ************* Profil client*************************** -->
    <main class="sectionrating">
        <div class="mainscreen">
        <div class="card">
            <div class="leftside1">
                <?php
                
            if(isset($type)){
                if($type=='client'){
                    ?>
            <center>
            <form class="The_form" enctype="multipart/form-data" action="{{route('profile',["id"=>$ProfileClient['id'],"type"=>"client"])}}" method='post'>
                 @csrf

                 <?php
                    if($ProfileClient["ImageClient"]){
                            ?>
                                  <img class="product" src="data:image/jpeg;base64,{{ chunk_split(base64_encode($ProfileClient["ImageClient"])) }}"/>
                            <?php
                        }
                        else {
                            ?>
                            <P>
                                Ajouter votre image
                            </P>
                            <?php
                        }
                    ?>
                  <div>
                    <input type="file" name="fichier" id="fichier" placeholder="Changer image" class="fichierStyling2">
                </div>
                <div class="app__annonceRating ">
                
                    <p>
                        <?php
                          echo $NoteClient["AVG(Noteclients)"]; ?> <center>rated</center><?php
                          ?>
                    </p>
                    
                    <?php

                    if($NoteClient["AVG(Noteclients)"] <=1 && $NoteClient["AVG(Noteclients)"] >0){
                        ?>
                         <div class="small-ratings">
                            <i class="fa fa-star rating-color"></i>
                        </div>
                        <?php
                    }
                    else if($NoteClient["AVG(Noteclients)"] <=2 && $NoteClient["AVG(Noteclients)"] >1){
                        ?>
                           <div class="small-ratings">
                            <i class="fa fa-star rating-color"></i>
                            <i class="fa fa-star rating-color"></i>
                        </div>
                        <?php
                    }
                    else if($NoteClient["AVG(Noteclients)"] <=3 && $NoteClient["AVG(Noteclients)"] >2){
                        ?>
                           <div class="small-ratings">
                            <i class="fa fa-star rating-color"></i>
                            <i class="fa fa-star rating-color"></i>
                            <i class="fa fa-star rating-color"></i>

                        </div>
                        <?php
                    }
                    else if($NoteClient["AVG(Noteclients)"] <=4 && $NoteClient["AVG(Noteclients)"] >3){
                        ?>
                           <div class="small-ratings">
                            <i class="fa fa-star rating-color"></i>
                            <i class="fa fa-star rating-color"></i>
                            <i class="fa fa-star rating-color"></i>
                            <i class="fa fa-star rating-color"></i>


                        </div>
                        <?php
                    }
                    else if($NoteClient["AVG(Noteclients)"] <=5 && $NoteClient["AVG(Noteclients)"] >4){
                        ?>
                           <div class="small-ratings">
                            <i class="fa fa-star rating-color"></i>
                            <i class="fa fa-star rating-color"></i>
                            <i class="fa fa-star rating-color"></i>
                            <i class="fa fa-star rating-color"></i>
                            <i class="fa fa-star rating-color"></i>


                        </div>
                        <?php
                    }
                    else if($NoteClient["AVG(Noteclients)"] ==0){
                        ?>
                           Not rated
                        <?php
                    }
                    ?>
                    


                  <input id="input-2" disabled name="input-2" class="rating rating-loading expand" data-min="0" data-max="5"
                      data-step="0.1" value="{{$NoteClient["AVG(Noteclients)"]}}"/>
              </div>
              </div>
                </center>
              <div class="rightside">
                        <h1>Profil</h1>
                <div class="">
                   <p>Nom d'utilisateur</p>
                    <input type="text" disabled class="inputbox" placeholder="Nickname" value="{{$ProfileClient['UsernameClient']}}" aria-label="Nickname" aria-describedby="basic-addon1" disabled>
                  </div>
<!-- 
                  {{-- <div class="app__annonceRating">
                    <input id="inputbox" name="input-1" class="rating rating-loading" data-min="0" data-max="5"
                        data-step="0.1" disabled value="{{$noteTotalObjet}}">
                </div> --}} -->
                    
                  <div class="">
                    <p>Nom</p>
                    <input type="text" class="inputbox" placeholder="Nickname" value="{{$ProfileClient['NomClint']}}" aria-label="Nickname" aria-describedby="basic-addon1" disabled>
                  </div>
                  <div class="">
                    <p>Prénom</p>
                    <input type="text" class="inputbox" placeholder="Nickname" value="{{$ProfileClient['PrenomClient']}}" aria-label="Nickname" aria-describedby="basic-addon1" disabled>
                  </div>
                <div class="">
                    <p>Ville</p>
                    <input type="text" name="Ville" class="inputbox" placeholder="Ville" value="{{$ProfileClient['Ville']}}" aria-label="Ville" aria-describedby="basic-addon1" >
                  </div>
                  <div class="">
                    <p>Adresse</p>
                    <input type="text" name="Adresse" class="inputbox" placeholder="Adresse" value="{{$ProfileClient['Adresse']}}" aria-label="Adresse" aria-describedby="basic-addon1" >
                  </div>
                  <div class="">
                    <p>Email</p>
                    <input type="email" class="inputbox" id="exampleInputEmail1" value="{{$ProfileClient['EmailClient']}}" placeholder="@example.com" aria-label="Email" aria-describedby="emailHelp" disabled>
                  </div>

                  <div class="">
                    <p>Téléphone</p>
                    <input type="tel" class="inputbox" name="Tel" placeholder="+212" value="{{$ProfileClient['Tel']}}" aria-label="numéro" >
                  </div>

                  <button class="button" type="submit">Modifier</button>
                 </form>
                  <!-- </div> -->
                  </div>
                  </div>
                  <!-- ********** -->
                  </div>
                  
                  </main>

<!-- Profil partenaire -->
        <!-- <main class="sectionrating">  -->
        <!-- <div class="mainscreen"> -->
        <!-- <div class="card"> -->
        <div class="leftside1">
          <?php
        }
        if($type=='partenaire'){

            ?>
            <center>
            <form class="The_form" enctype="multipart/form-data" action="{{route('profile',["id"=>$ProfilePartenaire['id'],"type"=>"partenaire"])}}" method='post'>
                @csrf
                <!-- <div class="app__nextToImage"> -->

                <?php
                if($ProfilePartenaire["ImagePartenaire"]){
                    ?>
                    
                    
                <img class="product"  src="data:image/jpeg;base64,{{ chunk_split(base64_encode($ProfilePartenaire["ImagePartenaire"])) }}"/>
                    
                    <?php
                }
                else {
                                        ?>
                            <P>
                                Ajouter votre image
                            </P>
                            <?php
                        }
            ?>
            <div>
                <input type="file" name="fichier" id="fichier" placeholder="Changer image" class="fichierStyling2">
            </div>
            <div class="app__annonceRating ">
                <p>
                    <?php
                      echo $NotePartenaire["AVG(Notepartenaires)"]; ?> rated<?php
                      ?>
                </p>
                <?php

                if($NotePartenaire["AVG(Notepartenaires)"] <=1 && $NotePartenaire["AVG(Notepartenaires)"] >0){
                    ?>
                     <div class="small-ratings">
                        <i class="fa fa-star rating-color"></i>
                    </div>
                    <?php
                }
                else if($NotePartenaire["AVG(Notepartenaires)"] <=2 && $NotePartenaire["AVG(Notepartenaires)"] >1){
                    ?>
                       <div class="small-ratings">
                        <i class="fa fa-star rating-color"></i>
                        <i class="fa fa-star rating-color"></i>
                    </div>
                    <?php
                }
                else if($NotePartenaire["AVG(Notepartenaires)"] <=3 && $NotePartenaire["AVG(Notepartenaires)"] >2){
                    ?>
                       <div class="small-ratings">
                        <i class="fa fa-star rating-color"></i>
                        <i class="fa fa-star rating-color"></i>
                        <i class="fa fa-star rating-color"></i>

                    </div>
                    <?php
                }
                else if($NotePartenaire["AVG(Notepartenaires)"] <=4 && $NotePartenaire["AVG(Notepartenaires)"] >3){
                    ?>
                       <div class="small-ratings">
                        <i class="fa fa-star rating-color"></i>
                        <i class="fa fa-star rating-color"></i>
                        <i class="fa fa-star rating-color"></i>
                        <i class="fa fa-star rating-color"></i>


                    </div>
                    <?php
                }
                else if($NotePartenaire["AVG(Notepartenaires)"] <=5 && $NotePartenaire["AVG(Notepartenaires)"] >4){
                    ?>
                       <div class="small-ratings">
                        <i class="fa fa-star rating-color"></i>
                        <i class="fa fa-star rating-color"></i>
                        <i class="fa fa-star rating-color"></i>
                        <i class="fa fa-star rating-color"></i>
                        <i class="fa fa-star rating-color"></i>


                    </div>
                    <?php
                }
                else if($NotePartenaire["AVG(Notepartenaires)"] ==0){
                    ?>
                       Not rated
                    <?php
                }
                ?>


              <input id="input-2" disabled name="input-2" class="rating rating-loading expand" data-min="0" data-max="5"
                  data-step="0.1" value="{{$NotePartenaire["AVG(Notepartenaires)"]}}"/>
                 </div>
              </div>
              <!-- ** -->
            
            </center>
            
            
              <div class="rightside">
              <h1>Profil</h1>
                <div class="">
                <p>Nom d'utilisateur</p> 
                <input type="text" disabled class="inputbox" placeholder="Nickname" value="{{$ProfilePartenaire['UsernamePartenaire']}}" aria-label="Nickname" aria-describedby="basic-addon1" disabled>
                </div>
                <div class="app__annonceRating app__annonceRating2">
                <input id="input-2" name="input-2" class="rating rating-loading" data-min="0" data-max="5"
                    data-step="0.1" value="{{$NotePartenaire["AVG(Notepartenaires)"]}}">
                </div>
                <div class="">
                <p>Nom</p>
                <input type="text" class="inputbox" placeholder="Nickname" value="{{$ProfilePartenaire['NomPartenaire']}}" aria-label="Nickname" aria-describedby="basic-addon1" disabled>
                </div>
                <div class="">
                <p>Prénom</p>
                <input type="text" class="inputbox" placeholder="Nickname" value="{{$ProfilePartenaire['PrenomPartenaire']}}" aria-label="Nickname" aria-describedby="basic-addon1" disabled>
                </div>
             <div class="">
                <p>Ville</p>
                <input type="text" name="Ville" class="inputbox" placeholder="Ville" value="{{$ProfilePartenaire['Ville']}}" aria-label="Ville" aria-describedby="basic-addon1" >
                </div>
                <div class="">
                <p>Adresse</p>
                <input type="text" name="Adresse" class="inputbox" placeholder="Adresse" value="{{$ProfilePartenaire['AdressePartenaire']}}" aria-label="Adresse" aria-describedby="basic-addon1" >
                </div>
                <div class="">
                <p>Email</p>
                <input type="email" class="inputbox" id="exampleInputEmail1" value="{{$ProfilePartenaire['EmailPartenaire']}}" placeholder="@example.com" aria-label="Email" aria-describedby="emailHelp" disabled>
                </div>

                <div class="">
                <span class="input-group-text" id="basic-addon1">Tel</span>
                <input type="tel" class="inputbox" name="Tel" placeholder="+212" value="{{$ProfilePartenaire['TelPartenaire']}}" aria-label="numéro" >
                </div>

                <button class="button" type="submit">Confirmer</button>
            </form>
            </div>
            </div>
            </div>
            <!-- ******* -->
            </div>
            </main>


            <?php
        }

    }
    ?>


<!-- ********************************************** -->
<!-- commentaires client -->
<?php
    if(isset($type)){
                if($type=='client'){

?>
<div class="app__annonceCommentairesContainer">
    <div class="app__annonceCommentaireTitre">
        <p class="app__annonceInfoTitre">Commentaires positifs </p>
    </div>
    <?php
    $i = 0;

    foreach ($avisClient as $avis2) {

        $avis = (array)$avis2  ;

        if($avis["positif"]=="oui"){


    ?>
        <div class="user-card col-md-3" style = "margin-left: 10px;">

        <span class="avatar-holder">
            <img src="/img/Akil.png" class="" />
                <span class="user-info-holder"> 
                    <h2 class="name"> {{$avis["UsernamePartenaire"]}}</h2>
                </span>
                    <div class="app__annonceCommentaireRating">
                        <div class="app__annonceRating app__annonceRating2">
                            <input id="input-3" name="input-3" class="rating rating-loading" data-min="0"
                                data-max="5" disabled data-step="0.1" value="{{$avis["Noteclients"]}}">
                        </div>
                    </div>
                <span class="desc">
                    <p>{{$avis["Commentaireclients"]}}</p>
                </span>
            <div class="">
                <p> <span class="star-text evaluation-text">{{$avis["DateAvisclients"]}}</span></p>
            </div>

        </span>
        </div>
        <?php
        }
        }
        ?>
        </div>
        <div class="app__annonceCommentairesContainer1">
        <div class="app__annonceCommentaireTitre1">
            <p class="app__annonceInfoTitre">Commentaires négatifs </p>
        </div>

        <?php


        $i = 0;

        foreach ($avisClient as $avis2) {

            $avis = (array)$avis2  ;
            if(!isset($avis)){

                ?>
                <div class="app__annonceCommentaires">

                    <div class="app__annonceCommentaireContainer">
                        <div class="app__annonceCommentaireDesc">

                            <div class="app__annonceCommentaireContent">
                                Aucun commentaire positif
                            </div>
                        </div>

                    </div>


            </div>
            <?php

            }

        if($avis["positif"]=="non"){


     ?>
        <div class="user-card1 col-md-3" style = "margin-left: 10px;">
            <span class="avatar-holder">
            <img src="/img/Akil.png" class="app__annonceImageUtilisateur" />
                <span class="user-info-holder"> <h2 class="name"> {{$avis["UsernamePartenaire"]}}</h2></span>
                    <div class="">
                        <div class="">
                            <input id="input-3" name="input-3" class="rating rating-loading" data-min="0"
                                data-max="5" disabled data-step="0.1" value="{{$avis["Noteclients"]}}">
                        </div>
                    </div>
                <span class="desc">
                    <p>{{$avis["Commentaireclients"]}}</p>
                </span>
            <div class="">
                <p> <span class="star-text evaluation-text">{{$avis["DateAvisclients"]}}</span></p>
            </div>
        </span>
       </div>
      <?php

        }
        }?>


  </div>
    </div>
    <!-- ************** -->
    </div>
    <!-- </div>  -->
 
<!-- ***************** -->
  <?php
}
}
?>



<!-- commentaires partenaire -->
<?php
    if(isset($type)){
                if($type=='partenaire'){

?>
<div class="app__annonceCommentairesContainer">
    <div class="app__annonceCommentaireTitre">
        <p class="app__annonceInfoTitre">Commentaires positifs </p>
    </div>
    <?php
    $i = 0;

    foreach ($avisPartenaire as $avis2) {

        $avis = (array)$avis2  ;

        if($avis["positif"]=="oui"){


    ?>
        <div class="user-card col-md-3" style = "margin-left: 10px;">

        <span class="avatar-holder">
            <img src="/img/Akil.png" class="" />
                <span class="user-info-holder"> 
                    <h2 class="name"> {{$avis["UsernameClient"]}}</h2>
                </span>
                    <div class="app__annonceCommentaireRating">
                        <div class="app__annonceRating app__annonceRating2">
                            <input id="input-3" name="input-3" class="rating rating-loading" data-min="0"
                                data-max="5" disabled data-step="0.1" value="{{$avis["Notepartenaires"]}}">
                        </div>
                    </div>
                <span class="desc">
                    <p>{{$avis["Commentairepartenaires"]}}</p>
                </span>
            <div class="">
                <p> <span class="star-text evaluation-text">{{$avis["DateAvispartenaires"]}}</span></p>
            </div>

        </span>
        </div>
        <?php
        }
        }
        ?>
        </div>
   
    </div>
        <div class="app__annonceCommentairesContainer1">
        <div class="app__annonceCommentaireTitre1">
            <p class="app__annonceInfoTitre">Commentaires négatifs </p>
        </div>

        <?php


        $i = 0;

        foreach ($avisPartenaire as $avis2) {

            $avis = (array)$avis2  ;
            if(!isset($avis)){

                ?>
                <div class="app__annonceCommentaires">

                    <div class="app__annonceCommentaireContainer">
                        <div class="app__annonceCommentaireDesc">

                            <div class="app__annonceCommentaireContent">
                                Aucun commentaire positif
                            </div>
                        </div>

                    </div>


            </div>
            <?php

            }

        if($avis["positif"]=="non"){


     ?>
        <div class="user-card1 col-md-3" style = "margin-left: 10px;">
            <span class="avatar-holder">
            <img src="/img/Akil.png" class="app__annonceImageUtilisateur" />
                <span class="user-info-holder"> <h2 class="name"> {{$avis["UsernameClient"]}}</h2></span>
                    <div class="">
                        <div class="">
                            <input id="input-3" name="input-3" class="rating rating-loading" data-min="0"
                                data-max="5" disabled data-step="0.1" value="{{$avis["Notepartenaires"]}}">
                        </div>
                    </div>
                <span class="desc">
                    <p>{{$avis["Commentairepartenaires"]}}</p>
                </span>
            <div class="">
                <p> <span class="star-text evaluation-text">{{$avis["DateAvispartenaires"]}}</span></p>
            </div>
        </span>
       </div>
      <?php

        }
        }?>


  </div>
    </div>
  
  <?php
}
}
?>






    <footer class="app__footer">
        <div class="app__footerContent">
            <div class="app__LogoDesc">
                <img src="img/logo.png" class="app__footerLogo" />
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

</html>
