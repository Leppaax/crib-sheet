<?php

// you need the link to the database connection file
// require_once "database-connection.php";

// database name: users

// database columns: 
// userid	
// firstname	
// company	
// password	
// email

// function to add something to database
function addUser($firstname, $company, $password, $email){
    $pdo = connectDB();
    $hashedpassword = hashPassword($password);
    $data = [$firstname, $company, $hashedpassword, $email];
    $sql = "INSERT INTO users (firstname, company, password, email) VALUES(?,?,?,?)";
    $stm=$pdo->prepare($sql);
    return $stm->execute($data);
}

// function to login using firstname and password
function login($firstname, $password){
    $pdo = connectDB();
    $sql = "SELECT * FROM users WHERE firstname=?";
    $stm= $pdo->prepare($sql);
    $stm->execute([$firstname]);
    $user = $stm->fetch(PDO::FETCH_ASSOC);
    $hashedpassword = $user["password"];

    if($hashedpassword && password_verify($password, $hashedpassword))
        return $user;
    else 
        return false;
}

// function to get single info from database using the id
function getUserInfo($id){
    $pdo = connectDB();
    $sql = "SELECT * FROM users WHERE userid=?";
    $stm= $pdo->prepare($sql);
    $stm->execute([$id]);
    $all = $stm->fetch(PDO::FETCH_ASSOC);
    return $all;
}

// function to update the info
function updateUser($firstname, $company, $email, $userid){
    $pdo = connectDB();
    $_SESSION["firstname"] = $firstname;
    $data = [$firstname, $company, $email, $userid];
    $sql = "UPDATE users SET firstname = ?, company = ?, email = ? WHERE userid = ?";
    $stm = $pdo->prepare($sql);
    return $stm->execute($data);
}