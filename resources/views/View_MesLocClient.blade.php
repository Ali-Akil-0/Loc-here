<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="css/LOC_HERE.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>LOC HERE</title>
</head>

<body class="app__body">
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
            </div>
            <div class="app__signIn">
                <div class="app__SignInButton" id="InscrireButton">
                    <p class="app__SIgnInPar">S'inscrire</p>
                </div>
                <hr class="app__signInBreak" />
                <div class="app__SignInButton" id="ConnecterButton">
                    <p class="app__SIgnInPar">Logout</p>
                </div>
            </div>
        </div>
        <hr class="app__headerBreak" />
    </header>


    <main class="app__inscriptionMain app__acceuilMain">
      
        <div class="app__annoncesContenuTitre">
            <p class="app__annoncesTitre sizetext">Mes locations</p>
            <p class="app__annoncesTitre">page 1 de 10</p>
        </div>

        <div class="app__annoncesListe">
            <?php
            $i = 0;
            for ($i = 0; $i <10; $i++) {

            ?>
            <div class="app__annoncesAnnonce">
                <div class="app__annoncesImageContainer">
                    <img src="img/remorque.jpg" class="app__annoncesImage" />
                </div>
                <div class="app__annoncesContenu">
                    <p class="app__annoncesNom">
                        Nom Objet
                    </p>
                    <p class="app__annoncesUtilisateur">
                        Nom Utilisateur
                    </p>
                    <p class="app__annoncesDescription">
                        Description
                    </p>

                </div>
                <div class="app__annoncesPrixContainer app__annoncesPrixContainer2">
                    <p class="app__annoncePrix40">
                        <?php
                            echo $i;
                            ?>
                        DH / Jour

                    </p>
                </div>

            </div>

            <?php
            }
            ?>



        </div>
        <div class="app__annoncesPages">
            <p class="app__pagesTitre">
            <nav aria-label="Page navigation example">
            <ul class="pagination">
                <li class="page-item"><a class="page-link" href="#">Previous</a></li>
                <li class="page-item"><a class="page-link" href="#">1</a></li>
                <li class="page-item"><a class="page-link" href="#">2</a></li>
                <li class="page-item"><a class="page-link" href="#">3</a></li>
                <li class="page-item"><a class="page-link" href="#">4</a></li>
                <li class="page-item"><a class="page-link" href="#">Next</a></li>
            </ul>
</nav>
            </p>
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