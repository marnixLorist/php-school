<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
    // $servername = "mysql";
    // $username = "root";
    // $password = "password";
    // $dbname = "school;port=3306";
    // $dbh = new PDO('mysql:host=' . $servername . ';dbname=' . $dbname , $username, $password); 
    $servername = "mysql";
    $username = "root";
    $password = "password";


    // Create connection
    $conn = new mysqli($servername, $username, $password, "school");


    // Check connection
    if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
    }

    $query = "SELECT * FROM student";
    $stmt = $conn->query($query);
    $result = $stmt->fetch_all(MYSQLI_ASSOC);
    foreach($result as $row) {
        echo $row['studentnr'] . " " . $row['roepnaam'] . " " . $row['telefoon'] . "<br>";
    }

    ?>
</body>
</html>