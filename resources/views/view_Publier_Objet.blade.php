<!DOCTYPE html>
<html lang="en">
    <head>

        <link rel="stylesheet" href="/css/LOC_HERE.css">
        <!-- <link rel="stylesheet" href="/css/cssoublierobjet.css"> -->
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

        <link rel="stylesheet" href="https://codepen.io/gymratpacks/pen/VKzBEp#0">
        <link href='https://fonts.googleapis.com/css?family=Nunito:400,300' rel='stylesheet' type='text/css'>


        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="css/LOC_HERE.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">


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
                <!-- **** -->
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
                            <div class="dropdown notification">
                                <span>
                                    <button type="submit" class="exploreMoreProducts">
                                        <div class="notBtn">
                                            <div class="number1">+</div>
                                    <i class="fa fa-solid fa-bell"></i>
                                    <div class="box">
                                        <div class="display">
                                            <div class="nothing">
                                                <i class="fas fa-child stick"></i>
                                                <div class="cent">Looks like you re all caught up!</div>
                                                </div>
                                </button></span>
                                <div class="cont">
                                    <div class="sec new">
                                    <a href = "https://codepen.io/Golez/">
                                        <!-- <div class="profCont">
                                            
                                        </div> -->
                                <div class="dropdown-content txt">

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
                                        </div>
                                        </a>
                                        </a>
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

<!-- **********form ajouter annonce********************** -->
        <!-- <main class="app__InscriptionMain app__acceuilMain"> -->
            <center>
            <div  class="row">
                <div class="col-md-12">
                <form id="objform" enctype="multipart/form-data" action="{{route('add',['id' => $partenaire->id ])}}"  method="post">
                    {{ method_field('POST') }}
                    @method("POST")
                    @csrf
                    {{-- {!! Form::token() !!} --}}
                    <h1 class="titrenvlannonce">Nouvelle annonce</h1>
                    <!-- <div class="container">
                        <div class="left"> -->
                            <fieldset class="objfieldset">
                                <legend class="objlegend"><span class="number">i</span>Veuillez remplir les informations</legend>
                               
                        <!-- </div> -->
                        <!-- <div class="right"> -->
                            <!-- input nom de lobjet -->
                            <label for="nomObjet" class="objetaj">Nom objet</label>
                            <input type="text" id="name" name="nomObjet" class="objinput" placeholder="Nom Objet">
                            <!-- select caategorie -->
                            <label for="categorie" class="objetaj">Catégorie de l'objet</label>
                            <select class="objselect" id="job" name="categorie">
                                <?php
                                    $i = 0;
                                    foreach ($categories as $categorie2) {

                                ?>
                                <option value="<?php echo $categorie2["IdCategorie"]; ?>"><?php echo $categorie2["NomCategorie"];; ?></option>
                                <?php
                                 }
                                ?>
                            </select>
                             <!-- select ville -->
                             <label for="ville" class="objetaj">Ville</label>
                            <select class="objselect" id="job" name="ville">
                                <?php
                                    $i = 0;
                                    foreach ($villes as $ville) {

                                ?>
                                <option value="<?php echo $ville["NomVille"]; ?>"><?php echo $ville["NomVille"]; ?></option>
                                <?php
                                 }
                                ?>
                            </select>

                            {{-- <input  type="text" name="ville" placeholder="Ville" class="objinput"> --}}
                            <label for="prix" class="objetaj">Prix /J</label>
                            <select class="objselect" name="prix" id="job">
                                <option value="50">50 Dhs</option>
                                <option value="100">100 Dhs</option>
                                <option value="150">150 Dhs</option>
                                <option value="200">200 Dhs</option>
                                <option value="250">250 Dhs</option>
                                <option value="300">300 Dhs</option>
                                <option value="450">450 Dhs</option>
                                <option value="500">500 Dhs</option>
                                <option value="550">550 Dhs</option>
                                <option value="600">600 Dhs</option>
                            </select>
                            <label for="descriptionObjet" class="objetaj">Description de l'objet</label>
                                <textarea class="objtextarea" id="bio" name="descriptionObjet" placeholder="Description de l'objet"></textarea>
                            <!-- <input type="text" name="prix" placeholder="Prix/J"> -->
                        <!-- </div>
                    </div> -->
                    <!-- <div class="annonce-phase"> -->

                        <label for="fichier" class="objetaj">Ajoutez image de l'objet</label>
                        <input type="file" name="fichier" id="fichier" class="objinput">
                                 <br><br>

                        <label for="premium" class="objetaj">Vous&nbsp;voulez&nbsp;optez&nbsp;pour&nbsp;une&nbsp;annonce&nbsp;Premium&nbsp;?</label>
                        <input type="checkbox" id="development" name="premium" value="oui" class="objinput">
                    
                        <label for="Dureepremium" class="objetaj">Duree du premium</label>
                        <select class="objselect" name="Dureepremium" id="job">
                            <option value="7">7 jours</option>
                            <option value="15">15 jours</option>
                            <option value="30">30 jours</option>
                        </select>
                    <!-- </div> -->


                    <!-- <div class="app__dateDeDisponibilite"> -->
                        <label for="daterange" class="objetaj">Date de disponibilité</label>
                        <input type="text" class="daterange objinput"  name="date"/>
                        <p>
                            </p>
                        <script>
                            $(function() {
                               $('.daterange').daterangepicker();
                            })
                            </script>
                         <?php
                        // }
                        ?>

                    <!-- </div> -->
                            <legend class="objlegend"><span class="number">NB</span>Afficher votre annonce sur la première page pendant une semaine, 15 jours ou un mois, grâce à l'offre Premium.</legend>
                    <!-- <p class="P-Premium">Afficher votre annonce sur la première page pendant une semaine, 15 jours ou mois, grâce à l'offre Premium.</p> -->
                        </fieldset>
                    <!-- <div class="last"> -->
                        <button class="objbutton" type="submit" name="submit" value="Valider">Valider</button>
                    <!-- </div> -->
                </form>
            </div>
                        </div>
                        </center>
        <!-- </main> -->


        <!-- ******************************************************************** -->
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
