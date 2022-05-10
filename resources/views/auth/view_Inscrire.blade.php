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
                    <p class="app__option">Publier</p>
                </div>
            </div>
            <div class="app__signIn">
                <div class="app__SignInButton" id="InscrireButton">
                    <p class="app__SIgnInPar">S'inscrire</p>
                </div>
                <hr class="app__signInBreak" />
                <div class="app__SignInButton" id="ConnecterButton">
                    <p
                     class="app__SIgnInPar">Se connecter</p>
                </div>

            </div>
        </div>

        <hr class="app__headerBreak" />
    </header>
    <main class="app__inscriptionMain app__inscriptionMain2">
        <div class="app__inscriptionDesc">
            <div class="app__logoContainer">
                <img src="/img/logo2.png" class="app__inscriptionLogo" />

            </div>
            <p class="app__inscriptionPar">
                Bienvenue
            </p>

        </div>
        {{-- @if(Session::has("fail"))
        <div class="alert">
            {{Session::get("fail")}}
        </div>


        @endif --}}
        <form action="{{route('ajouter-user')}}" method='post' class="app__inscriptionForm">

            @csrf
            <div class="app__inscriptionInput">
                <input name="nom" value="{{old('nom')}}" type="text" placeholder="Nom" />
            </div>
            <div class="app__inscriptionInput">
                <input name="prenom" value="{{old('prenom')}}" type="text" placeholder="Prenom" />
            </div>
            <div class="app__inscriptionInput">
                <input name="username"  value="{{old('username')}}"  type="text" placeholder="Nom d'utilisateur" />
            </div>
            <div class="app__inscriptionInput">
                <input name="email" value="{{old('email')}}" type="text" placeholder="Email" />
            </div>

            <div class="app__inscriptionInput">
                <input name="password"  value="{{old('password')}}" type="password" placeholder="Mot de passe" />
            </div>
            <!-- <div class="app__inscriptionInput">
                <select class="app__inscriptionSelect" id="Utilisateur" name="Utilisateurs">
                    <option value="Client" default>Client</option>
                    <option value="Partenaire">Partenaire</option>
                </select>
            </div> -->

            <button type='submit' class="app__inscriptionButton">
                S'inscrire
            </button>
            <a href='login' class="app__inscriptionConnecter">Se connecter</a>
        </form>


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
