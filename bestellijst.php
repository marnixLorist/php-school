<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="bestellijst.css">
    <script src="https://kit.fontawesome.com/e0d2d263ae.js" crossorigin="anonymous"></script>

</head>
<body>
    <header>
        <h2 class="tools">tools<span id="four">4</span>ever<span id="p">.</span></h2>
        <h2 class="Bestel">Bestellijst<span class="punt" >.</span></h2>
        <div class="dropdown">
            <button class="dropbtn"><i class="fa-solid fa-bars"></i></button>
            <div class="dropdown-content">
                <a href="toolsforever.php">home</a>
                <a href="toevoegen.php">toevoegen</a>
                <a href="toolsforever1.php">voorraad</a>
            </div>
        </div>
        </header>
        <p>Tools4Ever © 2024</p>
</body>
</html>

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

$sql_select = "SELECT product, type, fabriek, minimumaantal, aantalTeBestellen FROM BestelLijst";
            $result = $conn->query($sql_select);
echo "<div class='tabel'>";
echo "<table>";
echo "<tr>";
echo "<th>Product</th>";
echo "<th>Type</th>";
echo "<th>Fabriek</th>";
echo "<th>Minimumaantal</th>";
echo "<th>Aantal Te Bestellen</th>";
echo "</tr>"; 


echo "<tr id='yo'>";
echo "<td>locatie: Almere</td>";
echo "<td></td>";
echo "<td>Geleverd: ja</td>"; 
echo "<td>Aangekomen: 01-10-2024</td>";
echo "<td></td>"; 
echo "</tr>";


if ($result->num_rows > 0) {
    $counter = 0;
    while($row = $result->fetch_assoc()) {  
        $counter++;
    echo "<tr>";
    echo "<td>" . $row["product"] . "</td>";
    echo "<td>" . $row["type"] . "</td>";
    echo "<td>" . $row["fabriek"] . "</td>";
    echo "<td>" . $row["minimumaantal"] . "</td>";
    echo "<td>" . $row["aantalTeBestellen"] . "</td>";
    echo "</tr>";
        
    if ($counter == 2) { 
        echo "<tr id='yo'>";
echo "<td>locatie: Eindhoven</td>";
echo "<td></td>";
echo "<td>Geleverd: nee</td>"; 
echo "<td>gepland: 09-10-2024</td>";
echo "<td></td>"; 
echo "</tr>";
    }
}
}

        echo "</table>";
        echo "</div>";

        $conn->close();
        ?>