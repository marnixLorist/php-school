<?php
$servername = "mysql";
$username = "root";
$password = "password";

$conn = new mysqli($servername, $username, $password, "toolsforever");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["idProduct"], $_POST["idVestiging"], $_POST["aantal"]) && !empty($_POST["idProduct"]) && !empty($_POST["idVestiging"]) && !empty($_POST["aantal"])) {
        $idProduct = $_POST["idProduct"];
        $idVestiging = $_POST["idVestiging"];
        $aantal = $_POST["aantal"];

        $stmt = $conn->prepare("INSERT INTO voorraad (idArtikel, idVestiging, aantal) VALUES (?, ?, ?) 
                                ON DUPLICATE KEY UPDATE aantal = aantal + VALUES(aantal)");
        if ($stmt === false) {
            die("kan niet toevoegen: ");
        }

        $stmt->bind_param("iii", $idProduct, $idVestiging, $aantal);
        if ($stmt->execute() === false) {
            die("kan niet toevoegen: ");
        }

        $stmt->close();
        echo "Gegevens succesvol toegevoegd.";
    } else {
        echo "<span class='name'>Vul alles in.</span>";
    }
}

$query = "SELECT idArtikel, naam FROM artikel";
$result = $conn->query($query);
?>

    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>
        <link rel="stylesheet" href="voorraad.css">
        <script src="https://kit.fontawesome.com/e0d2d263ae.js" crossorigin="anonymous"></script>
    </head>
    <body>
    <header>
        <h2 class="tools">tools<span id="four">4</span>ever<span id="p">.</span></h2>
        <h2 class="voegen">toevoegen aan voorraad<span class="punt" >.</span></h2>
        <div class="dropdown">
        <button class="dropbtn"><i class="fa-solid fa-bars"></i></button>
        <div class="dropdown-content">
        <a href="toolsforever.php">home</a>
                <a href="toevoegen.php">product</a>
                <a href="bestellijst.php">bestellijst</a>
                <a href="voorraad.php">toevoegen</a>
                <a href="toolsforever1.php">voorraad</a>
        </div>
        </div>
    </header>
    <div class="forms">
    <form action="voorraad.php" method="post" > 
        <div class="inhoudFr">
        Product<input type="number" name="idProduct" value="">   
        Vestiging<input type="number" name="idVestiging" value="">
        Aantal<input type="text" name="aantal" value="">
        </div>
        <div class="outline">
        <button type="submit"  class="submit">toevoegen</button>
        </div>
        <input type="hidden" name="check">
     </form>
     </div>

     <div class="vestiging">
     <h2>Vestiging nummers:</h2>
     <h3>1 = Rotterdam</h3>
     <h3>2 = Almere</h3>
     <h3>3 = Eindhoven</h3>
     </div>

     
        <table>
            <tr>
                <th>Product nmr</th>
                <th>Naam</th>
            </tr>
            <?php
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<tr><td>" . $row["idArtikel"] . "</td><td>" . $row["naam"] . "</td></tr>";
                }
            } else {
                echo "<tr><td>Geen artikelen gevonden</td></tr>";
            }
            ?>
        </table>
     <p>Tools4Ever © 2024</p>
</body>
</html>