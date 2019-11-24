<?php
    session_start();
    if (!isset($_SESSION["id"]))
    {
        // Benutzer begruessen
        header("Location: http://localhost/nova/"); 
        exit; 
    }
?>
<!DOCTYPE html>
<html>

<head>
    <title>Nova System | Desktop</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.8/css/solid.css">
    <script src="https://use.fontawesome.com/releases/v5.0.7/js/all.js"></script>
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background: url(img/mountain.jpg) no-repeat center center fixed;
            background-size: cover;
        }

        .modal-content {
            background-color: #ffffff;
            opacity: 0.95;
            box-shadow: 0px 0px 3px #ffffff;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-md navbar-dark bg-primary sticky-top">

        <button class="navbar-toggler" data-toggle="collapse" data-target="#collapse_target">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="collapse_target">
            <span class="navbar-text"><a href="http://localhost/nova/">NovaSystem</a></span>
            <div style="margin-right: 20px;"></div>
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="checkUser.php">Records</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Link 2</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Link 3</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Link 4</a>
                </li>
            </ul>
        </div>
        <div class="nav navbar-nav navbar-right" id="collapse_target">
            <li class="nav-item dropdown my-2 my-lg-0">
                <button class="btn btn-outline-success my-2 my-sm-0 dropdown-toggle" data-toggle="dropdown"
                    data-target="droptown_target">User</button>
                <div class="dropdown-menu" aria-labelledby="dropdown_target">
                    <p class="dropdown-item"><?php echo $_SESSION['benutzername']; ?></p>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="#">Change Password</a>
                </div>
            </li>

            <div style="margin-right: 15px;"></div>
            <form class="form-inline my-2 my-lg-0" action="functions/logout.php">
                <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Logout</button>
            </form>
        </div>
    </nav>

    <div class="container-fluid" style="padding-top: 20px;">
        <div class="col-md-100 main-section">
            <div class="modal-content">
            </div>
        </div>
    </div>
</body>

</html>

<!-- 
    <script>
        var xmlhttp = new XMLHttpRequest();
         var url = "myTutorials.txt";
            
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                var myArr = JSON.parse(this.responseText);
                myFunction(myArr);
            }
        };
        xmlhttp.open("GET", url, true);
        xmlhttp.send();
            
        function myFunction(arr) {
            var out = "";
            var i;
            for(i = 0; i < arr.length; i++) {
                out += '<a href="' + arr[i].url + '">' +
                arr[i].display + '</a><br>';
            }
            document.getElementById("id01").innerHTML = out;
        }
    </script>