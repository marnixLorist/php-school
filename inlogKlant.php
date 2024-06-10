<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$servername = "mysql";
$username = "root";
$password = "password";

// Create connection
$conn = new mysqli($servername, $username, $password, "inlogKlant");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$email = isset($_POST["email"]) ? $_POST["email"] : null;
$wachtwoord = isset($_POST["wachtwoord"]) ? $_POST["wachtwoord"] : null;

$stmt = $conn->prepare("SELECT * FROM inlog WHERE email = ? AND pass = ?");
$stmt->bind_param("ss", $email, $wachtwoord);
$stmt->execute();

$result = $stmt->get_result();
if ($result->num_rows > 0) {
    $message = "Welkom";
} else if($result->num_rows == 0) {
    header("Location: inlogklant.html");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php echo $message; ?>
</body>
</html>