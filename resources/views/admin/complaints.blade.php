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
    <link rel="stylesheet" href="../css/dashboard.css">
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
    <div class="container">
        <div class="row">
            <table class="table">
                <thead>
                  <tr>
                    <th scope="col">ID</th>
                    <th scope="col">ID Client</th>
                    <th scope="col">Objet Reclamation</th>
                    <th scope="col">Message Reclamation</th>
                    <th scope="col">Action</th>
                  </tr>
                </thead>
                <tbody>
                    @if (count($reclamations)>=1)
                        @foreach ($reclamations as $reclamation)
                        <?php
                            // var_dump($reclamation);
                        ?>
                            <tr>
                                <th scope="row">{{$reclamation->IdReclamation}}</th>
                                <td>{{$reclamation->idClients}}</td>
                                <td>{{$reclamation->ObjetReclam}}</td>
                                <td>{{$reclamation->MessageReclam}}</td>
                                <td>
                                    <form method="post" action="{{route('ComplaintsVu',['email'=>$email,'reclamation'=>$reclamation->IdReclamation])}}">
                                        @csrf
                                        @method('POST')
                                    <button class="btn btn-info" type="submit">Marquer comme vu</button>
                                    </form>
                                    <form method="post" action='{{route('ComplaintsRepondre',["email"=>$email,"reclamation"=>$reclamation->IdReclamation])}}'>
                                        @csrf
                                        @method('POST')
                                        <button class="btn btn-info" type="submit">Repondre</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    </div>
    <script src="//netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>
    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
    <script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>
    <script src="js/script.js"></script>
</body>
</html>
