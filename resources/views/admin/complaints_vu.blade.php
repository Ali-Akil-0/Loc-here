<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
        <link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
        <link rel="stylesheet" href="../../css/dashboard.css">

        <title>LocHere</title>
    </head>
    <body>
        <nav>
            <div class="logo-name">
               <div class="logo-image">
                    <img src="../../img/logo2.png" alt="logo">
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
                        <a href="/complaints">
                        <i class="uil uil-file-exclamation"></i>
                        <span class="link-name">Complaints</span>
                        </a>
                    </li>
                    <li>
                        <a href="/view_AnnoncesAdmin">
                        <i class="uil uil-megaphone"></i>
                        <span class="link-name">Announcements</span>
                        </a>
                    </li>
                    <li>
                        <a href="/partners">
                        <i class="uil uil-users-alt"></i>
                        <span class="link-name">Partners</span>
                         </a>
                    </li>
                    <li>
                        <a href="/customers">
                        <i class="uil uil-users-alt"></i>
                        <span class="link-name">Customers</span>
                        </a>
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
                <div class="card" style="width: 18rem;">
                    <div class="card-body">
                      <h5 class="card-title">Objet de reclamation : <b>{{$reclamation->ObjetReclam}}</b></h5>
                      <p class="card-text">{{$reclamation->MessageReclam}}</p>
                    </div>
                </div>
            </div>
            <div class="row">
                <form action="{{route('storeVu',["email"=>$email])}}" method="POST">
                    <input type="text" value="{{$reclamation->IdReclamation}}" name="idReclam" hidden readonly>
                    <div class="col-auto">
                        @csrf
                        <input type="submit" class="btn btn-primary mb-3" value="Marquer comme vu" name="submit">
                    </div>
                </form>
            </div>
        </div>
        <script src="//netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>
        <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
        <script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>
        <script src="js/script.js"></script>
    </body>
</html>
