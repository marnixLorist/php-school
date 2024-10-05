<?php
     $servername = "mysql";
     $username = "root";
     $password = "password";
     
     // Create connection
     $conn = new mysqli($servername, $username, $password, "toolsForEver");
     
     // Check connection
     if ($conn->connect_error) {
         die("Connection failed: " . $conn->connect_error);
     }
     if ($_SERVER["REQUEST_METHOD"] == "POST") {
     if (isset($_POST["locatie"], $_POST["product"], $_POST["type"], $_POST["fabriek"], $_POST["aantal"], $_POST["prijs"], $_POST["inkoopprijs"], $_POST["verkoopprijs"]) && !empty($_POST["locatie"]) && !empty($_POST["product"]) && !empty($_POST["type"]) && !empty($_POST["fabriek"]) && !empty($_POST["aantal"]) && !empty($_POST["prijs"]) && !empty($_POST["inkoopprijs"]) && !empty($_POST["verkoopprijs"])) {
     $locatie = isset($_POST["locatie"]) ? $_POST["locatie"] : null;
     $product = isset($_POST["product"]) ? $_POST["product"] : null;
     $type = isset($_POST["type"]) ? $_POST["type"] : null;
     $fabriek = isset($_POST["fabriek"]) ? $_POST["fabriek"] : null;
     $aantal = isset($_POST["aantal"]) ? $_POST["aantal"] : null;
     $prijs = isset($_POST["prijs"]) ? $_POST["prijs"] : null;
     $iPrijs = isset($_POST["inkoopprijs"]) ? $_POST["inkoopprijs"] : null;
     $vPrijs = isset($_POST["verkoopprijs"]) ? $_POST["verkoopprijs"] : null;

    $stmt = $conn->prepare("INSERT INTO artikel ( locatie, product, type, fabriek, aantal, prijs, inkoopprijs, verkoopprijs) VALUES ( ?, ?, ?, ?, ?, ?, ?,?)");
    $stmt->bind_param("ssssiiii", $locatie, $product, $type, $fabriek, $aantal, $prijs, $iPrijs, $vPrijs);
    $stmt->execute();
    $stmt->close();

    $selectLocatie = isset($_POST["locatie"]) ? $_POST["locatie"] : null;

    } else {
        echo "<span class='name'>" . 'Vul alles in.' . "</span>";
    }
}
    
       
        
     ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>
        <link rel="stylesheet" href="toevoegen.css">
        <script src="https://kit.fontawesome.com/e0d2d263ae.js" crossorigin="anonymous"></script>
    </head>
    <body>
    <header>
        <h2 class="tools">tools<span id="four">4</span>ever<span id="p">.</span></h2>
        <h2 class="voegen">toevoegen<span class="punt" >.</span></h2>
        <div class="dropdown">
        <button class="dropbtn"><i class="fa-solid fa-bars"></i></button>
        <div class="dropdown-content">
        <a href="toolsforever.php">home</a>
        <a href="toolsforever1.php">voorraad</a>
        <a href="bestellijst.php">bestellijst</a>
        </div>
        </div>
    </header>
    <div class="forms">
    <form action="toevoegen.php" method="post" > 
        <div class="inhoudFr">
            <label for="locatie">locatie</label>
            <select name="locatie" id="">
                <option value="Almere">Almere</option>
                <option value="Eindhoven">Eindhoven</option>
                <option value="Rotterdam">Rotterdam</option>
            </select>
        product<input type="text" name="product" value="">   
        type<input type="text" name="type" value="">
        fabriek<input type="text" name="fabriek" value="">
        aantal<input type="number" name="aantal" value="">
        prijs<input type="text" name="prijs" value="">
        inkoopprijs<input type="text" name="inkoopprijs" value="">
        verkoopprijs<input type="text" name="verkoopprijs" value="">
        </div>
        <div class="outline">
        <button type="submit"  class="submit">toevoegen</button>
        </div>
        <input type="hidden" name="check">
     </form>
     </div>
     <p>Tools4Ever © 2024</p>
</body>
</html>