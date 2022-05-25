<?php
?>

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
    <div class="header">
            <span class="title"> Dashboard </span>
    </div>
    <div class="row">
        <div class="col-md-2">
            <div class="list-group">
                {{-- <form method="post" action="{{route('complaints',["email"=> $email])}}" class="list-group-item visitor"> --}}
                    {{-- @csrf --}}

                    <h4 class="list-group-item-heading count">{{$data['countrec']}}</h4>
                        <p class="list-group-item-text">
                            Complaints</p>
                {{-- </form> --}}
            </div>
        </div>
        <div class="col-md-2">
            <div class="list-group">

                <form method="post" action="{{route('view_AnnoncesAdmin',["email"=> $email])}}" class="list-group-item tumblr">
                    @csrf
                    <h4 class="list-group-item-heading count">
                        {{$data['countann']}}</h4>
                    <p class="list-group-item-text">
                        Announcements
                    </p>
                </form>
            </div>
        </div>
        <div class="col-md-2">
            <div class="list-group">

                <a class="list-group-item tumblr">
                    <h4 class="list-group-item-heading count">
                        {{$data['countprem']}}</h4>
                    <p class="list-group-item-text">
                        Premium Ads
                    </p>
                </a>
            </div>
        </div>
        <div class="col-md-2">
            <div class="list-group">
                <form method="POSt" action="{{route('partners',["email"=> $email])}}" class="list-group-item tumblr">
                    @csrf
                    @method("POST")
                    <h4 class="list-group-item-heading count">
                    {{$data['countpart']}}</h4>
                    <p class="list-group-item-text">
                        Partners</p>
                </form>
            </div>
        </div>
        <div class="col-md-2">
            <div class="list-group">
                <form method="POST" action="{{route('customers',["email"=> $email])}}" class="list-group-item tumblr">
                    @csrf
                    @method("POST")
                    <h4 class="list-group-item-heading count">
                    {{$data['countcst']}}</h4>
                    <p class="list-group-item-text">
                        Customers</p>
                </form>
            </div>
        </div>
    </div>
    <?php

    $currentYear = date("Y");


    ?>
    <canvas id="myChart" style="width:100%;max-width:600px;margin: 60px 60px 60px 180px;"></canvas>
        <script>
            var xValues = ["January", "February", "March", "April", "Mai", "June", "July", "August", "September", "October", "November","December"];
            var yValues = [{{$data['januaryRentals']}},{{$data['februaryRentals']}},{{$data['marchRentals']}},{{$data['aprilRentals']}},{{$data['mayRentals']}},{{$data['juneRentals']}},{{$data['julyRentals']}},{{$data['augustRentals']}},{{$data['septemberRentals']}},{{$data['octoberRentals']}},{{$data['novemberRentals']}},{{$data['decemberRentals']}}];
            var barColors = ["orange","orange","orange","orange","orange","orange","orange","orange","orange","orange","orange","orange"];

            new Chart("myChart", {
            type: "bar",
            data: {
                labels: xValues,
                datasets: [{
                backgroundColor: barColors,
                data: yValues
                }]
            },
            options: {
                legend: {display: false},
                title: {
                display: true,
                text: ' Rentals <?php echo $currentYear;  ?>  '




            }
            }
            });
        </script>
    <canvas id="myChart1" style="width:100%;max-width:600px;margin: 60px 60px 60px 180px;"></canvas>
        <script>
            var xValues = ["January", "February", "March", "April", "Mai", "June", "July", "August", "September", "October", "November","December"];
            var yValues = [{{$data['januaryCustomers']}},{{$data['februaryCustomers']}} ,{{$data['marchCustomers']}} ,{{$data['aprilCustomers']}} ,{{$data['mayCustomers']}} ,{{$data['juneCustomers']}},{{$data['julyCustomers']}},{{$data['augustCustomers']}},{{$data['septemberCustomers']}},{{$data['octoberCustomers']}},{{$data['novemberCustomers']}},{{$data['decemberCustomers']}}];
            var barColors = ["orange","orange","orange","orange","orange","orange","orange","orange","orange","orange","orange","orange"];

            new Chart("myChart1", {
            type: "bar",
            data: {
                labels: xValues,
                datasets: [{
                backgroundColor: barColors,
                data: yValues
                }]
            },
            options: {
                legend: {display: false},
                title: {
                display: true,
                text: " Number of Customers <?php echo $currentYear;  ?> "
                }
            }
            });
        </script>
        <canvas id="myChart2" style="width:100%;max-width:600px;margin: 60px 60px 60px 180px;"></canvas>
        <script>
            var xValues = ["January", "February", "March", "April", "Mai", "June", "July", "August", "September", "October", "November","December"];
            var yValues = [{{$data['januaryPartners']}},{{$data['februaryPartners']}} ,{{$data['marchPartners']}} ,{{$data['aprilPartners']}} ,{{$data['mayPartners']}} ,{{$data['junePartners']}},{{$data['julyPartners']}},{{$data['augustPartners']}},{{$data['septemberPartners']}},{{$data['octoberPartners']}},{{$data['novemberPartners']}},{{$data['decemberPartners']}}];
            var barColors = ["orange","orange","orange","orange","orange","orange","orange","orange","orange","orange","orange","orange"];

            new Chart("myChart2", {
            type: "bar",
            data: {
                labels: xValues,
                datasets: [{
                backgroundColor: barColors,
                data: yValues
                }]
            },
            options: {
                legend: {display: false},
                title: {
                display: true,
                text: " Number of Partners <?php echo $currentYear;  ?> "
                }
            }
            });
        </script>

</div>
</body>
</html>
