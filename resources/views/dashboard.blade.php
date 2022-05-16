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
    <link rel="stylesheet" href="css/LOC_HERE3.css">
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
                    <a href="dashboard.php">
                    <i class="uil uil-estate"></i>
                    <span class="link-name">Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="complaints.php">
                    <i class="uil uil-file-exclamation"></i>
                    <span class="link-name">Complaints</span>
                    </a>
                </li>
                <li>
                    <a href="announcement.php">
                    <i class="uil uil-megaphone"></i>
                    <span class="link-name">Announcements</span>
                    </a>
                </li>
                <li>
                    <a href="currentrentals.php">
                    <i class="uil uil-shopping-cart"></i>
                    <span class="link-name">Current Rents</span>
                    </a>
                </li>
                <li>
                    <a href="partners.php">
                    <i class="uil uil-users-alt"></i>
                    <span class="link-name">Partners</span>
                     </a>
                </li>
                <li>
                    <a href="customers.php">
                    <i class="uil uil-users-alt"></i>
                    <span class="link-name">Customers</span>
                    </a>
                </li>
            </ul>
            <ul class="log-mod">
                <li>
                    <a href="#">
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
    <!-- <script src="js/script.js"></script> -->


<div class="container">
    <div class="header">
            <span class="title"> Dashboard </span>
    </div>
    <div class="row">
        <div class="col-md-3">
            <div class="list-group">
                <a href="complaints.php" class="list-group-item visitor">
                    <h3 class="pull-right">
                        <i class="fas fa-comment-alt"></i>
                    </h3>
                    <h4 class="list-group-item-heading count">
                    {{$countrec}} </h4>
                    <p class="list-group-item-text">
                        Complaints</p>
                </a>
            </div>
        </div>
        <div class="col-md-3">
            <div class="list-group">
                <a href="announcement.php" class="list-group-item tumblr">
                    <h3 class="pull-right">
                        <i class="fas fa-bullhorn"></i>
                    </h3>
                    <h4 class="list-group-item-heading count"> {{$countann}}</h4>
                    <p class="list-group-item-text">
                        Announcements</p>
                </a>
            </div>
        </div>
        <div class="col-md-3">
            <div class="list-group">
                <a href="repads.php" class="list-group-item tumblr">
                    <h3 class="pull-right">
                        <i class="fas fa-minus-circle"></i>
                    </h3>
                    <h4 class="list-group-item-heading count">
                        10</h4>
                    <p class="list-group-item-text">
                        Reported Ads</p>
                </a>
            </div>
        </div>
        <div class="col-md-3">
            <div class="list-group">
                <a href="premads.php" class="list-group-item tumblr">
                    <h3 class="pull-right">
                        <i class="fas fa-award"></i>
                    </h3>
                    <h4 class="list-group-item-heading count">
                        3</h4>
                    <p class="list-group-item-text">
                        Premium Ads</p>
                </a>
            </div>
        </div>
        <div class="col-md-3">
            <div class="list-group">
                <a href="currentrentals.php" class="list-group-item tumblr">
                    <h3 class="pull-right">
                        <i class="fas fa-cart-plus"></i>
                    </h3>
                    <h4 class="list-group-item-heading count">
                        3</h4>
                    <p class="list-group-item-text">
                        Current Rentals</p>
                </a>
            </div>
        </div>
        <div class="col-md-3">
            <div class="list-group">
                <a href="partners.php" class="list-group-item tumblr">
                    <h3 class="pull-right">
                        <i class="fas fa-user-friends"></i>
                    </h3>
                    <h4 class="list-group-item-heading count"> 3</h4>
                    <p class="list-group-item-text">
                        Partners</p>
                </a>
            </div>
        </div>
        <div class="col-md-3">
            <div class="list-group">
                <a href="customers.php" class="list-group-item tumblr">
                    <h3 class="pull-right">
                        <i class="fas fa-user-friends""></i>
                    </h3>
                    <h4 class="list-group-item-heading count">
                        15</h4>
                    <p class="list-group-item-text">
                        Customers</p>
                </a>
            </div>
        </div>
    </div>
    <canvas id="myChart" style="width:100%;max-width:600px;margin: 60px 60px 60px 180px;"></canvas>
        <script>
            var xValues = ["January", "February", "March", "April", "Mai", "June", "July", "August", "September", "October", "November","December"];
            var yValues = [40, 49, 44, 24, 15,10,30,10,46,16,7,13];
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
                text: " Rentals 2022 "
                }
            }
            });
        </script>
    <canvas id="myChart1" style="width:100%;max-width:600px;margin: 60px 60px 60px 180px;"></canvas>
        <script>
            var xValues = ["January", "February", "March", "April", "Mai", "June", "July", "August", "September", "October", "November","December"];
            var yValues = [40, 49, 44, 24, 15,10,30,10,46,16,7,13];
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
                text: " Number of Customers 2022 "
                }
            }
            });
        </script>
        <canvas id="myChart2" style="width:100%;max-width:600px;margin: 60px 60px 60px 180px;"></canvas>
        <script>
            var xValues = ["January", "February", "March", "April", "Mai", "June", "July", "August", "September", "October", "November","December"];
            var yValues = [40, 49, 44, 24, 15,10,30,10,46,16,7,13];
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
                text: " Number of Partners 2022 "
                }
            }
            });
        </script>

</div>
</body>
</html>
