<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
    $zwemclub = array ("De spartelkuikens" => 10, "De waterbuffels" => 15, "Plonsmderin" => 20, "Bommetje" =>5 );
    foreach($zwemclub as $club => $leden){
        echo $club . "  " . $leden . "  <br>";
        $puntenper = floor($leden / 5);
        echo "er zijn " . $puntenper . " foto's, geen zin om weer foto op te slaan. <br>";
    }

    ?>
</body>
</html>