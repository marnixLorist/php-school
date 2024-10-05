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

     $email = isset($_POST["email"]) ? $_POST["email"] : "";
     $wWoord = isset($_POST["wachtwoord"]) ? $_POST["wachtwoord"] : "";

     $hashed_wachtwoord = password_hash($wWoord, PASSWORD_DEFAULT);
    

     
    ob_start();
    if (isset($_POST["inloggen"])){
     $email = isset($_POST["email"]) ? $_POST["email"] : "";
     $wachtwoord = isset($_POST["wachtwoord"]) ? $_POST["wachtwoord"] : "";

    
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
    if (!$loginSucces) { 
        echo "wachtwoord of gebruikersnaam is onjuist"; 
    }
} else {
    echo "wachtwoord of gebruikersnaam is onjuist"; 
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
<header>
    <a href="toevoegen.php"><h1 class="toolsForEver">Tools<span class="vier">4</span>Ever<span class="punt">.<span></h1></a>
</header>
<div class="container">
<div class="inloggen">
    <h3 class="inlog">Login</h3>
    <form action="crud.php" method="post" >
    <input type="text" name="email" placeholder="email">
    <input type="password" name="wachtwoord" placeHolder="wachtwoord" minlength="7" required>
    <p  class="accountMaken">geen account? <a href="aanmaken.php"><span>Account aanmaken.</span></a></p>
    <input type="submit" name="knop" class="knop" value="Inloggen" >
    <input type="hidden" name="inloggen">
</form>
    </div>
    </div>
</body>
</html>