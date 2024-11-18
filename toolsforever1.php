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

    // aantal aanpassen
if (isset($_POST['save'])) {
    $idArtikel = $_POST['idartikel'];
    $aantal = $_POST['aantal'];
    $idVestiging = $_POST['idvestiging'];

    $sql_update = "UPDATE voorraad
                   SET aantal = ?
                   WHERE idartikel = ? AND idVestiging = ?";

    $stmt_update = $conn->prepare($sql_update);
    $stmt_update->bind_param("iii", $aantal, $idArtikel, $idVestiging);

    if ($stmt_update->execute()) {
        echo "<div class='alert alert-success'>Aantal succesvol bijgewerkt</div>";
    } else {
        echo "<div class='alert alert-danger'>Fout bij het bijwerken van het aantal</div>";
    }
    $stmt_update->close();
}

// Voor bewerken gegevens
if (isset($_GET['idartikel']) && isset($_GET['idvestiging'])) {
    $idArtikel = $_GET['idartikel'];
    $idVestiging = $_GET['idvestiging'];

    $sql_edit = "SELECT artikel.naam AS naam, artikel.type AS type, artikel.fabriek AS fabriek, voorraad.aantal AS aantal, artikel.waardeverkoop AS prijs, voorraad.idVestiging
                 FROM artikel
                 INNER JOIN voorraad ON artikel.idartikel = voorraad.idartikel
                 WHERE artikel.idartikel = ? AND voorraad.idVestiging = ?";
    $stmt_edit = $conn->prepare($sql_edit);
    $stmt_edit->bind_param("ii", $idArtikel, $idVestiging);
    $stmt_edit->execute();
    $result_edit = $stmt_edit->get_result();

    // Aanpassen formulier
    if ($result_edit->num_rows > 0) {
        $row_edit = $result_edit->fetch_assoc();
        ?>
        <form action="toolsforever1.php" method="post">
            <input type="hidden" name="idartikel" value="<?php echo $idArtikel; ?>">
            <input type="hidden" name="idvestiging" value="<?php echo $idVestiging; ?>"> <!-- Vestiging ID toegevoegd -->
            aantal<input type="number" name="aantal" value="<?php echo $row_edit['aantal']; ?>"><br>
            <button type="submit" name="save" class="btn btn-success">Opslaan</button>
        </form>
        <?php
    } else {
        echo "<div class='alert alert-danger'>Geen gegevens gevonden voor dit artikel</div>";
    }
    $stmt_edit->close();
}

// Filter locatie optie
$locatieOptie = isset($_POST['opties']) ? $_POST['opties'] : "";

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
                    <th>Acties</th>
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
                    <form action="toolsforever1.php" method="get" style="display:inline;">
                        <input type="hidden" name="idartikel" value="' . $row["idartikel"] . '">
                        <input type="hidden" name="idvestiging" value="' . $row["idVestiging"] . '">
                        <button type="submit" class="btn btn-primary">Edit</button>
                    </form>
                    <form action="delete.php" method="post" style="display:inline;">
                        <input type="hidden" name="id" value="' . $row["idartikel"] . '">
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </td>
              </tr>';
    }
    echo '</tbody></table>';
} else {
    echo "Geen resultaten gevonden.";
}
?>
</body>
</html>