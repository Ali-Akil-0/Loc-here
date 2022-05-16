<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/LOC_HERE.css ">
    <meta charset="ISO-8859-1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
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
                    <form  method="get" action='{{route('profile') }}'>
                        @csrf
                        <button type="submit" class="exploreMoreProducts">
                            <p class="app__SIgnInPar">{{$client->UsernameClient}}</p>
                        </button>
                    </form>
                    {{-- <form  method="POST" action='{{route('Notes') }}'> --}}
                        {{-- @csrf --}}
                        <div class="dropdown">
                            <span>
                                <button type="submit" class="exploreMoreProducts">
                                <i class="fa fa-solid fa-bell"></i>
                            </button></span>
                            <div class="dropdown-content">
                                <?php
                                foreach ($CheckNoteClient as $data) {
                                        // var_dump($data);
                                if ($data["IdLocation"] != null) {



                                    ?>

                        <form method="post" action="{{route('Notes',['id' => $client->id, 'type'=>"client", 'idLocation'=>$data["IdLocation"]]) }}">
                            @method("POST")
                            @csrf
                            <button class="app__coloredButton" type="submit"> Merci de donner votre avis sur la location numéro : <?php echo $data["IdLocation"] ;  ?>   </button>
                        </form>
                                <?php
                                    }
                                }




                                ?>


                                <?php
                                    $nomObjet = null;
                                     foreach ($LocationsAccepter as $LocationAccepter) {
                                        foreach ($AllData as $data) {
                                            $test = (array)$data;
                                            if($test["IdAnnonce"]==$LocationAccepter["IDANnonce"]){
                                                // echo "test";
                                            // echo($test["IdAnnonce"]);
                                            // echo "test";
                                            // echo 'IDANnonce';
                                            // echo($LocationAccepter["IDANnonce"]);
                                            // echo 'IDANnonce';
                                            $nomObjet=$test[' NomObjet'];
                                                ?>
                                            <p>
                                                <?php
                                                    echo "Votre demande de location de l'objet : ";
                                                    echo $nomObjet;
                                                    echo " pendant : ";
                                                    echo $LocationAccepter["DateDebutLoc"] ;
                                                    echo " au ";
                                                    echo $LocationAccepter["DateFinLoc"] ;
                                                    echo " a été approuvé ";
                                                    ?>
                                            </p>
                                                <?php
                                            }
                                        }
                                       ?>


                                       <?php

                                     }

                                ?>
                                <?php


                                ?>


                                <?php

                                    foreach ($reclamations as $reclamation) {

                                        // var_dump($reclamations);

                                    if ($reclamation["ReponseReclam"]!=NULL) {
                                        $reponseAdminClient = $reclamation["ReponseReclam"];
                                        $idReclamationClient = $reclamation["IdReclamation"];
                                        if($reclamation["ReclamationLu"]=="non"){


                                    ?>
                                    <form method="POST" action="{{route('Reclamation',['id' => $client->id, 'type'=>"client",'IdReponse'=>$reclamation["IdReclamation"] ,"Reponse"=>$reclamation["ReponseReclam"] ,'lu'=>'non']) }}">
                                        @method("POST")
                                        @csrf
                                        <button class="app__coloredButton" type="submit">L'administrateur a repondu a votre reclamation (Sujet : <?php  echo $reclamation["ObjetReclam"];?>)  (message : <?php  echo $reclamation["ReponseReclam"];?>) </button>
                                    </form>
                                    <?php
                                     }
                                         ?>
                                         <?php
                                     }

                                     else if($reclamation["ReponseReclam"]==NULL && $reclamation["VueReclamationAdmin"]!="non" ){
                                            if($reclamation["ReclamationLu"]=="non"){

                                                ?>
                                            <p class="app__coloredButton" >L'administrateur a vu  votre reclamation (Sujet : <?php  echo $reclamation["ObjetReclam"];?>)  </p>
                                                <?php
                                            }

                                                ?>

                                                <?php
                                     }
                                    }
                                ?>

                                <?php

                                    foreach ($reclamations as $reclamation) {

                                        // var_dump($reclamations);

                                    if ($reclamation["ReponseReclam"]!=NULL) {
                                        $reponseAdminClient = $reclamation["ReponseReclam"];
                                        $idReclamationClient = $reclamation["IdReclamation"];
                                        if($reclamation["ReclamationLu"]=="oui"){


                                    ?>
                                   <form method="POST" action="{{route('Reclamation',['id' => $client->id, 'type'=>"client",'IdReponse'=>$reclamation["IdReclamation"] ,"Reponse"=>$reclamation["ReponseReclam"] ,'lu'=>'oui']) }}">
                                    @method("POST")
                                    @csrf
                                <button  type="submit">L'administrateur a repondu a votre reclamation (Sujet : <?php  echo $reclamation["ObjetReclam"];?>)  (message : <?php  echo $reclamation["ReponseReclam"];?>) </button>
                                </form>
                                    <?php
                                     }
                                         ?>
                                         <?php
                                     }
                                     else if($reclamation["ReponseReclam"]==NULL && $reclamation["VueReclamationAdmin"]!="non" ){
                                            if($reclamation["ReclamationLu"]=="oui"){
                                                ?>
                                                 <p >L'administrateur a vu  votre reclamation (Sujet : <?php  echo $reclamation["ObjetReclam"];?>)  </p>
                                                <?php
                                            }
                                                ?>

                                                <?php
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
                 <form  method="get" action='{{route('profile') }}'>
                    @csrf
                    <button type="submit" class="exploreMoreProducts">
                        <p class="app__SIgnInPar">{{ $partenaire->UsernamePartenaire}}</p>
                    </button>
                </form>
                <div class="dropdown">
                    <span>
                        <button type="submit" class="exploreMoreProducts">
                        <i class="fa fa-solid fa-bell"></i>
                    </button></span>
                    <div class="dropdown-content">


                        <?php

                        foreach ($reclamations as $reclamation) {

                            // var_dump($reclamations);

                        if ($reclamation["ReponseReclam"]!=NULL) {
                            $reponseAdminClient = $reclamation["ReponseReclam"];
                            $idReclamationClient = $reclamation["IdReclamation"];
                            if($reclamation["ReclamationLu"]=="non"){


                        ?>
                        <form method="POST" action="{{route('Reclamation',['id' => $partenaire->id, 'type'=>"partenaire",'IdReponse'=>$reclamation["IdReclamation"] ,"Reponse"=>$reclamation["ReponseReclam"] ,'lu'=>'non']) }}">
                            @method("POST")
                            @csrf
                            <button class="app__coloredButton" type="submit">L'administrateur a repondu a votre reclamation (Sujet : <?php  echo $reclamation["ObjetReclam"];?>)  (message : <?php  echo $reclamation["ReponseReclam"];?>) </button>
                        </form>
                        <?php
                         }
                             ?>
                             <?php
                         }

                         else if($reclamation["ReponseReclam"]==NULL && $reclamation["VueReclamationAdmin"]!="non" ){
                                if($reclamation["ReclamationLu"]=="non"){

                                    ?>
                                <p class="app__coloredButton" >L'administrateur a vu  votre reclamation (Sujet : <?php  echo $reclamation["ObjetReclam"];?>)  </p>
                                    <?php
                                }

                                    ?>

                                    <?php
                         }
                        }
                    ?>

                    <?php

                        foreach ($reclamations as $reclamation) {

                            // var_dump($reclamations);

                        if ($reclamation["ReponseReclam"]!=NULL) {
                            $reponseAdminClient = $reclamation["ReponseReclam"];
                            $idReclamationClient = $reclamation["IdReclamation"];
                            if($reclamation["ReclamationLu"]=="oui"){


                        ?>
                       <form method="POST" action="{{route('Reclamation',['id' => $partenaire->id, 'type'=>"partenaire",'IdReponse'=>$reclamation["IdReclamation"] ,"Reponse"=>$reclamation["ReponseReclam"] ,'lu'=>'oui']) }}">
                        @method("POST")
                        @csrf
                    <button  type="submit">L'administrateur a repondu a votre reclamation (Sujet : <?php  echo $reclamation["ObjetReclam"];?>)  (message : <?php  echo $reclamation["ReponseReclam"];?>) </button>
                    </form>
                        <?php
                         }
                             ?>
                             <?php
                         }
                         else if($reclamation["ReponseReclam"]==NULL && $reclamation["VueReclamationAdmin"]!="non" ){
                                if($reclamation["ReclamationLu"]=="oui"){
                                    ?>
                                     <p >L'administrateur a vu  votre reclamation (Sujet : <?php  echo $reclamation["ObjetReclam"];?>)  </p>
                                    <?php
                                }
                                    ?>

                                    <?php
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





    <main class="app__inscriptionMain app__acceuilMain">
        <div class="app__acceuilBanner">
            <div class="app__bannerTitre">
                <p class="app__bannerPar">

                    Sur <span class="app__LOCHERE">
                        LOC HERE
                    </span> vous pouvez louer des outils
                </p>
                <div class="app__bannerRecherche">
                    <div class="app_blurredBackground">
                    </div>
                    <div class="app__barDeRecherche">
                        <form enctype="multipart/form-data"  action='' method='POST'  class="app__rechercheForm" >
                            @method('POST')
                            @csrf
                            <div class="app__inputNom">
                                <input type="text" name="titre" class="app__AnnonceNom"
                                    placeholder="Quel outil souhaitez-vous louer ?" />
                            </div>
                            <div class="app__inputSelect">
                                <select id="Ville" name="Ville" placeholder="Ville">
                                    <option value="" disabled selected hidden>Ville</option>
                                    <?php
                                    $i = 0;
                                    foreach ($villes as $ville2) {
                                    ?>
                                    <option value="<?php echo $ville2['VilleObjet']; ?>" default><?php echo $ville2['VilleObjet'];  ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="app__inputSelect">
                                <select id="Categorie" name="Categorie">
                                    <option value="" disabled selected hidden>Categorie</option>
                                    <?php
                                    $i = 0;
                                    foreach ($categories as $categorie2) {
                                    ?>
                                    <option value="<?php echo $categorie2["NomCategorie"]; ?>" default><?php echo $categorie2["NomCategorie"];  ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                            {{-- <div class="app__inputSelect">
                                <select id="Disponibilite" name="Disponibilite">
                                    <option value="" disabled selected hidden>Disponibilite</option>
                                    <option value="<?php echo "oui"; ?>" default><?php echo "oui";  ?></option>
                                    <option value="<?php echo "non"; ?>" default><?php echo "non";  ?></option>


                                </select>
                            </div> --}}
                            <div class="app__inputSelect">
                                <select id="Prix" name="Prix">
                                    <option value="" disabled selected hidden>Prix</option>

                                    <?php

                                    $i = 0;
                                    for ($i = 1; $i < 7; $i++) {
                                    ?>
                                    <option value="<?php echo $i*100; ?>" default><?php echo "<".$i*100;  ?></option>
                                    <?php
                                    }

                                    ?>

                                </select>
                            </div>
                            <button class="app__annonceRechercheButton" type="submit">
                                Chercher
                            </button>
                        </form>

                    </div>






                </div>
            </div>
        </div>
        <div class="app__acceuilPremium">
            <div class="app__premiumTitre">
                <p class="app__premiumExplore">Explorer des produits incroyables</p>
                <p class="app__annoncesPremiumTitre">Annonces Premium</p>

            </div>



            <div class="app__annonces">
                <p>
                    <?php
                    if(isset( $_POST["titre"])){
                        echo "hetre" ;
                        echo  $_POST["titre"];
                        echo "hetre" ;
                    }
                    ?>
                </p>
                <?php
                $i = 0;
                foreach ($annonces as $annonce) {
                    $test = (array)$annonce;
                ?>
                <div class="app__annonce">
                    <img src="/img/remorque.jpg" class="app_annonceImage" />
                    <p class="app__annonceTitre">
                        {{$test[" NomObjet"]}}
                    </p>
                    <div class="app__annoncePrixContainer">
                        <p class="app__annoncePrix">
                              {{$test["PrixObjet"]}}
                            DH / Jour
                        </p>
                    </div>
                </div>
                <?php
                }
                ?>
            </div>
        </div>
        <div class="app__acceuilAutre">

            <p class="app__AutreTitre">
                {{-- <form action="{{route('plusDeProduits')}}" method='post'> --}}

                    @if(!empty($client))
                    {{-- {{Session::set('username', $client->UsernameClient);}} --}}

                    <form action='{{route('plusDeProduits',['id' => $client->id, 'type'=>"client"]) }}' method="post">
                        @csrf
                        <button type="submit" class="exploreMoreProducts">
                            Explorer autres produits
                        </button>
                    </form>
                    @elseif(!empty($partenaire))
                        @if(!empty($partenaire))
                  {{-- {{Session::set('username', $partenaire->UsernamePartenaire);}} --}}
                  <form action='{{route('plusDeProduits',['id' => $partenaire->id, 'type'=>"partenaire"]) }}' method="post">
                    @csrf
                    <button type="submit" class="exploreMoreProducts">
                    Explorer autres produits
                </button>
            </form>
            @endif
                  @else
                  <form action='{{route('plusDeProduits') }}' method="post">
                    @csrf
                    <button type="submit" class="exploreMoreProducts">
                    Explorer autres produits
                </button>
            </form>
                  @endif
            </p>
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
</html>
