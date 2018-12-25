<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="static/css/main.css">
    <title>Document</title>
</head>
<body>
    <div class="container">
    <nav>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="stay-or-switch.php">Stay or Switch</a></li>
                <li><a href="conundrum.php">Conundrum</a></li>
            </ul>
        </nav>
        <div class="row">
            <div class="col-12 center">
                
            
<?php

$data = '{
    "What is always coming but never arrives?":"tomorrow",
"I am black when clean and white when dirty. What am I?":"chalkboard",
"Sometimes I walk in front of you. Sometimes I walk behind you. It is only in the dark that I ever leave you. What am I?":"shadow",
"What comes down but never goes up?":"rain",
"What has a bed but doesn\'t sleep and a mouth but never eats?":"river",
"I\'m always hungry and must be fed, the finger I touch will soon turn red, what am I?":"fire",
"I can\'t be seen but I\'m not a ghost. I can crack but I don\'t break. I can clap but I don\'t have any hands. I happen after a flash but I\'m not a photo. I\'m loud but I\'m not music. What am I?":"thunder",
"Who makes it, has no need of it. Who buys it, has no use for it. Who uses it doesn\'t know it. What is it?":"coffin",
"I have seas without water, coasts without sand, towns without people and mountains without land. What am I?":"map",
"I don\'t have eyes, but once I did see. Once I had thoughts, but now I\'m white and empty. What am I?":"skull"
}';
$data = json_decode($data, true);

$guess = $_POST['guess'];
$counter = $_POST['counter'];
$attempt = $_POST['attempt'];
$score = $_POST['score'];

if ($counter == "") {
    $counter = 0;
}
if ($attempt == "") {
    $attempt = 5;
}
if ($score == "") {
    $score = 0;
}


$keys = array_keys($data);

$question =  $keys[$counter];
$answer = $data[$keys[$counter]];
if ($guess == "" && $counter == 0 ) {
    echo "<h1>Welcome!</h1>";
    $question =  $keys[0];
} else if ($guess == $answer) {
    echo "<h1>Correct, well done!</h1>";
    $score = ($score + 10) - ((5 - $attempt)*2);
    $attempt = 5;
    $counter = $counter + 1;
} else if ($attempt == 1) {
    echo "<h1>Next Question!</h1>";
    $attempt = 5;
    $counter = $counter + 1;
    
} else if  ( $guess != $answer){
    echo "<h1>Incorrect, try again!</h1>";
    $attempt = $attempt - 1;
    $counter = $counter;
} 

    echo "<p><b>Question:</b> ". ($counter + 1) ." of 10</p>";
    echo "<p><b>Attempts Left:</b> ".$attempt."</p>";
    echo "<p><b>Score:</b> ". $score ."</p>";
    $question =  $keys[$counter];
    $answer = $data[$keys[$counter]];
    echo "<h3>" . $question . "</h3>";
    echo " <form action='conundrum.php' method='POST'>";
    echo "<input required name='guess' type='text'>";
    echo "<input type='hidden' name='attempt' value='" . $attempt . "'>";
    echo "<input type='hidden' name='counter' value='" . $counter . "'>";
    echo "<input type='hidden' name='score' value='" . $score . "'>";
    echo "<br>";
    echo "<input class='btn' type='submit' value='Submit'></form>";

?>
            </div>
        </div>

    </div>
</body>
</html>