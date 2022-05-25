<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="css/admincss.css">
    <script src="//netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>
    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
    <script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>
    <title>LocHere</title>
</head>
<body>
    <nav>
        <div class="logo-name">
           <div class="logo-image">
                <img src="img/logo2.png" alt="logo">
            </div>
            <span class="logoname"> LocHere  </span>
        </div>
        <div class="menu-items">
            <ul class="nav-links">
                <li>
                    <a href="/dashboard">
                    <i class="uil uil-estate"></i>
                    <span class="link-name">Dashboard</span>
                    </a>
                </li>
                <li>
                    <form method="post" action="{{route('complaints',["email"=> $email])}}" class="list-group-item visitor">
                        @csrf
                        <button>
                            <i class="uil uil-file-exclamation"></i>
                            <span class="link-name">Complaints</span>
                        </button>
                    </form>
                </li>
                <li>
                    <form method="post" action="{{route('view_AnnoncesAdmin',["email"=> $email])}}" class="list-group-item tumblr">
                        @csrf
                        <button type="submit">
                    <i class="uil uil-megaphone"></i>
                    <span class="link-name">Announcements</span>
                    </form>
                </button>

                </li>
                <li>
                    <form method="POSt" action="{{route('partners',["email"=> $email])}}" class="list-group-item tumblr">
                        @csrf
                    <button type="submit">
                        <i class="uil uil-users-alt"></i>
                        <span class="link-name">Partners</span>
                        </form>
                    </button>

                </li>
                <li>
                    <form method="POST" action="{{route('customers',["email"=> $email])}}" class="list-group-item tumblr">
                        @csrf
                        <button>
                            <i class="uil uil-users-alt"></i>
                            <span class="link-name">Customers</span>
                        </button>
                    </form>
                </li>
            </ul>
            <ul class="log-mod">
                <li>
                    <a href="/login">
                    <i class="uil uil-signout"></i>
                    <span class="link-name">Log Out </span>
                    </a>
                </li>
                <li class="mode">
                    <a href="#">
                    <i class="uil uil-moon"></i>
                    <span class="link-name">Dark Mode </span>
                    </a>
                    <div class="mode-toggle">
                    <span class="switch"></span>
                    </div>
                </li>
            </ul>
        </div>
    </nav>
    <script src="js/script.js"></script>

<div class="container">
    <div class="header">
            <span class="title"> Annonces </span>
    </div>
    <div>
        <button class="btn btn-secondary btn-lg"  onclick="window.location.href = 'view_Annonces_blackliste';">Black Liste</button>
    </div>
<body class="app__body">


<div class="annoncesadmin">
@foreach ($annonces as $annonce2)



<?php


$annonce =  (array)$annonce2;


// var_dump($annonce);
?>
@if($annonce["etat"] == 'visible')
<div class="z">
            <div class="app__annoncesAnnonce">
                <div class="app__annoncesImageContainer">
                   <img src="{{asset($annonce["Image"])}}" class="app__annoncesImage" alt="...">
                </div>
                <div class="app__annoncesContenu">
                    <p class="app__annoncesNom">
                        {{ $annonce[' NomObjet']}}<br>
                    </p>
                    <p class="app__annoncesUtilisateur">
                    Prix Objet : {{ $annonce["PrixObjet"]}}<br>
                        Annonce premium : {{ $annonce["Premium"]}}<br>
                        Catégorie Objet : {{ $annonce["CategorieObjet"]}}<br>
                        Ville Annonce : {{ $annonce["VilleObjet"]}}
                    </p>
                    <p class="app__annoncesDescription">
                    Id partenaire : {{ $annonce["idPartenaires"]}}
                    </p>
                </div>
                <div class="">
                    <p class="">

                    <a class="btn btn-danger btn-sm rounded-0"  href="{{'annoncebloquer/'.$annonce["IdAnnonce"] }}">@if($annonce["etat"] != 'bloque') Bloquer @else Debloquer @endif</a>

                    </p>
                </div>

 </div>
@endif
 @endforeach
 </div>



</body>

</html>
