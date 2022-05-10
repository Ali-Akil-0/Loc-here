<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/Content/LOC_HERE.css">
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
    <!------ Include the above in your HEAD tag ---------->

    <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
    <script src="/Content/rating.js"></script>
    <title>LOC HERE</title>
</head>

<body class="app__body">
    <header class="app__header">
        <div class="app__headerContent">
            <div class="app__logoPlacement">
                <img src="/Content/logo.png" class="app__logo" />
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
                    <p class="app__SIgnInPar">Se connecter</p>
                </div>
            </div>
        </div>
        <hr class="app__headerBreak" />
    </header>


    <main class="app__annonceMain">
        <div class="app__annonceBanner">
            <div class="app__annonceImageContainer">
                <img src="/Content/remorque.jpg" class="app__annonceImage" />
            </div>
            <div class="app__annnonceDescription">
                <div class="app__annonceTitre2">
                    <p>Remorque</p>
                </div>
                <div class="app__annonceDescriptionNom">
                    <p>Akil Ali</p>
                </div>
                <div class="app__annonceRatingPrice">
                    <div>
                        <p class="app__annoncePrice2">400 DH / Jour</p>
                    </div>
                    <div class="app__annonceRating">
                        <input id="input-1" name="input-1" class="rating rating-loading" data-min="0" data-max="5"
                            data-step="0.1" value="4">
                    </div>
                </div>
                <div class="app__annonceLocation">
                    <span>
                        Se Connecter
                    </span>
                    <p>pour</p>
                    <button disabled class="app__annonceLocationButton">Louer</button>
                </div>
            </div>
        </div>
        <div class="app__annonceBottom">

            <div class="app__annonceInfo">
                <div class="app__annonceInfoObjet">
                    <p class="app__annonceInfoTitre">Info Objet : </p>
                    <p class="app__annonceInfoContent">
                        Place of Origin: Jiangsu, China
                        Brand Name: OEM
                        Model Number: AF248CE
                        Type: Acoustic Guitar
                        Body Material: Spruce plywood
                        Neck Material: Spruce plywood
                        Fingerboard Material: High density man-made wood
                        Accessories: With 4-band EQ
                        Color: Natural
                    </p>
                </div>
                <div class="app__annoncePartenaire">
                    <div>
                        <img src="/Content/Akil.png" class="app__annoncePartenaireImage" />
                    </div>
                    <div class="app__annoncePartenaireNom">
                        <p class="app__annoncePartenaireTitre">
                            Nom :
                        </p>
                        <p>
                            Akil
                        </p>
                    </div>
                    <div class="app__annoncePartenaireNom">
                        <p class="app__annoncePartenaireTitre">
                            Prénom :
                        </p>
                        <p>
                            Ali
                        </p>
                    </div>
                    <div class="app__annoncePartenaireNom">
                        <p class="app__annoncePartenaireTitre">
                            Adresse :
                        </p>
                        <p>
                            Mhannech, Tétouan
                        </p>
                    </div>
                    <div class="app__annoncePartenaireNom">
                        <p class="app__annoncePartenaireTitre">
                            Tél :
                        </p>
                        <p>
                            0653088697
                        </p>
                    </div>
                    <div class="app__annoncePartenaireNom">
                        <p class="app__annoncePartenaireTitre">
                            Email :
                        </p>
                        <p>
                            Ali.akil@etu.uae.ac.ma
                        </p>
                    </div>
                    <div class="app__annoncePartenaireRating">
                        <div class="app__annonceRating app__annonceRating2">
                            <input id="input-2" name="input-2" class="rating rating-loading" data-min="0" data-max="5"
                                data-step="0.1" value="4">
                        </div>
                    </div>
                </div>

            </div>

            <div class="app__annonceCommentairesContainer">
                <div class="app__annonceCommentaireTitre">
                    <p class="app__annonceInfoTitre">Commentaires : </p>
                </div>
                <?php
                $i = 0;
                for ($i = 0; $i < 7; $i++) {
                ?>
                <div class="app__annonceCommentaires">

                    <div class="app__annonceCommentaireContainer">
                        <img src="/Content/Akil.png" class="app__annonceImageUtilisateur" />
                        <div class="app__annonceCommentaireDesc">
                            <div class="annonceCommentaireTop">
                                <p class="app__annonceCommentaireNom">
                                    Ali Akil
                                </p>
                                <div class="app__annonceCommentaireRating">
                                    <div class="app__annonceRating app__annonceRating2">
                                        <input id="input-3" name="input-3" class="rating rating-loading" data-min="0"
                                            data-max="5" data-step="0.1" value="4">
                                    </div>
                                </div>

                            </div>
                            <div class="app__annonceCommentaireContent">
                                Excellent
                            </div>
                        </div>
                        <div class="app__annonceCommentaireTime">
                            <p> <span class="app__annonceCommentaireDate">11/04/2022</span> 10:30</p>
                        </div>
                    </div>


                </div>
                <?php
                }
                ?>




            </div>
        </div>


    </main>
    <footer class="app__footer">
        <div class="app__footerContent">
            <div class="app__LogoDesc">
                <img src="/Content/logo.png" class="app__footerLogo" />
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