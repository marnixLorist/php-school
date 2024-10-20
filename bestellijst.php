<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bestellijst</title>
    <link rel="stylesheet" href="bestellijst.css">
    <script src="https://kit.fontawesome.com/e0d2d263ae.js" crossorigin="anonymous"></script>
</head>
<body>
    <header>
        <h2 class="tools">tools<span id="four">4</span>ever<span id="p">.</span></h2>
        <h2 class="Bestel">Bestellijst<span class="punt">.</span></h2>
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

    <p>Tools4Ever © 2024</p>

    <?php
    // Database verbinding
    $servername = "mysql";
    $username = "root";
    $password = "password";
    
    $conn = new mysqli($servername, $username, $password, 'toolsforever');

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["delete_id"])) {
        $delete_id = $_POST["delete_id"];

        $sql_delete_lijst = "DELETE FROM lijst WHERE idBestelling = ?";
        $stmt_delete_lijst = $conn->prepare($sql_delete_lijst);
        $stmt_delete_lijst->bind_param("i", $delete_id);
        $stmt_delete_lijst->execute();
        $stmt_delete_lijst->close();

        $sql_delete_bestelling = "DELETE FROM bestelling WHERE idBestelling = ?";
        $stmt_delete_bestelling = $conn->prepare($sql_delete_bestelling);
        $stmt_delete_bestelling->bind_param("i", $delete_id);
        $stmt_delete_bestelling->execute();
        $stmt_delete_bestelling->close();

        echo "Bestelling succesvol verwijderd.";
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['idartikel']) && isset($_POST['aantal'])) {
        $idVestiging = $_POST['locatieSelect'];
        $besteldatum = $_POST['besteldatum'];

        $sql_insert_bestelling = "INSERT INTO bestelling (idVestiging, besteldatum) VALUES ('$idVestiging', '$besteldatum')";
        if ($conn->query($sql_insert_bestelling) === TRUE) {
            $idBestelling = $conn->insert_id;

            foreach ($_POST['idartikel'] as $index => $idArtikel) {
                $aantal = $_POST['aantal'][$index];
                $sql_insert_lijst = "INSERT INTO lijst (idBestelling, idArtikel, aantal) VALUES ('$idBestelling', '$idArtikel', '$aantal')";
                if ($conn->query($sql_insert_lijst) !== TRUE) {
                    echo "Fout bij het toevoegen van product: ";
                }
            }

            echo "Bestelling succesvol toegevoegd!";
        } else {
            echo "Fout bij het toevoegen van bestelling: ";
        }
    }
    ?>

    <!-- Bestelformulier -->
    <form action="bestellijst.php" method="POST">
        <label for="locatieSelect">Select locatie:</label>
        <select name="locatieSelect" id="locatieSelect">
            <option value="1">Rotterdam</option>
            <option value="2">Almere</option>
            <option value="3">Eindhoven</option>
        </select><br><br>
        Besteldatum:<input type="date" name="besteldatum" id="besteldatum" required><br><br>

        <div id="productFields">
            product id:<input type="number" name="idartikel[]" required>
            aantal<input type="number" name="aantal[]" required><br><br>
        </div>

        <button type="button" onclick="addProductField()">Voeg nog een product toe</button><br><br>
        <input type="submit" value="Bestellen">
    </form>

    <h3>Overzicht van bestellingen:</h3>
    <?php
    $sql_bestellingen = "SELECT bestelling.idBestelling, bestelling.besteldatum, vesteging.naam AS locatie
                         FROM bestelling
                         INNER JOIN vesteging ON bestelling.idVestiging = vesteging.idVestiging
                         ORDER BY bestelling.idBestelling DESC";
    $result_bestellingen = $conn->query($sql_bestellingen);

    if ($result_bestellingen->num_rows > 0) {
        while ($bestelling = $result_bestellingen->fetch_assoc()) {
            echo "<div class='bestelling'>";
            echo "<h3>Bestelling ID: " . $bestelling["idBestelling"] . " | Datum: " . $bestelling["besteldatum"] . " | Locatie: " . $bestelling["locatie"] . "</h3>";
            
            $sql_bestellijst = "SELECT artikel.naam AS naam, artikel.type AS type, artikel.fabriek AS fabriek, lijst.aantal AS aantal_besteld
                                FROM lijst
                                INNER JOIN artikel ON lijst.idartikel = artikel.idartikel
                                WHERE lijst.idBestelling = " . $bestelling["idBestelling"];
            $result_bestellijst = $conn->query($sql_bestellijst);

            if ($result_bestellijst->num_rows > 0) {
                echo "<table>";
                echo "<tr><th>Product</th><th>Type</th><th>Fabriek</th><th>Aantal</th></tr>";

                while ($row = $result_bestellijst->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row["naam"] . "</td>";
                    echo "<td>" . $row["type"] . "</td>";
                    echo "<td>" . $row["fabriek"] . "</td>";
                    echo "<td>" . $row["aantal_besteld"] . "</td>";
                    echo "</tr>";
                }

                echo "</table>";
            }
            echo "<form action='bestellijst.php' method='POST'>";
            echo "<input type='hidden' name='delete_id' value='" . $bestelling["idBestelling"] . "'>";
            echo "<input type='submit' value='Verwijderen'>";
            echo "</form>";
            echo "</div><br>";
        }
    } else {
        echo "<p>Geen bestellingen gevonden.</p>";
    }

    $conn->close();
    ?>

    <script>
        function addProductField() {
            const productFields = document.getElementById('productFields');
            const newField = document.createElement('div');
            newField.innerHTML = `
                product:ID<input type="number" name="idartikel[]" required>
                aantal:<input type="number" name="aantal[]" required><br><br>
            `;
            productFields.appendChild(newField);
        }
    </script>
</body>
</html>
