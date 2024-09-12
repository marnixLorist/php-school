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

     if ($_SERVER["REQUEST_METHOD"] == "POST") {
     if (isset($_POST["voornaam"], $_POST["achternaam"], $_POST["geboortedatum"], $_POST["email"], $_POST["wachtwoord"]) && !empty($_POST["voornaam"]) && !empty($_POST["achternaam"]) && !empty($_POST["geboortedatum"]) && !empty($_POST["email"]) && !empty($_POST["wachtwoord"])) {
     $vNaam = isset($_POST["voornaam"]) ? $_POST["voornaam"] : null;
     $aNaam = isset($_POST["achternaam"]) ? $_POST["achternaam"] : null;
     $gDatum = isset($_POST["geboortedatum"]) ? $_POST["geboortedatum"] : null;
     $adres = isset($_POST["adres"]) ? $_POST["adres"] : null;
     $postcode = isset($_POST["postcode"]) ? $_POST["postcode"] : null;
     $telefoon = isset($_POST["telefoon"]) ? $_POST["telefoon"] : null;
     $email = isset($_POST["email"]) ? $_POST["email"] : null;
     $wWoord = isset($_POST["wachtwoord"]) ? $_POST["wachtwoord"] : null;

     $hashed_wachtwoord = password_hash($wWoord, PASSWORD_DEFAULT);
    

     $stmt = $conn->prepare("INSERT INTO inlogInformatie (voornaam, achternaam, geboortedatum, adres, postcode, telefoon, email, wachtwoord) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
     $stmt->bind_param("ssssssss", $vNaam, $aNaam, $gDatum, $adres, $postcode, $telefoon, $email, $hashed_wachtwoord);
     $stmt->execute();
        $stmt->close();
        } else {
            echo "Vul alle velden in";
        }
    }


     
    ob_start();
    if (isset($_POST["inloggen"])){
     $email = isset($_POST["email"]) ? $_POST["email"] : null;
     $wachtwoord = isset($_POST["wachtwoord"]) ? $_POST["wachtwoord"] : null;

    
        $stmt = $conn->prepare("SELECT * FROM inlogInformatie WHERE email = ? ");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        $loginSucces = false;

     
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        if (password_verify($wachtwoord, $row["wachtwoord"])) {
            header("Location: toolsforever.php");
            $loginSucces = true;
            break;
        }
    }
    if (!$loginSucces) { // Controleer of de login niet succesvol was
        echo "wachtwoord of gebruikersnaam is onjuist"; // Echo de foutmelding slechts één keer
    }
} else {
    echo "wachtwoord of gebruikersnaam is onjuist"; // Echo de foutmelding als er geen rijen zijn
}
    $stmt->close();
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
    <h3 class="inlog">inloggen</h3>
    <div class="inloggen">

    <form action="crud.php" method="post" >
    email <input type="text" name="email" value="">
    wachtwoord <input type="password" name="wachtwoord" value="">
    <input type="submit" name="knop">
    </div>
    <input type="hidden" name="inloggen">
    </form>

    <h3 class="account">account aanmaken</h3>
    <div class="forms">
    <form action="crud.php" method="post">
    voornaam <input type="text" name="voornaam" value=""> <br>
    achternaam <input type="text" name="achternaam" value=""> <br>
    geboortedatum <input type="text" name="geboortedatum" value=""> <br>
    adres <input type="text" name="adres" value=""> <br>
    postcode <input type="text" name="postcode" value=""> <br>
    telefoon <input type="text" name="telefoon" value=""> <br>
    email <input type="text" name="email" value=""> <br>
    wachtwoord <input type="password" name="wachtwoord" value=""> <br>   
    <button type="submit" class="submit">Submit</button>
    </div>

</body>
</html>