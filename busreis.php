<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
    $leeftijd = 65;
    $prijs = 10;
    if($leeftijd > 65){
        $prijs = $prijs * 0.5;
    }
    if($leeftijd <= 12){
        $prijs = $prijs * 0.5;
    }
    if($leeftijd < 3){
        $prijs = 0;
    }
    echo "De prijs is: $prijs";
    ?>
</body>
</html>