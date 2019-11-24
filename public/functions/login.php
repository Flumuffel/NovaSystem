<?php
session_start();

if ( isset($_SESSION["id"]) )
{
    // Benutzer begruessen
    header("Location:http://localhost/nova/desktop.php"); 
    exit;
}

if ( !empty($_POST['benutzername']) and !empty($_POST['kennwort'])  )
{
    // Kontrolle, ob Benutzername und Kennwort korrekt
    // diese werden i.d.R. aus Datenbank ausgelesen

    // UNSICHER!
    //$pdo = new PDO('mysql:host=localhost;dbname=NovaSystem', 'root', '');
    //$sql = "SELECT user FROM users WHERE password = '". $_POST["kennwort"] ."'";
    //$data = $pdo->query($sql)

    $db = new PDO('mysql:host=localhost;dbname=NovaSystem', 'root', ''); 
    $stmt = $db->prepare("SELECT * FROM users WHERE user = :user"); 
    $stmt->bindParam(':user', $_POST["benutzername"]);
    $stmt->execute(); 

    $row = $stmt->fetch();

    $Erfolgreich = false;

    if(!empty($row)) {
        $Erfolgreich = password_verify($_POST["kennwort"], $row["password"]);
    }

    if ($Erfolgreich)
    {
        $_SESSION['id'] = $row['id'];
        $_SESSION['benutzername'] = $_POST['benutzername'];
        header("Location: http://localhost/nova/desktop.php"); 
        echo "<b>einloggen erfolgreich</b>";
    }
    else
    {
        header("Location: http://localhost/nova/?error"); 
        echo "<b>ungültige Eingabe</b>";
        unset($_SESSION["id"]);
    }
}
 

// hier kommt Programmteil/Datenausgabe für berechtige Benutzer ...
?>