<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="apen.php" method="post">
        <label for="apen">Kies een aap:</label>
        <select name="apen" id="apen">
            <option value="aap1">aap1</option>
            <option value="aap2">aap2</option>
            <option value="aap3">aap3</option>
            <option value="aap4">aap4</option>
            <option value="aap5">aap5</option>
        </select>
        <input type="submit" value="Verzenden">
    </form>
    <?php
    $apen = array("aap1" => "Baviaan", "aap2" => "Guereza", "aap3" => "Langoer", "aap4" => "Tamarin", "aap5" => "Neusaap");
    $gekozenAap = $_POST['apen'];
    echo "Gekozen aap: " . $apen[$gekozenAap];
    ?>
</body>
</html>