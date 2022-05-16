<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/LOC_HERE.css">
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
                                    foreach ($reclamations as $reclamation) {

                                        // var_dump($reclamations);

                                    if ($reclamation["ReponseReclam"]!=NULL) {
                                        $reponseAdminClient = $reclamation["ReponseReclam"];
                                        $idReclamationClient = $reclamation["IdReclamation"];
                                    ?>
                                    <form method="POST" action="{{route('Reclamation',['id' => $client->id, 'type'=>"client","Reponse"=>$reclamation["ReponseReclam"] ,'lu'=>'non']) }}">
                                        @method("POST")
                                        @csrf
                                        <button type="submit">L'administrateur a repondu a votre reclamation (Sujet : <?php  echo $reclamation["ObjetReclam"];?>)  (message : <?php  echo $reclamation["ReponseReclam"];?>) </button>
                                      </form>
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
                        if(isset($reclamations)){


                            foreach ($reclamations as $reclamation) {

                                // var_dump($reclamations);

                            if ($reclamation["ReponseReclam"]!=NULL) {
                                $reponseAdminClient = $reclamation["ReponseReclam"];
                                $idReclamationClient = $reclamation["IdReclamation"];
                            ?>
                            <form method="POST" action="{{route('Reclamation',['id' => $partenaire->id, 'type'=>"partenaire","Reponse"=>$reclamation["ReponseReclam"] ,'lu'=>'non']) }}">
                                @method("POST")
                                @csrf
                                <button type="submit">L'administrateur a repondu a votre reclamation (Sujet : <?php  echo $reclamation["ObjetReclam"];?>)  (message : <?php  echo $reclamation["ReponseReclam"];?>) </button>
                              </form>
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



    <main class="app__reclamationMain">

        <section id="reclamations">
    <div class="wraperreclam">
        <h3><b>Réclamations</b></h3>
        <h4>Si vous avez des réclamations ou propositions n'hésitez pas à nous contacter grâce à l'espace
 réclamations.</h4>
            <center>
                {{-- ,["type"=>"","id"=>] --}}
                <form action='{{route('Reclamation',['id' => $id, 'type'=>$type,'goal'=>"insert"]) }}' method="post">
                    @csrf
                {{-- <form method='get' action="{{route('Reclamation'),['goal'=>"insert","type"=>$type,"id"=>$id ]}}"> --}}
                <div class="input-group mb-3">
                    <span class="input-group-text" id="basic-addon1">Objet</span>
                    <?php
                    if(isset($Reponse)){
                        ?>
                                     <input name="objet" disabled value="Reponse de l'Administrateur" type="text" class="form-control" placeholder="Objet" aria-label="Objet" aria-describedby="basic-addon1">
                          <?php
                      }
                      else {
                          ?>
                                         <input name="objet" type="text" class="form-control" placeholder="Objet" aria-label="Objet" aria-describedby="basic-addon1">
                           <?php
                          }
                      ?>
                  </div>
                  <div class="input-group mb-3">
                    <span class="input-group-text">Message</span>
                    <?php
                        if(isset($Reponse)){
                            ?>
                    <textarea name="message" disabled  class="form-control" aria-label="With textarea"><?php echo $Reponse;  ?></textarea>


                            <?php
                        }
                        else {
                            ?>
                    <textarea name="message"  class="form-control" aria-label="With textarea"></textarea>
                            <?php
                        }

                    ?>
                  </div>
                  <?php
                  if(isset($Reponse)){
                      ?>
                    <button  type="submit" disabled class="btn btn-outline-success" >Envoyer</button>


                        <?php
                    }
                    else {
                        ?>
                    <button  type="submit" class="btn btn-outline-success" >Envoyer</button>

                         <?php
                        }

                    ?>
                  <div class="mb-3">
                  </div>
                <div class="clear"></div>
              </form>
            </center>
    </div>
    </section>


    <!-- <div>
        <form class="app__inscriptionForm">
            <div class="mb-3">
            <label for="exampleFormControlInput1" class="form-label">Email address</label>
            <input type="email" class="form-control" id="exampleFormControlInput1" placeholder="name@example.com">
            </div>
            <div class="mb-3">
            <label for="exampleFormControlTextarea1" class="form-label">Example textarea</label>
            <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
            </div>
            <button class="app__inscriptionButton">
                Envoyer
            </button>
            </form>
            </div> -->

        <!-- <form class="app__inscriptionForm">
            <div class="app__inscriptionInput">
                <input type="text" placeholder="Objet" />
            </div>
            <div class="app__reclamationtextarea">
                <textarea rows="3" cols="38">Entrez votre message</textarea>
            </div>

            <button class="app__inscriptionButton">
                Envoyer
            </button>
        </form> -->


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
