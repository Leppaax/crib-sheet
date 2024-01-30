<?php

// need these
require_once "./database-user-things.php";
require_once './php-safety.php';


// function controller for the registeration

// the form:

    <form  action="/register" method="post">

        <label for="fname">Etunimi:</label> 
        <input id="fname" type="text" name="firstname" maxlength=30>

        <label for="lname">Sukunimi:</label>         
        <input id="lname" type="text" name="lastname" maxlength=30>

        <label for="birthday">Syntymäpäivä</label>
        <input id="birthday" type="date" name="birthday">

        <label for="uname">Käyttäjänimi:</label>
        <input id="uname" type="text" name="username" maxlength=30>

        <label for="pword">Salasana:</label>
        <input id="pword" type="password" name="password" maxlength=30>
        
        <input id="sendbutton" type="submit" value="Lähetä">
    </form>

function registerController(){
    if(isset($_POST['lastname'], $_POST['firstname'], $_POST['username'], $_POST['password'], $_POST["birthday"])){
        $lastname = cleanUpInput($_POST['lastname']);
        $firstname = cleanUpInput($_POST['firstname']);
        $username = cleanUpInput($_POST['username']);
        $password = cleanUpInput($_POST['password']);
        $birthday = cleanUpInput($_POST["birthday"]);

        try {
            addUser($firstname, $lastname, $username, $password, $birthday);
            header("Location: /login"); 
        } catch (PDOException $e){
            echo "Virhe tietokantaan tallennettaessa: " . $e->getMessage();
        }
    } else {
        require "views/register.view.php";
    }
}

// function controller for the login

// the form 

<form  action="/login" method="post">
    <label for="uname">Käyttäjänimi:</label>
    <input id="uname" type="text" name="username" maxlength=30>
    <label for="pwprd">Salasana:</label>
    <input id="pword" type="password" name="password" maxlength=30>
    <input id="sendbutton" type="submit" value="Lähetä">
</form>

function loginController(){
    if(isset($_POST['username'], $_POST['password'])){
        $username = cleanUpInput($_POST['username']);
        $password = cleanUpInput($_POST['password']);
  
        $result = login($username, $password);
        if($result){
            $_SESSION['username'] = $result['username'];
            $_SESSION['userid'] = $result['userid'];
            $_SESSION['session_id'] = session_id();
            header("Location: /"); 
        } else {
            require "views/login.view.php";
        }
    } else {
        require "views/login.view.php";
    }
}

// function for log out
function logoutController(){
    session_unset(); //remove all variables
    session_destroy();
    setcookie(session_name(),'',0,'/'); //remove the cookie from the browser
    session_regenerate_id(true);
    header("Location: /login"); // forward i.e. redirection
    die();
}