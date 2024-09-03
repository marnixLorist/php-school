<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="mrWheely.css">
</head>
<body>
    <header><h1 class="mrWheely">mrWheely</h1></header>
    <div class="forms"  >
    <form action="mrWheely.php" method="post">
    <label for="merk">Merk</label>
    <select name="merk" id="merk">
        <option value="audi">Audi</option>
        <option value="bmw">BMW</option>
        <option value="mercedes">Mercedes</option>
        <option value="volkswagen">Volkswagen</option>
        <option value="volvo">Volvo</option>
    </select>
    <label for="type">Type</label>
    <select name="type" id="type">
        <option value="Null">Null</option>
        <option value="m4">m4</option>
        <option value="a1">A1</option>
        <option value="a3">A3</option>
        <option value="a4">A4</option>
        <option value="rs6">rs6</option>
    </select>
    <label for="prijs">prijs</label>
    <input type="text" name="prijs" value="">
    <button type="submit">Submit</button>
    </form>
</div>

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
        $prijs = isset($_POST["prijs"]) ? $_POST["prijs"] : null;
        
    }
     ?>
        <?php
     if ($prijs) {
        $sql = "SELECT * FROM auto WHERE merk = '$merk' AND type = '$type' AND prijs = '$prijs'";
    } else {    
        $sql = "SELECT * FROM auto WHERE merk = '$merk' AND type = '$type'";
    }
    $result = $conn->query($sql);
    ?>
    <div class="sql">
    <?php
    if($merk == 'audi'){
        echo '<img src="rs6.jpg" alt="rs6.jpg">' . '<br>';
    }
    if($merk == 'bmw'){
        echo '<img src="m4.jpg" alt="m4.jpg">' . '<br>';
    }
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            echo '<div class="result">';
            echo "Merk: " . $row["merk"]. "<br>";
            echo "Type: " . $row["type"]. "<br>";
            echo "Prijs: " . $row["prijs"]. "<br>";
            echo '</div>';
        }
    } else {
        echo "Geen resultaten gevonden";
    }
    $conn->close();
    ?>
    </div>
</body>
</html>