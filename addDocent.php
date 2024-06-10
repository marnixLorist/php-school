<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
     $servername = "mysql";
     $username = "root";
     $password = "password";
     
     // Create connection
     $conn = new mysqli($servername, $username, $password, "school");
     
     // Check connection
     if ($conn->connect_error) {
         die("Connection failed: " . $conn->connect_error);
     }
     
     $sNummer = isset($_POST["studentnr"]) ? $_POST["studentnr"] : null;
     $rNaam = isset($_POST["roepNaam"]) ? $_POST["roepNaam"] : null;
     $vLetter = isset($_POST["voorletter"]) ? $_POST["voorletter"] : null;
     $tVoegsels = isset($_POST["tussenvoegsels"]) ? $_POST["tussenvoegsels"] : null;
     $Anaam = isset($_POST["achternaam"]) ? $_POST["achternaam"] : null;
     $adres = isset($_POST["adres"]) ? $_POST["adres"] : null;
     $postcode = isset($_POST["postcode"]) ? $_POST["postcode"] : null;
     $wPlaats = isset($_POST["woonplaats"]) ? $_POST["woonplaats"] : null;
     $geslacht = isset($_POST["geslacht"]) ? $_POST["geslacht"] : null;
     $telefoon = isset($_POST["telefoon"]) ? $_POST["telefoon"] : null;
     $gDatum = isset($_POST["geboortedatum"]) ? $_POST["geboortedatum"] : null;
     $uGeschreven = isset($_POST["uitgeschreven"]) ? $_POST["uitgeschreven"] : null;
     $sGeld = isset($_POST["schoolgeld"]) ? $_POST["schoolgeld"] : null;
     $betaald = isset($_POST["betaald"]) ? $_POST["betaald"] : null;
     
     $stmt = $conn->prepare("INSERT INTO student (studentnr, roepnaam, voorletter, tussenvoegsels, achternaam, adres, postcode, woonplaats, geslacht, telefoon, geboortedatum, uitgeschreven, schoolgeld, betaald) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
     $stmt->bind_param("ssssssssssssss", $sNummer, $rNaam, $vLetter, $tVoegsels, $Anaam, $adres, $postcode, $wPlaats, $geslacht, $telefoon, $gDatum, $uGeschreven, $sGeld, $betaald);
     
     if ($stmt->execute()) {
         echo "De student is toegevoegd";
     } else {
         echo "Er is een fout opgetreden: " . $stmt->error;
     }
     
     $stmt->close();
     $conn->close();
     ?>
     
</body>
</html>