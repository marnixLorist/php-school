<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="toolsforever1.css">
    <script src="https://kit.fontawesome.com/e0d2d263ae.js" crossorigin="anonymous"></script>
</head>
<body>
    <header>
        <h2 class="tools">tools<span id="four">4</span>ever<span id="p">.</span></h2>
        <h2 class="voorraad">Voorraad<span class="punt" >.</span></h2>
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
    <form action="toolsforever1.php" method="post">
        <div class="locatieSelect">
            <label for='opties'>Filter per locatie</label>
            <select name="opties" class="decorated">
                <option value="Almere">Almere</option>
                <option value="Eindhoven">Eindhoven</option>
                <option value="Rotterdam">Rotterdam</option>
            </select>
            <input type="submit" value="submit">
        </div>
    </form>

    <?php
    $servername = "mysql";
    $username = "root";
    $password = "password";

    $conn = new mysqli($servername, $username, $password, "toolsforever");

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    //delete die dproduct
    if (isset($_POST['delete'])) {
        $idArtikel = $_POST['idartikel'];
        $idVestiging = $_POST['idvestiging'];
        $sql_delete = "DELETE FROM voorraad WHERE idArtikel = ? AND idVestiging = ?";
        $stmt_delete = $conn->prepare($sql_delete);
        $stmt_delete->bind_param("ii", $idArtikel, $idVestiging);
        if ($stmt_delete->execute()) {
            echo "<div class='alert alert-success'>Product verwijderd</div>";
        } else {
            echo "<div class='alert alert-danger'>Kan product niet verwijderen</div>";
        }
        $stmt_delete->close();
    }

    // opslaan aangepaste fomrs
    if (isset($_POST['save'])) {
        $idArtikel = $_POST['idartikel'];
        $naam = $_POST['naam'];
        $type = $_POST['type'];
        $fabriek = $_POST['fabriek'];
        $aantal = $_POST['aantal'];
        $prijs = $_POST['prijs'];

        $sql_update = "UPDATE artikel
                       INNER JOIN voorraad ON artikel.idartikel = voorraad.idartikel
                       SET artikel.naam = ?, artikel.type = ?, artikel.fabriek = ?, voorraad.aantal = ?, artikel.waardeverkoop = ?
                       WHERE artikel.idartikel = ?";
        $stmt_update = $conn->prepare($sql_update);
        $stmt_update->bind_param("sssddi", $naam, $type, $fabriek, $aantal, $prijs, $idArtikel);

        if ($stmt_update->execute()) {
            echo "<div class='alert alert-success'>Gegevens succesvol bijgewerkt</div>";
        } else {
            echo "<div class='alert alert-danger'>Fout bij het bijwerken van de gegevens</div>";
        }
        $stmt_update->close();
    }

    // voor bewerken gegevens
    if (isset($_GET['idartikel'])) {
        $idArtikel = $_GET['idartikel'];

        $sql_edit = "SELECT artikel.naam AS naam, artikel.type AS type, artikel.fabriek AS fabriek, voorraad.aantal AS aantal, artikel.waardeverkoop AS prijs
                     FROM artikel
                     INNER JOIN voorraad ON artikel.idartikel = voorraad.idartikel
                     WHERE artikel.idartikel = ?";
        $stmt_edit = $conn->prepare($sql_edit);
        $stmt_edit->bind_param("i", $idArtikel);
        $stmt_edit->execute();
        $result_edit = $stmt_edit->get_result();

        if ($result_edit->num_rows > 0) {
            $row_edit = $result_edit->fetch_assoc();
            ?>
            <!-- pas die ding aan -->
            <form action="toolsforever1.php" method="post">
                <input type="hidden" name="idartikel" value="<?php echo $idArtikel; ?>">
                naam<input type="text" name="naam" value="<?php echo $row_edit['naam']; ?>"><br>
                type<input type="text" name="type" value="<?php echo $row_edit['type']; ?>"><br>
                fabriek<input type="text" name="fabriek" value="<?php echo $row_edit['fabriek']; ?>"><br>
                aantal<input type="number" name="aantal" value="<?php echo $row_edit['aantal']; ?>"><br>
                prijs<input type="number" step="0.01" name="prijs" value="<?php echo $row_edit['prijs']; ?>"><br>
                <button type="submit" name="save" class="btn btn-success">Opslaan</button>
            </form>
            <?php
        } else {
            echo "<div class='alert alert-danger'>Geen gegevens gevonden voor dit artikel</div>";
        }
    }
    $locatieOptie = isset($_POST['opties']) ? $_POST['opties'] : "";

    // selecteer die ding
    $sql_select = "SELECT artikel.idartikel, artikel.naam AS naam, artikel.type AS type, artikel.fabriek AS fabriek, voorraad.aantal AS aantal, artikel.waardeverkoop AS prijs, vesteging.idVestiging, vesteging.naam AS locatie
                   FROM artikel
                   INNER JOIN voorraad ON artikel.idartikel = voorraad.idartikel
                   INNER JOIN vesteging USING(idVestiging)";

    if (!empty($locatieOptie)) {
        $sql_select .= " WHERE vesteging.naam = ?";
    }
    $stmt_select = $conn->prepare($sql_select);

    if (!empty($locatieOptie)) {
        $stmt_select->bind_param("s", $locatieOptie);
    }
    $stmt_select->execute();
    $result = $stmt_select->get_result();

    if ($result->num_rows > 0) {
        echo '<table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Naam</th>
                        <th>Type</th>
                        <th>Fabriek</th>
                        <th>Aantal</th>
                        <th>Prijs</th>
                        <th>Locatie</th>   
                        <th>Delete/Edit</th> 
                    </tr>
                </thead>
                <tbody>';
        while ($row = $result->fetch_assoc()) {
            echo '<tr>
                    <td>' . $row["naam"] . '</td>
                    <td>' . $row["type"] . '</td>
                    <td>' . $row["fabriek"] . '</td>
                    <td>' . $row["aantal"] . '</td>
                    <td>' . $row["prijs"] . '</td>
                    <td>' . $row["locatie"] . '</td>
                    <td>
                        <form action="toolsforever1.php" method="post" style="display:inline;">
                            <input type="hidden" name="idartikel" value="' . $row["idartikel"] . '">
                            <input type="hidden" name="idvestiging" value="' . $row["idVestiging"] . '">
                            <button type="submit" name="delete" class="btn btn-danger">Delete</button>
                        </form>
                        <form action="toolsforever1.php" method="get" style="display:inline;">
                            <input type="hidden" name="idartikel" value="' . $row["idartikel"] . '">
                            <button type="submit" class="btn btn-primary">Edit</button>
                        </form>
                    </td>
                  </tr>';
        }
        echo '</tbody></table>';
    } else {
        echo "<div class='alert alert-info'>Geen producten gevonden</div>";
    }

    $conn->close();
    ?>
</body>
</html>
