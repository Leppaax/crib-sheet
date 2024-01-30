<?php


// function for password hash
function hashPassword($password){
    $password = trim($password);
    $hashedpassword = password_hash($password,PASSWORD_DEFAULT);
    return $hashedpassword;
}

// simple function to check if the user is logged in
function isLoggedIn(){
    if(isset($_SESSION['firstname'], $_SESSION['userid']) && ($_SESSION['session_id'] == session_id())){
        return true;
    } else {
        return false;
    }
}