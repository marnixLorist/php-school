<?php
     $servername = "mysql";
     $username = "root";
     $password = "password";
     
     // Create connection
     $conn = new mysqli($servername, $username, $password, "crud");
     
     // Check connection
     if ($conn->connect_error) {
         die("Connection failed: " . $conn->connect_error);
     }

     $accountAangemaakt = false;

     if ($_SERVER["REQUEST_METHOD"] == "POST") {
     if (isset($_POST["voornaam"], $_POST["achternaam"], $_POST["email"], $_POST["wachtwoord"]) && !empty($_POST["voornaam"]) && !empty($_POST["achternaam"])  && !empty($_POST["email"]) && !empty($_POST["wachtwoord"])) {
     $vNaam = isset($_POST["voornaam"]) ? $_POST["voornaam"] : null;
     $aNaam = isset($_POST["achternaam"]) ? $_POST["achternaam"] : null;
     $email = isset($_POST["email"]) ? $_POST["email"] : null;
     $wWoord = isset($_POST["wachtwoord"]) ? $_POST["wachtwoord"] : null;

     $hashed_wachtwoord = password_hash($wWoord, PASSWORD_DEFAULT);
    

     $stmt = $conn->prepare("INSERT INTO inlogInformatie (voornaam, achternaam, email, wachtwoord) VALUES (?, ?, ?, ?)");
     $stmt->bind_param("ssss", $vNaam, $aNaam, $email, $hashed_wachtwoord);
        if($stmt->execute()){
        $accountAangemaakt = true;
    }
    $stmt->close();
        } else {
            echo '<div class="error">Vul alle velden in!</div>';
        }
    }

    
if($accountAangemaakt){
    header("Location: crud.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="aanmaken.css">
</head>
<body>
    <header>
    <a href="crudd.php"><h1 class="toolsForEver">Tools<span class="vier">4</span>Ever<span class="punt">.<span></h1></a>
    </header>
<div class="container">
    <div class="inloggen">
        <h3 class="inlog">Aanmelden</h3>
            <form action="aanmaken.php" method="post">
            <input type="text" name="voornaam" value="" placeholder="Voornaam">
            <input type="text" name="achternaam" value="" placeholder="Achternaam">
            <input type="text" name="email" value="" placeholder="Email"> 
            <input type="password" name="wachtwoord" value="" placeholder="Wachtwoord" minlength="7" required>  
                <a href="crud.php" id="Terug"><p>Terug naar inloggen.</p></a>
            <input type="submit" class="knop" value="Aanmaken"></input> 
    </form>
</div>
</div>
</body>
</html>