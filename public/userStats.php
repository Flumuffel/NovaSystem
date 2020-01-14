<?php
session_start();
if (!isset($_SESSION["id"])) {
    // Benutzer begruessen
    header("Location: https://nova.flumuffel.tk/");
    exit;
}
include 'functions.php';
include 'rankmanager.php';
include 'functions/navbar.php';
include 'config.php';

?>
    <!DOCTYPE html>
    <html>

    <head>
        <title>Nova System | User Stats</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.8/css/solid.css">
        <script src="https://use.fontawesome.com/releases/v5.0.7/js/all.js"></script>
  
    </head>

    <body>
        <div class="container-fluid" style="padding-top: 20px; padding-bottom: 20px;">
            <div class="col-md-100 main-section">
                <div class="modal-content">
                    <div class="row" style="padding-left: 10px; padding-right: 10px; padding-top: 20px;">
                          <div class="col-md-12">
                              <h3 class="h4 text-center text-info">Notes</h3>
                              <hr>
                              <table class="table table-bordered table-hover">
                                  <thead>
                                      <tr>
                                          <th>Username</th>
                                          <th>Notes</th>
                                          <th>Warnings</th>
                                          <th>Kicks</th>
                                          <th>Bans</th>
                                      </tr>
                                  </thead>
                                  <tbody>
                                      <?php
                                          $user = $conn->prepare("SELECT * FROM users ORDER BY Username ASC");
                                          $user->execute();
                                          while ($row = $user->fetchAll()) {
                                              $count = 0;
                                              foreach ($row as $item) {
                                                  $username = $item['Username'];
                                                  $stmt = $conn->prepare("SELECT * FROM notes WHERE Creator = :user"); 
                                                  $stmt->bindParam(':user', $item['Username']);
                                                  $stmt->execute();
                                                  $stats['notes'] = $stmt->fetchAll();
                                                  $stmt = $conn->prepare("SELECT * FROM warnings WHERE Creator = :user"); 
                                                  $stmt->bindParam(':user', $item['Username']);
                                                  $stmt->execute();
                                                  $stats['warnings'] = $stmt->fetchAll();
                                                  $stmt = $conn->prepare("SELECT * FROM kicks WHERE Creator = :user"); 
                                                  $stmt->bindParam(':user', $item['Username']);
                                                  $stmt->execute();
                                                  $stats['kicks'] = $stmt->fetchAll();
                                                  $stmt = $conn->prepare("SELECT * FROM bans WHERE Creator = :user"); 
                                                  $stmt->bindParam(':user', $item['Username']);
                                                  $stmt->execute();
                                                  $stats['bans'] = $stmt->fetchAll();
                                                  $control = 0;
                                                  foreach ($stats as $item) {
                                                    $count = 0;
                                                    foreach($item as $item) {
                                                      $count = $count + 1;
                                                    }
                                                    $statsR[$control] = $count;
                                                    $control = $control + 1;
                                                  }
                                                
                                                  echo '<tr>';
                                                  echo '<td>' . $username . '</td>';
                                                  echo '<td>' . $statsR[0] . '</td>';
                                                  echo '<td>' . $statsR[1] . '</td>';
                                                  echo '<td>' . $statsR[2] . '</td>';
                                                  echo '<td>' . $statsR[3] . '</td>';
                                                  echo '</tr>';
                                              }
                                            }
                                              //echo '</table>';
                                      ?>
                                  </tbody>
                              </table>
                          </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>

    </html>