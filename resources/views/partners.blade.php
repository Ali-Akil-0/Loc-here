

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
    <link rel="stylesheet" href="css/dashboard.css">
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
    <!-- <div class="header">
            <span class="title"> Liste des partenaires </span>
    </div> -->
<body class="partenaire">



<section class="pb-5 header text-center">
    <div class="container py-5  textstyle ">
        <header class="py-5">
            <h1 class="display-4"> Liste des clients </h1>
        </header>

        <div class="row">
            <div class="col-lg-7 mx-auto">
                <div class="card border-0 shadow">
                    <div class="card-body p-5">

                        <!-- Responsive table -->
                        <div class="table-responsive">
                            <table class="table m-0">
                                <thead>
                                    <tr>
                                        <th scope="col">ID Partenaire</th>
                                        <th scope="col">Nom complet</th>
                                        <th scope="col">Email</th>
                                        <th scope="col">Note Partenaire</th>
                                        <th scope="col">Supprimer</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach ($Notepartenaires as $Notepartenaire)

                                    <tr>
                                        <th scope="row">{{ $Notepartenaire->id}}</th>
                                        <td data-title="N om comple">{{ $Notepartenaire->NomPartenaire}} {{ $Notepartenaire->PrenomPartenaire}}</td>
                                        <td data-title="Email">{{ $Notepartenaire->EmailPartenaire}}</td>
                                        <td data-title="Sympathie">{{ $Notepartenaire->AVgNote	}}</td>

                                        <td>
                                            <ul class="list-inline m-0">
                                                <li class="list-inline-item">
                                                    <!-- <button class="btn btn-danger btn-sm rounded-0" type="button" data-toggle="tooltip" data-placement="top" title="Delete">Supprimer Client</button> -->
                                                    <a class="btn btn-danger btn-sm rounded-0"  href="{{'bloquerpartner/'.$Notepartenaire->id }}">@if($Notepartenaire->etat != 'bloque') Bloquer @else Debloquer @endif</a>
                                                </li>
                                            </ul>
                                        </td>

                                    </tr>


                                    @endforeach


                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


</body>
</html>
