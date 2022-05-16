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

    <script src="code.jquery.com/jquery-1.11.1.min.js"></script>
    <script src="Content/rating.js"></script>

    <title>LOC HERE</title>
</head>

<body class="app__Inscrire">
    <header class="app__header">
        <div class="app__headerContent">
            <div class="app__logoPlacement">
                <img src="img/logo.png" class="app__logo" />
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
                    <p class="app__option">Publier</p>
                </div>
                <div class="app__Acceuil">
                    <p class="app__option">Devenir partenaire</p>
                </div>
            </div>
            <div class="app__signIn">
                <div class="app__SignInButton" id="InscrireButton">
                    <p class="app__SIgnInPar">Se deconnecter</p>
                </div>
                <hr class="app__signInBreak" />


            </div>
        </div>

        <hr class="app__headerBreak" />
    </header>
    <main class="app__InscriptionMain">

    <section id="notes">
    <div class="wraper2">
        <h3><b>Profil</b></h3>
        <div> <img src="img/user.png" ><br>
        <a href="">Changer photo de profil</a>
        <!-- <form action="pdp" method="post">
            @csrf
            <input type="file" name="pdp" >
            <input type="submit" value="enregistrer" class="btn btn-outline-success">
        </form> -->
        </div><br><br>

            <center>
            <form action="{{route('profile')}}" method='post'>
                <div class="input-group mb-3">
                    <span class="input-group-text" id="basic-addon1">Nickname</span>
                    <input type="text" class="form-control" placeholder="Nickname" value="{{$data->UsernameClient}}" aria-label="Nickname" aria-describedby="basic-addon1" disabled>
                  </div>
                <div class="input-group mb-3">
                    <span class="input-group-text" id="basic-addon1">Ville</span>
                    <input type="text" class="form-control" placeholder="Ville" value="{{$data->Ville}}" aria-label="Ville" aria-describedby="basic-addon1" disabled>
                  </div>
                  <div class="input-group mb-3">
                    <span class="input-group-text" id="basic-addon1">Adresse</span>
                    <input type="text" class="form-control" placeholder="Adresse" value="{{$data->Adresse}}" aria-label="Adresse" aria-describedby="basic-addon1" disabled>
                  </div>

                  <div class="input-group mb-3">
                    <input type="email" class="form-control" id="exampleInputEmail1" value="{{$data->EmailClient}}" placeholder="@example.com" aria-label="Email" aria-describedby="emailHelp" disabled>
                    <!-- <input type="email" class="form-control" placeholder="Recipient's username" aria-label="Recipient's username" aria-describedby="basic-addon2"> -->
                    <span class="input-group-text" id="basic-addon2">Email</span>
                  </div>

                  <div class="input-group mb-3">
                    <input type="tel" class="form-control" placeholder="+212" value="{{$data->Tel}}" aria-label="numéro" disabled>
                    <span class="input-group-text">Télephone</span>
                  </div>



            <div class="clear"></div>
        </form>
        </center>
    </div>
    </section>

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
