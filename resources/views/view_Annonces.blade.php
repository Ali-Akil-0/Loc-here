<?php
ini_set('memory_limit', '1024M');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/LOC_HERE.css ">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script> -->
    <!-- <script>
        // $(document).ready(function() {
        //     $("button").click(function() {
        //         $("#div1").load("demo_test.txt");
        //     });
        // });
    </script> -->
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


    <main class="app__inscriptionMain app__acceuilMain">
        <div class="app__acceuilBanner">
            <div class="app__bannerTitre  app__annoncesTitre">
                <div class="app__bannerRecherche app__annoncesRecherche">
                    <div class="app_blurredBackground app__annoncesBlurred">
                    </div>
                    <div class="app__barDeRecherche">
                        <form  enctype="multipart/form-data" class="app__rechercheForm" method="POST" action=''>
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
                                    <option value="<?php echo $ville2['NomVille']; ?>" default><?php echo $ville2['NomVille'];  ?></option>
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
        <div class="app__annoncesContenuTitre">
            <p class="app__annoncesTitreAll">Toutes les annonces</p>
            <p class="app__annoncesTitre"></p>

        </div>
        <div class="app__annoncesListe">
            <?php
            $i = 0;
            foreach ($annonces as $annonce) {
                $canwork = 0 ;


                $test = (array)$annonce;
                if(isset($checkIflocated)){

                    foreach($checkIflocated as $checking){
                    $checking2 = (array)$checking ;
                    if($checking2["IDANnonce"]==$test["IdAnnonce"]){
                    $canwork = 1 ;
                  }
                }

            }

            if($canwork==0){

            ?>
            @if(isset($CatRechercher))
            @if($test[" NomObjet"]==$titreRechercher && $test["NomCategorie"]==$CatRechercher && $test["PrixObjet"] <$prixRechercher && $test["VilleObjet"]==$villeRechercher)
            <div class="app__annoncesAnnonce">
                <div class="app__annoncesImageContainer">
                    {{-- {{$test["Image"]}} --}}
                    {{-- "data:image/jpeg;base64,<?php echo base64_encode($image); ?>" --}}
                    {{-- "data:image/jpg;base64,'.base64_encode($row[{{$test["Image"]}}]).'" --}}
                    <img src="data:image/jpeg;base64,<?php echo base64_encode($test["Image"]); ?>" class="app__annoncesImage" />
                </div>
                <div class="app__annoncesContenu">
                    <p class="app__annoncesNom">
                        @if(isset($type))
                        <?php
                        $some = $test["IdAnnonce"];
                        ?>
                        @if($type=="client")
                        <form  action='{{route('annonce',['id' => $client->id, 'type'=>"client",'idAnnonce'=>$test["IdAnnonce"]]) }}' method="POST" >
                            @csrf
                            <button type="submit" class="exploreMoreProducts">
                                {{$test[" NomObjet"]}}
                            </button>
                        </form>
                        @elseif($type=="partenaire")
                      <form action='{{route('annonce',['id' => $client->id, 'type'=>"partenaire",'idAnnonce'=>$test["IdAnnonce"]]) }}' method="POST">
                        @csrf
                        <button type="submit" class="exploreMoreProducts">
                            {{$test[" NomObjet"]}}
                          </button>
                      </form>
                      @endif
                      @else
                      <form action='{{route('annonce',['idAnnonce'=>$test["IdAnnonce"]])}}' method="POST">
                        @csrf
                        <button type="submit" class="exploreMoreProducts">
                            {{$test[" NomObjet"]}}
                          </button>
                          </form>
                      @endif
                        {{-- <p class="app__annonceNomPremium">[ Premium ]</p> --}}
                    </p>
                    <p class="app__annoncesUtilisateur">
                        {{$test["UsernamePartenaire"]}}
                    </p>
                    <p class="app__annoncesDescription">
                        {{$test["DescriptionObjet"]}}
                    </p>
                </div>
                <div class="app__annoncesPrixContainer app__annoncesPrixContainer2">
                    <p class="app__annoncePrix40">
                            {{$test["PrixObjet"]}}
                        DH / Jour
                    </p>
                </div>

            </div>
            @endif
            @else


            <div class="app__annoncesAnnonce">
                <div class="app__annoncesImageContainer">
                    {{-- {{$test["Image"]}} --}}
                    {{-- "data:image/jpeg;base64,<?php echo base64_encode($image); ?>" --}}
                    {{-- "data:image/jpg;base64,'.base64_encode($row[{{$test["Image"]}}]).'" --}}
                    <img src="data:image/jpeg;base64,{{ chunk_split(base64_encode($test["Image"])) }}"  class="app__annoncesImage" />
                </div>
                <div class="app__annoncesContenu">
                    <p class="app__annoncesNom">
                        @if(isset($type))
                        <?php
                        $some = $test["IdAnnonce"];
                        ?>
                        @if($type=="client")
                        <form  action='{{route('annonce',['id' => $client->id, 'type'=>"client",'idAnnonce'=>$test["IdAnnonce"]]) }}' method="POST" >
                            @csrf
                            <button type="submit" class="exploreMoreProducts">
                                {{$test[" NomObjet"]}}
                            </button>
                        </form>
                        @elseif($type=="partenaire")
                      <form action='{{route('annonce',['id' => $partenaire->id, 'type'=>"partenaire",'idAnnonce'=>$test["IdAnnonce"]]) }}' method="POST">
                        @csrf
                        <button type="submit" class="exploreMoreProducts">
                            {{$test[" NomObjet"]}}
                          </button>
                      </form>
                      @endif
                      @else
                      <form action='{{route('annonceOff',['idAnnonce'=>$test["IdAnnonce"]])}}' method="POST">
                        @csrf
                        <button type="submit" class="exploreMoreProducts">
                            {{$test[" NomObjet"]}}
                          </button>
                          </form>
                      @endif
                        {{-- <p class="app__annonceNomPremium">[ Premium ]</p> --}}
                    </p>
                    <p class="app__annoncesUtilisateur">
                        {{$test["UsernamePartenaire"]}}
                    </p>
                    <p class="app__annoncesDescription">
                        {{$test["DescriptionObjet"]}}
                    </p>
                </div>
                <div class="app__annoncesPrixContainer app__annoncesPrixContainer2">
                    <p class="app__annoncePrix40">
                            {{$test["PrixObjet"]}}
                        DH / Jour
                    </p>
                </div>
              </div>

            @endif


            <?php
            }
            $canwork = 0 ;
            }
            ?>



        </div>
        <div class="app__annoncesPages">
            <p class="app__pagesTitre">

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
