<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="mrWheely.css">
</head>
<body>
    <?php
     $servername = "mysql";
     $username = "root";
     $password = "password";
     
     // Create connection
     $conn = new mysqli($servername, $username, $password, "mrWheely");
     
     // Check connection
     if ($conn->connect_error) {
         die("Connection failed: " . $conn->connect_error);
     }else{
         $merk = isset($_POST["merk"]) ? $_POST["merk"] : null;
         $type = isset($_POST["type"]) ? $_POST["type"] : null;
         $minPrijs = isset($_POST["minPrijs"]) ? $_POST["minPrijs"] : null;
         $maxPrijs = isset($_POST["maxPrijs"]) ? $_POST["maxPrijs"] : null;
     }
     ?>
    <div class="result">
        <?php
      echo $merk  . "<br>";
      echo $type . "<br>";
      echo $minPrijs . "<br>";
      echo $maxPrijs    . "<br>";
    ?>
      </div>
</body>
</html>