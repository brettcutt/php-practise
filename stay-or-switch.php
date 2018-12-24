<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" type="text/css" href="main.css">
    <title>Document</title>
</head>
<body>
Stick or Stay <br>
<a href="index.php">conundrum</a> <br><br>
    <?php
    
$choices = [1, 2, 3];



$door = $_POST['door'];
$round = $_POST['round'];


//ROUND 1
if ($round == 1) {

    $cpu_choice = $choices[array_rand($choices)];
    $player_choice = $door;

    // ROUND 1 IF THE PLAYERS CHOICE IS EQUAL TO THE CPU
    if ($player_choice == $cpu_choice) {
    $second_choice = [];
    foreach ($choices as $item) {
        if(($item != $player_choice)){
            $second_choice[] = $item;
        }
    }
        
    $other_choice = (string)$second_choice[array_rand($second_choice)];
    $correct_choice = $player_choice;
    $round = 2;

    // ROUND 1 IF THE PLAYERS CHOICE IS NOT EQUAL TO THE CPU
    } else if ($player_choice != $cpu_choice) {

        $other_choice = $cpu_choice;
        $correct_choice = $cpu_choice;
        $round = 2;
    }

    $new_choices[] = $player_choice;
    $new_choices[] = $other_choice;
    sort($new_choices);


//ROUND 2
} else if ($round == 2){

    $correct_choice = $_POST["correct_choice"];
    $player_choice = $_POST["player_choice"];
    $round =3;

}

if ($round == "") {
    $round = 1;
}
//ROUND 1
if ( $round == 1) {
    echo "<br>Round: $round<br>";
    foreach ($choices as $door) {

            echo    "<form class='door' action='stay-or-switch.php' method='POST'>";
            echo       "<input type='hidden' name='round' value=".$round.">";
            echo       "<input type='hidden' name='door' value='".$door."'>";
            echo       "<input type='submit' value='Door ".$door."'>";
            echo    "</form>";
            
    }
//ROUND 2
} else if ( $round ==2 ) {
    echo "<br>Round: $round<br>";

    foreach ($new_choices as $item) {

        echo    "<form class='door' action='stay-or-switch.php' method='POST'>";
        echo       "<input type='hidden' name='round' value=".$round.">";
        echo       "<input type='hidden' name='correct_choice' value=".$correct_choice .">";
        echo       "<input type='hidden' name='player_choice' value='".$item."'>";
        echo       "<input type='submit' value='Door ".$item."'>";
        echo    "</form>";
    }

} else if ( $round == 3) {
    if ( $player_choice == $correct_choice) {
        echo "you win";
    } else {
        echo "You lose";
    }
    echo "<a href='stay-or-switch.php'>Play Again</a>";
}
        echo "<br>";

?>

</body>
</html>