<?php


// This function puts data into pre tags, the tags preserve whitespace and line breaks, making the output easier to read. 
function cleanDump($data){
    echo "<pre>";
    var_dump($data);
    echo "</pre>";
}
// This function is intended to clean up user input.
// It trims any leading or trailing whitespace from the input.
// And it uses filter to sanitize the input as a string, removing any potentially harmful characters.
function cleanUpInput($userinput){
    $input = trim($userinput);
    $cleaninput = filter_var($input,FILTER_SANITIZE_STRING);
    return $cleaninput;
}

// This function is intended to clean up output before displaying it to the user. 
// It trims any leading or trailing whitespace from the output.
// The function uses htmlspecialchars() to convert special characters in the output to their HTML entities, thus preventing potential HTML injection attacks.
function cleanUpOutput($useroutput){
    $output = trim($useroutput);
    $cleanoutput = htmlspecialchars($output);
    return $cleanoutput;
}