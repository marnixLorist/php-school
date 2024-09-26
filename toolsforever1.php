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
                <a href="toevoegen.php">toevoegen</a>
                <a href="crud.php">uitloggen</a>
            </div>
        </div>
    </header>
    <form action="toolsforever1.php" method="post">
        <label for='opties'>Filter per locatie</label>
        <select name="opties">
            <option value="Almere">Almere</option>
            <option value="Eindhoven">Eindhoven</option>
            <option value="Rotterdam">Rotterdam</option>
        </select>
        <input type="submit" value="submit">
    </form>

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

// Handle delete
if (isset($_POST['delete_id'])) {
    $delete_id = $_POST['delete_id'];
    $sql_delete = "DELETE FROM artikel WHERE idartikel = ?";
    $stmt_delete = $conn->prepare($sql_delete);
    $stmt_delete->bind_param("i", $delete_id);
    $stmt_delete->execute();
    if ($stmt_delete->affected_rows > 0) {
        echo "<div class='alert alert-success'>Record deleted successfully.</div>";
    } else {
        echo "<div class='alert alert-danger'>Failed to delete record.</div>";
    }
}

// Handle edit
if (isset($_POST['edit_id'])) {
    $edit_id = $_POST['edit_id'];
    $sql_edit = "SELECT * FROM artikel WHERE idartikel = ?";
    $stmt_edit = $conn->prepare($sql_edit);
    $stmt_edit->bind_param("i", $edit_id);
    $stmt_edit->execute();
    $edit_result = $stmt_edit->get_result();
    $edit_row = $edit_result->fetch_assoc();

    // Show edit form
    echo '
    <h3>Edit Artikel</h3>
    <form action="toolsforever1.php" method="post">
        <input type="hidden" name="idartikel" value="' . $edit_row["idartikel"] . '">
        <label>Product:</label>
        <input type="text" name="product" value="' . $edit_row["product"] . '"><br>
        <label>Type:</label>
        <input type="text" name="type" value="' . $edit_row["type"] . '"><br>
        <label>Fabriek:</label>
        <input type="text" name="fabriek" value="' . $edit_row["fabriek"] . '"><br>
        <label>Inkoopprijs:</label>
        <input type="text" name="inkoopprijs" value="' . $edit_row["inkoopprijs"] . '"><br>
        <label>Verkoopprijs:</label>
        <input type="text" name="verkoopprijs" value="' . $edit_row["verkoopprijs"] . '"><br>
        <label>Aantal:</label>
        <input type="text" name="aantal" value="' . $edit_row["aantal"] . '"><br>
        <label>Prijs:</label>
        <input type="text" name="prijs" value="' . $edit_row["prijs"] . '"><br>
        <label>Locatie:</label>
        <input type="text" name="locatie" value="' . $edit_row["locatie"] . '"><br>
        <input type="submit" name="update" value="Update">
    </form>
    ';
}

// Update artikel
if (isset($_POST['update'])) {
    $idartikel = $_POST['idartikel'];
    $product = $_POST['product'];
    $type = $_POST['type'];
    $fabriek = $_POST['fabriek'];
    $inkoopprijs = $_POST['inkoopprijs'];
    $verkoopprijs = $_POST['verkoopprijs'];
    $aantal = $_POST['aantal'];
    $prijs = $_POST['prijs'];
    $locatie = $_POST['locatie'];

    $sql_update = "UPDATE artikel SET product=?, type=?, fabriek=?, inkoopprijs=?, verkoopprijs=?, aantal=?, prijs=?, locatie=? WHERE idartikel=?";
    $stmt_update = $conn->prepare($sql_update);
    $stmt_update->bind_param("ssssddisi", $product, $type, $fabriek, $inkoopprijs, $verkoopprijs, $aantal, $prijs, $locatie, $idartikel);

    if ($stmt_update->execute()) {
        echo "<div class='alert alert-success'>Record updated successfully.</div>";
    } else {
        echo "<div class='alert alert-danger'>Failed to update record.</div>";
    }
}

$selectLocatie = isset($_POST["opties"]) ? $_POST["opties"] : null;

if (!empty($selectLocatie)) {
    $sql_select = "SELECT * FROM artikel WHERE locatie = ?";
    $stmt = $conn->prepare($sql_select);
    $stmt->bind_param("s", $selectLocatie);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    $sql_select = "SELECT * FROM artikel";
    $result = $conn->query($sql_select);
}

if ($result->num_rows > 0) {
    echo '<table class="table table-bordered">
            <thead>
                <tr>
                    <th>idartikel</th>
                    <th>product</th>
                    <th>Type</th>
                    <th>Fabriek</th>
                    <th>inkoopprijs</th>
                    <th>verkoopprijs</th>
                    <th>aantal</th>
                    <th>prijs</th>
                    <th>locatie</th>
                    <th>Delete/Edit</th>
                </tr>
            </thead>
            <tbody>';
    while ($row = $result->fetch_assoc()) {
        echo '<tr>
                <td>' . $row["idartikel"] . '</td>
                <td>' . $row["product"] . '</td>
                <td>' . $row["type"] . '</td>
                <td>' . $row["fabriek"] . '</td>
                <td>' . $row["inkoopprijs"] . '</td>
                <td>' . $row["verkoopprijs"] . '</td>
                <td>' . $row["aantal"] . '</td>
                <td>' . $row["prijs"] . '</td>
                <td>' . $row["locatie"] . '</td>
                <td>
                <form method="POST" action="toolsforever1.php">
                    <input type="hidden" name="delete_id" value="' . $row["idartikel"] . '">
                    <input type="submit" name="delete" value="Delete" class="btn btn-danger">
                </form>
                <form method="POST" action="toolsforever1.php">
                    <input type="hidden" name="edit_id" value="' . $row["idartikel"] . '">
                    <input type="submit" name="edit" value="Edit" class="btn btn-primary">
                </form>
                </td>
              </tr>';
    }
    echo '</tbody></table>';
} else {
    echo "<div class='alert alert-info'>No products found.</div>";
}

$conn->close(); // Close the database connection
?>
