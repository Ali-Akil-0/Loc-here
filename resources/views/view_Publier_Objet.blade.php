<!DOCTYPE html>
<html lang="en">
    <head>

        <link rel="stylesheet" href="/css/LOC_HERE.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script> -->
        <!-- <script>
            // $(document).ready(function() {
            //     $("button").click(function() {
            //         $("#div1").load("demo_test.txt");
            //     });
            // });
        </script> -->
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



        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="css/LOC_HERE.css">

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

                              <form  method="get" action='{{route('publier',['id' => $partenaire->id]) }}'>
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
                        <form  method="get" action='{{route('Notes') }}'>
                            @csrf
                            <button type="submit" class="exploreMoreProducts">
                                <i class="fa fa-solid fa-bell"></i>
                            </button>
                        </form>

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
                    <form  method="get" action='{{route('Notes') }}'>
                        @csrf
                        <button type="submit" class="exploreMoreProducts">
                            <i class="fa fa-solid fa-bell"></i>
                        </button>
                    </form>
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



        <main class="app__InscriptionMain app__acceuilMain">
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
                            <div class="app__rechercheForm">
                                <button class="app__annonceRechercheButton" type="submit">
                                    Annonce
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="app__acceuilPremium">
                <form enctype="multipart/form-data" action="{{route('add',['id' => $partenaire->id ])}}"  method="post">
                    {{ method_field('POST') }}
                    @method("POST")
                    @csrf
                    {{-- {!! Form::token() !!} --}}
                    <div class="container">
                        <div class="left">
                            <textarea name="descriptionObjet" id="" cols="30" rows="10" placeholder="Description de l'objet"></textarea>
                        </div>
                        <div class="right">
                            <input type="text" name="nomObjet" placeholder="Nom Objet">
                            <select name="categorie">
                                <?php
                                    $i = 0;
                                    foreach ($categories as $categorie2) {

                                ?>
                                <option value="<?php echo $categorie2["IdCategorie"]; ?>"><?php echo $categorie2["NomCategorie"];; ?></option>
                                <?php
                                 }
                                ?>

                            </select>
                            <input type="text" name="ville" placeholder="Ville">
                            <input type="text" name="prix" placeholder="Prix/J">
                        </div>
                    </div>
                    <div class="annonce-phase">
                        <label for="fichier">Ajoutez image de l'objet</label>
                        <input type="file" name="fichier" id="fichier">
                        <label for="premium">Vous&nbsp;voulez&nbsp;optez&nbsp;pour&nbsp;une&nbsp;annonce&nbsp;Premium&nbsp;?</label>
                        <input type="checkbox" name="premium" id="premium" value="oui">
                        <label for="Dureepremium">Duree du premium</label>
                        <select name="Dureepremium" id="Dureepremium">
                            <option value="30">7 jours</option>
                            <option value="15">15 jours</option>
                            <option value="30">30 jours</option>
                        </select>
                    </div>


                    <div class="app__dateDeDisponibilite">
                        <p>
                            La date de disponibilite :
                        </p>
                        <input type="text" class="daterange"  name="date"/>
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

                    </div>

                    <p class="P-Premium">Afficher votre annonce sur la première page pendant une semaine, 15 jours ou mois, grâce à l'offre Premium.</p>
                    <div class="last">
                        <input type="submit" name="submit" value="Valider">
                    </div>
                </form>
            </div>
        </main>
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
