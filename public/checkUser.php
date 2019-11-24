<?php
session_start();
if (!isset($_SESSION["id"])) {
    // Benutzer begruessen
    header("Location: http://localhost/nova/");
    exit;
}
include 'functions.php';
include 'config.php';
if (isset($_POST['delete'])) {
    switch ($_POST['type']) {
        case "warnings":
            $type = "warnings";
            break;
        case "kicks":
            $type = "kicks";
            break;
        case "bans":
            $type = "bans";
            break;
        default:
            die();
    }
    $stmt = $conn->prepare("DELETE FROM " . $type . " WHERE id = :rid");
    $stmt->bindParam(':rid', $_POST['num']);
    $stmt->execute();
}

if (isset($_POST['create'])) {
    switch ($_POST['type']) {
        case "warnings":
            $type = "warnings";
            break;
        case "kicks":
            $type = "kicks";
            break;
        case "bans":
            $type = "bans";
            break;
        default:
            die();
    }
    $stmt = $conn->prepare("INSERT INTO `" . $type . "`( `Username`, `Reason`, `By`) VALUES (:username, :reason, :by)");
    $stmt->bindParam(':username', $_POST['username']);
    $stmt->bindParam(':reason', $_POST['reason']);
    $stmt->bindParam(':by', $_SESSION['benutzername']);
    $stmt->execute();
}
?>
    <!DOCTYPE html>
    <html>

    <head>
        <title>Nova System | Check User</title>
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
                box-shadow: 0px 0px 3px #ffffff;
                opacity: 0.925;
            }

            hr {
                color: #000000;
            }

            .table-div {
                padding-top: 15px;
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
                    <button class="btn btn-outline-success my-2 my-sm-0 dropdown-toggle" data-toggle="dropdown" data-target="droptown_target">User</button>
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

        <div class="container-fluid" style="padding-top: 20px; padding-bottom: 20px;">
            <div class="col-md-100 main-section">
                <div class="modal-content">
                    <div class="row" style="padding-left: 10px; padding-right: 10px; padding-top: 20px;">
                        <div class="col-md-4">
                            <h3 class="h4 text-center text-info">Search Records</h3>
                            <hr>
                            <form action="" method="GET" enctype="multipart/form-data">
                                <input type="hidden" name="search">
                                <div class="form-group">
                                    <input type="text" name="username" class="form-control" placeholder="Enter Username" required>
                                </div>
                                <div class="form-group">
                                    <input type="submit" class="btn btn-primary btn-block" value="Search Record's">
                                </div>
                            </form>
                        </div>
                        <div class="col-md-8">
                            <h3 class="h4 text-center text-info">Information</h3>
                            <hr>
                            <p class="text-center"><?php
                                                    if (isset($_GET['search'])) {
                                                        $response = getUserData($_GET['username']);
                                                        echo "Id: " . $response['Id'];
                                                    }
                                                    ?></p>
                            <p class="text-center"><?php
                                                    if (isset($_GET['search'])) {
                                                        $response = getUserData($_GET['username']);
                                                        echo "Username: " . $response['Username'];
                                                    }
                                                    ?></p>
                            <p class="text-center"><?php
                                                    $groupId = 4683371;
                                                    if (isset($_GET['search'])) {
                                                        $response = getUserData($_GET['username']);
                                                        foreach ($response["Groups"] as $res) {
                                                            if ($res['Id'] == $groupId) {
                                                                echo "Rank: " . $res['Rank'] . " | ";
                                                                echo "Role: " . $res['Role'];
                                                            }
                                                        }
                                                    }
                                                    ?></p>

                        </div>
                        <div class="col-md-4">
                            <h3 class="h4 text-center text-info">Create Record</h3>
                            <hr>
                            <form action="" method="POST" enctype="multipart/form-data">
                                <div class="form-group">
                                    <input type="text" name="username" class="form-control" placeholder="Enter Username" value="<?= isset($_GET["username"]) ? $_GET["username"] : ""; ?>" required>
                                </div>
                                <div class="form-group">
                                    <input type="text" name="reason" class="form-control" placeholder="Enter Reason" required>
                                </div>
                                <div class="form-group">
                                    <select name="type" class="btn btn-primary btn-block">
                                        <option value="warnings">Warnings</option>
                                        <option value="kicks">Kicks</option>
                                        <option value="bans">Bans</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <input type="submit" name="create" class="btn btn-primary btn-block" value="Create Record">
                                </div>
                            </form>
                        </div>
                        <div class="col-md-8 table-div">
                            <h3 class="h4 text-center text-info">Warnings</h3>
                            <hr>
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Reason</th>
                                        <th>Time</th>
                                        <th>By</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php

                                    if (isset($_GET['search'])) {
                                        $stmt = $conn->prepare("SELECT * FROM warnings WHERE Username = :user");
                                        $stmt->bindParam(':user', $_GET["username"]);
                                        $stmt->execute();

                                        //echo "<table border ='1px'>";
                                        while ($row = $stmt->fetchAll()) {
                                            $count = 0;
                                            foreach ($row as $item) {
                                                $count = $count + 1;
                                                echo '<tr>';
                                                echo '<td>' . $item["id"] . '</td>';
                                                //echo '<td>' . $row1['Username'] . '</td>';
                                                echo '<td>' . $item['Reason'] . '</td>';
                                                echo '<td>' . $item['Time'] . '</td>';
                                                echo '<td>' . $item['By'] . '</td>';
                                                echo '</tr>';
                                            }
                                        }
                                        //echo '</table>';
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-md-4">
                            <h3 class="h4 text-center text-info">Delete Record</h3>
                            <hr>
                            <form action="" method="POST" enctype="multipart/form-data">
                                <div class="form-group">
                                    <input type="number" name="num" class="form-control" placeholder="Enter Record Id" required>
                                </div>
                                <div class="form-group">
                                    <select name="type" class="btn btn-primary btn-block">
                                        <option value="warnings">Warnings</option>
                                        <option value="kicks">Kicks</option>
                                        <option value="bans">Bans</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <input type="submit" name="delete" class="btn btn-primary btn-block" value="Delete Record">
                                </div>
                            </form>
                        </div>
                        <div class="col-md-8 table-div">
                            <h3 class="h4 text-center text-info">Kicks</h3>
                            <hr>
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Reason</th>
                                        <th>Time</th>
                                        <th>By</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php

                                    if (isset($_GET['search'])) {
                                        $stmt = $conn->prepare("SELECT * FROM kicks WHERE Username = :user");
                                        $stmt->bindParam(':user', $_GET["username"]);
                                        $stmt->execute();

                                        //echo "<table border ='1px'>";
                                        while ($row = $stmt->fetchAll()) {
                                            $count = 0;
                                            foreach ($row as $item) {
                                                $count = $count + 1;
                                                echo '<tr>';
                                                echo '<td>' . $item['id'] . '</td>';
                                                //echo '<td>' . $row1['Username'] . '</td>';
                                                echo '<td>' . $item['Reason'] . '</td>';
                                                echo '<td>' . $item['Time'] . '</td>';
                                                echo '<td>' . $item['By'] . '</td>';
                                                echo '</tr>';
                                            }
                                        }
                                        //echo '</table>';
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-md-4"></div>
                        <div class="col-md-8 table-div">
                            <h3 class="h4 text-center text-info">Bans</h3>
                            <hr>
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Reason</th>
                                        <th>Time</th>
                                        <th>By</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php

                                    if (isset($_GET['search'])) {
                                        $stmt = $conn->prepare("SELECT * FROM bans WHERE Username = :user");
                                        $stmt->bindParam(':user', $_GET["username"]);
                                        $stmt->execute();

                                        //echo "<table border ='1px'>";
                                        while ($row = $stmt->fetchAll()) {
                                            $count = 0;
                                            foreach ($row as $item) {
                                                $count = $count + 1;
                                                echo '<tr>';
                                                echo '<td>' . $item['id'] . '</td>';
                                                //echo '<td>' . $row1['Username'] . '</td>';
                                                echo '<td>' . $item['Reason'] . '</td>';
                                                echo '<td>' . $item['Time'] . '</td>';
                                                echo '<td>' . $item['By'] . '</td>';
                                                echo '</tr>';
                                            }
                                        }
                                        //echo '</table>';
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>

    </html>