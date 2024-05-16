<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
    for($i = 1; $i <= 10; $i++){
       echo "<img src='/php school/img/aap" .$i. ".jpg'>";
       //dit kan je doen omdat de afbeeldingen allemaal hetzelfde beginnen en en een nummer hebben die de heletijd ++ gaat
    }
    ?>
</body>
</html>