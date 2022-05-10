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
                        <form class="app__rechercheForm">
                            <div class="app__inputNom">
                                <input type="text" class="app__AnnonceNom"
                                    placeholder="Quel outil souhaitez-vous louer ?" />
                            </div>
                            <div class="app__inputSelect">
                                <select id="Ville" name="Ville" placeholder="Ville">
                                    <option value="" disabled selected hidden>Ville</option>
                                    <?php

                                    $i = 0;
                                    for ($i = 0; $i < 7; $i++) {
                                    ?>
                                    <option value="<?php echo $i; ?>" default><?php echo $i;  ?></option>
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
                                    for ($i = 0; $i < 7; $i++) {
                                    ?>
                                    <option value="<?php echo $i; ?>" default><?php echo $i;  ?></option>
                                    <?php
                                    }

                                    ?>

                                </select>
                            </div>
                            <div class="app__inputSelect">
                                <select id="Disponibilite" name="Disponibilite">
                                    <option value="" disabled selected hidden>Disponibilite</option>

                                    <?php

                                    $i = 0;
                                    for ($i = 0; $i < 7; $i++) {
                                    ?>
                                    <option value="<?php echo $i; ?>" default><?php echo $i;  ?></option>
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
                                    for ($i = 0; $i < 7; $i++) {
                                    ?>
                                    <option value="<?php echo $i; ?>" default><?php echo $i;  ?></option>
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
                <?php
                $i = 0;
                for ($i = 0; $i < 20; $i++) {
                ?>
                <div class="app__annonce">
                    <img src="/Content/remorque.jpg" class="app_annonceImage" />
                    <p class="app__annonceTitre">
                        remorque porte voiture PTAC
                    </p>
                    <div class="app__annoncePrixContainer">
                        <p class="app__annoncePrix">
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

        </div>
        <div class="app__acceuilAutre">
            <p class="app__AutreTitre">
                Explorer autres produits
            </p>
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