<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" type="text/css" href="static/css/main.css">
    <link rel="stylesheet" type="text/css" href="static/js/main.js">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <title>Document</title>
</head>
<body>
    <div class="row center">
        <div class="col-12">
            <h1 class='center'>Stay or Switch</h1> <br>
            <a href="index.php">conundrum</a><br>
            <a href='stay-or-switch.php'>Restart</a>

        </div>

    </div>


<?php
    
$choices = [1, 2, 3];
$door = $_POST['door'];
$round = $_POST['round'];

// READING JSON DATA AND TURNING IT INTO AN ARRAY
$json_data = file_get_contents("results.json");
    $data = json_decode($json_data);
    $stay= $data->stay;
    $switch = $data->switch;
    

//############################################ ROUND 1 LOGIC
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


//############################################ ROUND 2 LOGIC
} else if ($round == 2){

    $correct_choice = $_POST["correct_choice"];
    $player_choice = $_POST["player_choice"];
    $round =3;

}

//############################################ LOGIC END


if ($round == "") {
    $round = 1;
}

// START OF DIV ROW
function startRow(&$round, &$player_choice, &$other_choice) {
    echo "<div class='row center'>";
    echo " <div class='col-12'>";
    echo " <p class='center'><b>Round:</b> ".$round."<p>";

    if ($round == 1) {
        echo " <p class='center'>One of these three doors has a prize behind it. Choose the door you think it is behind.<p>";
    } else if ($round ==2) {
        echo " <p class='center'>You have chosen <b>door ". $player_choice ."</b>. Now you have the option to to stay with your original decision or switch to <b>door ". $other_choice ."</b>.<p>";
    }
    echo " </div>";
}

// END OF DIV ROW
function endRow() {
     echo "</div>";
}

function door(&$item, &$stage) {
    echo "<div class='door-frame inline '>";
    echo "<div class='door-opening'>";
    echo "<div onclick='javascript:this.parentNode.parentNode.parentNode.submit();' class='door".$item." ".$stage."'>";
    echo "<p class='door-number'>".$item."</p>";
    echo "</div>";
    echo "</div>";
    echo "</div>";
 }

//############################################ ROUND 1 HTML
if ( $round == 1) {
    
    startRow($round, $player_choice, $other_choice);
    echo "<div class='col-3'></div>";
    $stage = "hello";
    foreach ($choices as $item) {

            echo "<div class='col-2'>";
            echo    "<form name='form' class='door-btn' action='stay-or-switch.php' method='POST'>";
            echo       "<input type='hidden' name='round' value=".$round.">";
            echo       "<input type='hidden' name='door' value='".$item."'>";
            door($item, $stage = "start");
            echo    "</form>";
            echo    "</div>";
        }

    endRow();


//############################################# ROUND 2 HTML
} else if ( $round ==2 ) {

    startRow($round, $player_choice, $other_choice);
    echo "<div class='col-2'></div>";
    $stage = "hello";
    foreach ($new_choices as $item) {
        echo "<div class='col-4'>";
        echo    "<form name='form' class='door-btn' action='stay-or-switch.php' method='POST'>";
        echo       "<input type='hidden' name='round' value=".$round.">";
        echo       "<input type='hidden' name='correct_choice' value=".$correct_choice .">";
        echo       "<input type='hidden' name='player_choice' value='".$item."'>";
        door($item, $stage = "middle");
        echo    "</form>";
        echo    "</div>";
    }

    endRow();


//######################################### ROUND 3 HTML
} else if ( $round == 3) {
    $round = "Game Over";
    startRow($round, $player_choice, $other_choice);
    echo "<div class='col-6 center'>";
    

    if ( $player_choice == $correct_choice) {

        echo "<p class='center'><b>Well done</b>, door ".$correct_choice." is correct.</p>";
        $stay = (int)$stay + 1;
        $switch = (int)$switch + 0;

    } else {
        echo "<p class='center'><b>Sorry</b>, wrong door. The correct choice was door ".$correct_choice.".</p>";
        $stay = (int)$stay + 0;
        $switch = (int)$switch + 1;

    }
    door($correct_choice, $stage = "end");
    echo "</div>";
    echo "<div class='col-6 center'>";
    $data = ["stay" => (int)$stay, "switch" => $switch];
    $json_data = json_encode($data);
    file_put_contents('results.json', $json_data);
    echo "<br>";
    echo "<p><b>Wins by players:</b></p>";
    echo "<p><b>Staying</b>: ".round(($stay / ($stay+$switch))*100,2)."%</p>";
    echo "<p><b>Switching</b>: ".round(($switch / ($stay+$switch))*100,2)."%</p>";

    echo "</div>";
    endRow();
    echo "<div class='row center'>";
    echo "<div class='col-12'>";
    echo "<a href='stay-or-switch.php'>Play Again</a>";
    echo "</div>";
    echo "</div>";

    // OVER WRITING JSON DATA WITH THE NEW RESULTS
    
}
    

    //$test = fopen("logs.txt" ,"r");
    //while ($line = fgets($test)) {
    //    echo($line);
    //    $line = $line + 1;
    //    echo $line;
    //    file_put_contents('logs.txt', $line);
    //    
    //  }
    //fclose($test);
?>



</body>
</html>

