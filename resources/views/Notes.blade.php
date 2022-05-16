<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="css/LOC_HERE.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>




    <script src="code.jquery.com/jquery-1.11.1.min.js"></script>
    <script src="/js/rating.js"></script>

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

                    <form  method="get" action='{{route('Notes') }}'>
                        @csrf
                        <div class="dropdown">
                            <span>
                                <button type="submit" class="exploreMoreProducts">
                                <i class="fa fa-solid fa-bell"></i>
                            </button></span>
                            <div class="dropdown-content">
                                <?php
                                    if(isset($reclamations)){
                                    ?>




                                <?php
                                foreach ($reclamations as $reclamation) {
                                var_dump($reclamation);
                                if ($reclamation["ReponseReclam"] && $reclamation["ReclamationLu"] == "non") {
                                    $reponseAdminClient = $reclamation["ReponseReclam"];
                                    $idReclamationClient = $reclamation["IdReclamation"];
                                }
                                ?>
                                <a href="{{route("Notes")}}">Hello World! testing the things i guess</a>
                                <?php
                                if ($reclamation["VueReclamationAdmin"] && $reclamation["ReclamationLu"] == "non") {
                                    $reponseAdminClient = $reclamation["VueReclamationAdmin"];
                                    $idReclamationClient = $reclamation["IdReclamation"];
                                }
                                 }
                                }

                                ?>
                                <?php



                                ?>

                            </div>
                        </div>
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
                    <div class="dropdown">
                        <span>
                            <button type="submit" class="exploreMoreProducts">
                            <i class="fa fa-solid fa-bell"></i>
                        </button></span>
                        <div class="dropdown-content">
                        <p>Hello World!</p>
                        <p>Hello World!</p>
                        <p>Hello World!</p>

                        </div>
                      </div>

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
    <main class="app__InscriptionMain">

<center>

    <section id="notes">
        <div class="wraper2">
            <h3><b>Notes</b></h3>
            <!-- <h4>Veuillez noter votre expérience</h4> -->



                <div class="container">
                <div class="row">
                <div class="col-sm-4">
                <h4>Veuillez noter votre expérience</h4>

        </div>
                </div>
                </div>
        </div></section>
        <div class="col-sm-8 contact-form">
            <?php
            if(!isset($LePartenaire)){
                ?>
              <form id="contact"  class="form" role="form" action='{{route("Notes",['id' => $id ,'type' => "client"])}}' method='post' >

            <?php
            }
            else {
                ?>
              <form id="contact"  class="form" role="form" action='{{route("Notes",['id' => $id ,'type' => "partenaire"])}}' method='post' >
                <?php
            }

            ?>

        <div class="row">
        <div class="col-xs-6 col-md-6 form-group">
        <input class="form-control" value='<?php echo $Objet[" NomObjet"] ?>' disabled id="name" name="objet" placeholder="Nom du partenaire" type="text"  required autofocus />
        </div>
        <div class="col-xs-6 col-md-6 form-group">
           <?php
            if(isset($LePartenaire)){
                ?>
                <input class="form-control" value='<?php echo $LePartenaire["UsernamePartenaire"] ?>' disabled id="objet" name="Partenaire" placeholder="Titre de l'objet" type="text" required />
                <?php
            }
            ?>
        </div>
        </div>
        <div class="app__annonceRating"><span>Note partenaire</span>
            <input id="input-1" name="notepartenaire" class="rating rating-loading" data-min="0" data-max="5"
                                    data-step="0.1" value="4">
                            </div>

        <div class="app__annonceRating"><span>Note objet</span>
                <input id="input-1" name="noteobjet" class="rating rating-loading" data-min="0" data-max="5"
                                    data-step="0.1" value="4">
                            </div>


        <textarea class="form-control" id="CommentairePartenaire" name="CommentairePartenaire" placeholder="Commentaire sur le Partenaire " rows="5"></textarea>
        <br/>
        <br/>
        <br/>
        <br/>
        <textarea class="form-control" id="Commentaire" name="CommentaireObjet" placeholder="Commentaire sur l'objet " rows="5"></textarea>
        <br />
        <button class="btn btn-primary pull-right" type="submit">Envoyer</button>
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
