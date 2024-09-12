<?php
     $servername = "mysql";
     $username = "root";
     $password = "password";
     
     // Create connection
     $conn = new mysqli($servername, $username, $password, "toolsForEver");
     
     // Check connection
     if ($conn->connect_error) {
         die("Connection failed: " . $conn->connect_error);
     }else
     ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="toevoegen.css">
</head>
<body>
    <header>
        <h2 class="tools">tools<span id="four">4</span>ever<span id="p">.</span></h2>
        <h2 class="voegen">toevoegen<span class="punt" >.</span></h2>
    </header>
    <main>
    <form action="toolsforever1.php" method="POST" > 
        <label for="locatie">Kies een locatie</label>
        <select name="locatie" id="locatie">
            <option value="Rotterdam"  name="Rotterdam">Rotterdam</option>
            <option value="Almere" name="Almere">Almere</option>
            <option value="Eindhoven"  name="Eindhoven">Eindhoven</option>
        </select>
     </form>
    </main>
</body>
</html>