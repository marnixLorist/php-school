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
     if (isset($_POST["voornaam"], $_POST["achternaam"], $_POST["geboortedatum"], $_POST["email"], $_POST["wachtwoord"]) && !empty($_POST["voornaam"]) && !empty($_POST["achternaam"]) && !empty($_POST["geboortedatum"]) && !empty($_POST["email"]) && !empty($_POST["wachtwoord"])) {
     $vNaam = isset($_POST["voornaam"]) ? $_POST["voornaam"] : null;
     $aNaam = isset($_POST["achternaam"]) ? $_POST["achternaam"] : null;
     $gDatum = isset($_POST["geboortedatum"]) ? $_POST["geboortedatum"] : null;
     $adres = isset($_POST["adres"]) ? $_POST["adres"] : null;
     $postcode = isset($_POST["postcode"]) ? $_POST["postcode"] : null;
     $telefoon = isset($_POST["telefoon"]) ? $_POST["telefoon"] : null;
     $email = isset($_POST["email"]) ? $_POST["email"] : null;
     $wWoord = isset($_POST["wachtwoord"]) ? $_POST["wachtwoord"] : null;

     $stmt = $conn->prepare("INSERT INTO inlogInformatie (voornaam, achternaam, geboortedatum, adres, postcode, telefoon, email, wachtwoord) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
     $stmt->bind_param("ssssssss", $vNaam, $aNaam, $gDatum, $adres, $postcode, $telefoon, $email, $wWoord);
     $stmt->execute();
        } 
     
    ob_start();
     $email = isset($_POST["email"]) ? $_POST["email"] : null;
     $wachtwoord = isset($_POST["wachtwoord"]) ? $_POST["wachtwoord"] : null;

     
        $stmt = $conn->prepare("SELECT * FROM inlogInformatie WHERE email = ? AND wachtwoord = ?");
        $stmt->bind_param("ss", $email, $wachtwoord);
        $stmt->execute();
        $result = $stmt->get_result();



     
if ($result->num_rows > 0) {
    header("Location: crudd.php");
    exit;
} else {
    // Zorg ervoor dat je de statement sluit voordat je een nieuwe uitvoert

    echo "verkeerke inloggegevens";
    $stmt->close();
    
    // Voer hier eventuele extra logica of queries uit
}

$conn->close();
ob_end_flush();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="crud.css">
</head>
<body>
    <h3>inloggen</h3>
    <form action="crud.php" method="post" >
    email <input type="text" name="email" value="">
    wachtwoord <input type="password" name="wachtwoord" value="">
    <input type="submit" name="knop">
    </form>
    <h3>account aanmaken</h3>
    <form action="crud.php" method="post">
    voornaam <input type="text" name="voornaam" value=""> <br>
    achternaam <input type="text" name="achternaam" value=""> <br>
    geboortedatum <input type="text" name="geboortedatum" value=""> <br>
    adres <input type="text" name="adres" value=""> <br>
    postcode <input type="text" name="postcode" value=""> <br>
    telefoon <input type="text" name="telefoon" value=""> <br>
    email <input type="text" name="email" value=""> <br>
    wachtwoord <input type="password" name="wachtwoord" value=""> <br>   
    <button type="submit">Submit</button>


</body>
</html>