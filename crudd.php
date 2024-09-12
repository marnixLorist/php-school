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

if (isset($_POST['updateKnop'])) {
    $voornaam = $_POST['voornaam'];
    $achternaam = $_POST['achternaam'];
    $nieuwEmail = $_POST['nieuwEmail'];
    $nieuwWachtwoord = $_POST['nieuwWachtwoord'];

    $hashed_wachtwoord = password_hash($nieuwWachtwoord, PASSWORD_DEFAULT);

    $stmt = $conn->prepare("UPDATE inlogInformatie SET email = ?, wachtwoord = ? WHERE voornaam = ? AND achternaam = ?");
    $stmt->bind_param("ssss", $nieuwEmail, $hashed_wachtwoord, $voornaam, $achternaam);
    $stmt->execute();
}


    if (isset($_POST['submitKnop'])) {
        $voornaam = $_POST['voornaam'];
        $achternaam = $_POST['achternaam'];
        $adres = $_POST['adres'];
        $postcode = $_POST['postcode'];
        $telefoon = $_POST['telefoon'];
    
        $stmt = $conn->prepare("UPDATE inlogInformatie SET adres = ?, postcode = ?, telefoon = ? WHERE voornaam = ? AND achternaam = ?");
        $stmt->bind_param("sssss", $adres, $postcode, $telefoon, $voornaam, $achternaam);
    
        $stmt->execute();
    }
    
    if (isset($_POST['verwijderAcc'])) {
        $voornaam = $_POST['voornaam'];
        $achternaam = $_POST['achternaam'];
    
        $stmt = $conn->prepare("DELETE FROM inlogInformatie WHERE voornaam = ? AND achternaam = ?");
        $stmt->bind_param("ss", $voornaam, $achternaam);
    
        $stmt->execute();
                $stmt->close();
    }   



?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="crudd.css">
    </head>
    <body>
<h1 class="inlog" >succesvol ingelogd.</h1>
<div class="gegevens">
    <h3>Update je email en wachtwoord</h3>
    <form action="crudd.php" method="post" >
    voornaam <input type="text" name="voornaam" value="">
    achternaam <input type="text" name="achternaam" value="">
    nieuwe email <input type="text" name="nieuwEmail" value="">
    nieuw wachtwoord <input type="password" name="nieuwWachtwoord" value="">
    

    <input type="submit" name="updateKnop">
    </form>
    <h3>Update je adres, postcode en telefoon</h3>
    <form action="crudd.php" method="post">
    voornaam <input type="text" name= 'voornaam' value=""> 
    achternaam <input type="text" name="achternaam" value="">
    nieuw adres <input type="text" name="adres" value="">
    nieuwe postcode <input type="text" name="postcode" value="">
    nieuwe telefoon <input type="text" name="telefoon" value=""> 
    <input type="submit" name="submitKnop">
    </form>
    <h3>verwijder account</h3>
    <form action="crudd.php" method="post">
    voornaam <input type="text" name="voornaam" value="">
    achternaam <input type="text" name="achternaam" value="">
    <input type="submit" name='verwijderAcc'>
    </form>
    </div>
</body>
</html>